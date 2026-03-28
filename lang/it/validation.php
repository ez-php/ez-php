<?php

declare(strict_types=1);

return [
    'required' => 'Il campo :field è obbligatorio.',
    'string' => 'Il campo :field deve essere una stringa.',
    'integer' => 'Il campo :field deve essere un numero intero.',
    'email' => 'Il campo :field deve essere un indirizzo e-mail valido.',
    'regex' => 'Il formato del campo :field non è valido.',
    'unique' => 'Il valore del campo :field è già in uso.',
    'exists' => 'Il valore selezionato per :field non è valido.',
    'min' => [
        'string' => 'Il campo :field deve contenere almeno :min caratteri.',
        'numeric' => 'Il campo :field deve essere almeno :min.',
    ],
    'max' => [
        'string' => 'Il campo :field non deve superare :max caratteri.',
        'numeric' => 'Il campo :field non deve superare :max.',
    ],
];
