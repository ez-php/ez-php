<?php

declare(strict_types=1);

return [
    'required' => 'Pole :field jest wymagane.',
    'string' => 'Pole :field musi być ciągiem znaków.',
    'integer' => 'Pole :field musi być liczbą całkowitą.',
    'email' => 'Pole :field musi być prawidłowym adresem e-mail.',
    'regex' => 'Format pola :field jest nieprawidłowy.',
    'unique' => 'Wartość pola :field jest już zajęta.',
    'exists' => 'Wybrana wartość pola :field jest nieprawidłowa.',
    'min' => [
        'string' => 'Pole :field musi zawierać co najmniej :min znaków.',
        'numeric' => 'Pole :field musi wynosić co najmniej :min.',
    ],
    'max' => [
        'string' => 'Pole :field nie może przekraczać :max znaków.',
        'numeric' => 'Pole :field nie może przekraczać :max.',
    ],
];
