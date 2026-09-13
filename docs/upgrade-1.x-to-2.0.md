# Upgrading from 1.x to 2.0

2.0 lets controllers return streamed responses (downloads, Server-Sent Events) that travel
through the middleware pipeline. That required widening the response contract, so code that
implements framework interfaces needs small changes.

## 1. Custom middleware: return `ResponseInterface`

A middleware that returns `$next()`'s result must not narrow the type to `Response` — the next
handler may return a `StreamedResponse`, and a `: Response` return type turns that into a
`TypeError`.

```php
// 1.x
public function handle(RequestInterface $request, callable $next): Response
{
    /** @var Response $response */
    $response = $next($request);
    return $response->withHeader('X-Foo', 'bar');
}

// 2.0
public function handle(RequestInterface $request, callable $next): ResponseInterface
{
    /** @var ResponseInterface $response */
    $response = $next($request);
    return $response->withHeader('X-Foo', 'bar');
}
```

`withHeader()`, `withCookie()` and `cookies()` are on `ResponseInterface` now. The `@var` is
accurate: every `$next` the pipeline passes in is declared to return `ResponseInterface`.

## 2. Custom exception handlers: add `report()`

`ExceptionHandlerInterface` gained `report(Throwable $e, RequestInterface $request): void`. The
kernel calls `report()` and then `render()`; for a stream that fails after its headers were sent,
it calls only `report()`. Move logging out of `render()` into `report()`, or it runs twice.

```php
public function report(Throwable $e, RequestInterface $request): void
{
    $this->logger->error($e->getMessage());
}

public function render(Throwable $e, RequestInterface $request): ResponseInterface
{
    return new Response('Something went wrong', 500);
}
```

`report()` must not throw.

## 3. Custom `TerminableMiddleware`: parameter type

```php
// 1.x
public function terminate(Request $request, Response $response): void

// 2.0
public function terminate(Request $request, ResponseInterface $response): void
```

## 4. `public/index.php`: use `send()`

```php
// 1.x
$response = $app->handle($request);
(new ResponseEmitter())->emit($response);

// 2.0
$app->send($request, $app->handle($request));
```

`handle()` no longer calls `terminate()`. `send()` emits the response and then runs terminable
middleware.

## 5. Reading the body

`body()` is no longer on `ResponseInterface` — a stream has no string body. Where a value is typed
`ResponseInterface`, check first:

```php
if ($response instanceof Response) {
    $html = $response->body();
}
```

In tests, `TestResponse` (from `HttpTestCase`) still offers `body()` for every response type. In
tests that call `$app->handle()` or a middleware directly, add
`self::assertInstanceOf(Response::class, $response);` before `->body()`.

## 6. Resource controllers

`ResourceControllerInterface` methods now declare `ResponseInterface|string`. Existing controllers
that declare `Response|string` keep working unchanged; declare `ResponseInterface|string` only
where an action streams.

## 7. Server-Sent Events: `SseResponse` → `StreamedResponse::sse()`

`EzPhp\Broadcast\Sse\SseStream` and `SseResponse` were removed, and `SseEvent` moved to
`EzPhp\Http\Sse\SseEvent`.

```php
// 1.x — bypassed middleware and terminate()
$response = new SseResponse($this->events());
$response->emit();
exit;

// 2.0 — a normal controller return value
return StreamedResponse::sse(fn () => $this->events());
```

## 8. Do checks before returning a stream

A `StreamedResponse` sends its headers before the first chunk. An exception thrown inside the
chunk generator can no longer become an error page — it is reported and the stream ends (SSE
streams get a generic `event: error` frame). Check authorisation, validate input and confirm the
file exists **before** returning the response.

## 9. Behaviour change: when `terminate()` runs

In 1.x `terminate()` ran inside `handle()`, before the response was sent. In 2.0 it runs after the
response has been sent — after the last chunk of a stream — and it still runs when the client
disconnects early.

## 10. AI streams are incremental and can fail mid-way

`ez-php/ai` streams are now read from the provider while it generates. Three things behave differently:

| | 1.x | 2.0 |
|---|---|---|
| Connection drops, provider sends an error event, or the stream ends without its completion signal | The stream ended silently and looked complete | `AiStreamException` while iterating or in `collect()` |
| Gemini completion | No final chunk | One extra `AiChunk` with empty content and a `FinishReason` |
| When `stream()` returns | After the whole answer | After the response headers; the connection stays open until the stream is consumed, dropped or closed |

```php
use EzPhp\Ai\AiStreamException;

try {
    $text = $client->stream($request)->collect();
} catch (AiStreamException $e) {
    // handle an incomplete answer
}
```

`StreamedResponse::sse(fn () => $stream->toSseEvents())` handles the exception for you. Consume streams right away; do not keep `AiStream` objects around. `AI_STREAM_IDLE_TIMEOUT` (default 120) replaces the 30-second total timeout for streams.

Custom `ez-php/http-client` transports keep working unchanged; they only need `StreamingTransportInterface` if you call `HttpRequest::stream()` through them.
