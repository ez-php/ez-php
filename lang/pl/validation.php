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
    'confirmed' => 'Potwierdzenie pola :field nie zgadza się.',
    'same' => 'Pola :field i :other muszą być zgodne.',
    'different' => 'Pola :field i :other muszą się różnić.',
    'file' => 'Pole :field musi być prawidłowo przesłanym plikiem.',
    'image' => 'Pole :field musi być obrazem.',
    'date' => 'Pole :field nie jest prawidłową datą.',
    'date_format' => 'Pole :field nie pasuje do formatu :format.',
    'before' => 'Pole :field musi być datą wcześniejszą niż :date.',
    'after' => 'Pole :field musi być datą późniejszą niż :date.',
    'before_or_equal' => 'Pole :field musi być datą wcześniejszą lub równą :date.',
    'after_or_equal' => 'Pole :field musi być datą późniejszą lub równą :date.',
    'mimes' => 'Pole :field musi być plikiem typu: :values.',
    'max_size' => 'Pole :field nie może przekraczać :max kilobajtów.',
    'dimensions' => 'Pole :field ma nieprawidłowe wymiary obrazu.',
    'in' => 'Pole :field musi mieć jedną z wartości: :values.',
    'not_in' => 'Pole :field nie może mieć żadnej z wartości: :values.',
    'array' => 'Pole :field musi być tablicą.',
    'between' => [
        'string' => 'Pole :field musi zawierać od :min do :max znaków.',
        'numeric' => 'Pole :field musi mieścić się w przedziale od :min do :max.',
    ],
    'boolean' => 'Pole :field musi mieć wartość prawda lub fałsz.',
    'uuid' => 'Pole :field musi być prawidłowym identyfikatorem UUID.',
    'alpha' => 'Pole :field może zawierać wyłącznie litery.',
    'alpha_num' => 'Pole :field może zawierać wyłącznie litery i cyfry.',
    'alpha_dash' => 'Pole :field może zawierać wyłącznie litery, cyfry, myślniki i podkreślenia.',
    'distinct' => 'Pole :field zawiera zduplikowaną wartość.',
];
