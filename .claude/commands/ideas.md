---
description: Search this application for forward-looking ideas and sort them into two backlogs — project-specific ideas go to IDEAS.md, ideas generic enough to be a new or enhanced ez-php/* module go to EZ_PHP_IDEAS.md.
---

# Ideas Scan (Application)

Search this application — `app/`, `config/`, `provider/`, `routes/`, `database/`, `tests/`, and this project's own `CLAUDE.md` — for forward-looking ideas: features worth adding, enhancements worth making, gaps worth filling. Sort every idea into exactly one of two files:

- **`IDEAS.md`** — ideas specific to this application's domain. Would make no sense reused elsewhere.
- **`EZ_PHP_IDEAS.md`** — ideas generic enough to be a new or enhanced `ez-php/*` module. Per this project's `CLAUDE.md` → "Module Policy", generic functionality belongs in a module, not as one-off app code — this file is where those ideas get parked until someone builds the module.

This is **not** an audit. `/audit-app` finds defects, drift, and structural non-compliance in what exists. This command finds opportunities — things that don't exist yet and could be added. Do not duplicate audit findings here — those belong in `TODO.md` via `/audit-app` instead.

## How to tell the two apart

Ask: "would this be useful in a *different* ez-php application, with no changes beyond configuration?"

- Yes, and no existing `ez-php/*` module covers it (check the monorepo's `CLAUDE.md` module list and `ez-php/docs/CONFIG.md` for what's already installed/available) → `EZ_PHP_IDEAS.md`.
- Yes, but an existing module already covers it, just not installed or not fully used → this isn't a new idea, it's a `/audit-app` finding (installed-but-unused or missing-config) — skip it here.
- No, it's tied to this application's specific domain/data model/business rules → `IDEAS.md`.

When genuinely unsure, prefer `IDEAS.md` — a wrongly-generic idea sitting in the project backlog is harmless; a domain-specific idea polluting the ez-php module backlog creates noise for whoever later reviews it upstream.

## Scope

Read across:
- `app/Controllers/`, `app/Middleware/`, `app/Entities/`, `app/Repositories/`, `app/Providers/` — look for repeated patterns that could be extracted, missing capabilities the domain clearly needs next, or hand-rolled logic that duplicates what an `ez-php/*` module already does elsewhere
- `config/*.php` and `provider/modules.php` — installed modules and how they're configured, to spot gaps
- `routes/web.php` — what the API/app surface currently covers vs. what it's clearly building toward
- `database/migrations/` — schema direction, to spot upcoming domain needs
- This project's own `CLAUDE.md` "What does not belong here" section — anything noted there as out-of-scope for `app/` is a candidate `EZ_PHP_IDEAS.md` entry, not something to build locally
- `TODO.md` if present — do not duplicate its entries, but a resolved TODO can reveal a follow-up idea

Also check whether any idea already sitting in `IDEAS.md` or `EZ_PHP_IDEAS.md` has since been implemented — if so, remove it (verify against actual code first, don't remove just because it looks plausible).

## What NOT to collect

- Bug fixes, security issues, missing tests, stale docs, structural non-compliance — run `/audit-app` instead.
- Anything violating the project's coding guidelines (minimal core, no heavy dependencies, no premature abstraction, YAGNI).
- Purely cosmetic suggestions.
- An idea covered by a module that's already installed and configured — that's a wiring gap, not an idea.

## Output format

**`IDEAS.md`** — keep its existing sections, add checklist items:

```markdown
## Features

- [ ] <idea> — **Why:** what gap this fills, referencing the specific file/route/entity that suggested it. **Scope:** rough boundary of what it would/wouldn't include.
```

**`EZ_PHP_IDEAS.md`** — keep its existing sections (mirrors the monorepo's own file), add checklist items:

```markdown
## New Modules

- [ ] `ez-php/<name>` — one-line pitch. **Why:** what this application needed that no existing module covers, referencing the specific file that suggested it. **Scope:** rough boundary.

## Existing Module Enhancements

- [ ] `ez-php/<name>`: <idea> — **Why:** ... **Scope:** ...
```

Restore a section's `_(no open ideas yet)_` placeholder only if it ends up with zero entries after a scan; remove it once a section has at least one entry.

## Rules

- Do NOT implement anything — scan and record only.
- Do NOT touch `TODO.md` — that's reserved for `/audit-app` findings.
- Every idea must cite what prompted it (a specific file or gap) — no vague generic suggestions.
- Merge with existing content in both files: keep ideas already listed unless clearly implemented since (verify in code before removing), avoid near-duplicates.
- When done, report a short summary: how many ideas went to `IDEAS.md`, how many to `EZ_PHP_IDEAS.md`, how many removed as already-implemented, and the total count now in each file.
