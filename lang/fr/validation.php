<?php

declare(strict_types=1);

return [
    'required' => 'Le champ :field est obligatoire.',
    'string' => 'Le champ :field doit être une chaîne de caractères.',
    'integer' => 'Le champ :field doit être un nombre entier.',
    'email' => 'Le champ :field doit être une adresse e-mail valide.',
    'regex' => 'Le format du champ :field est invalide.',
    'unique' => 'La valeur du champ :field est déjà utilisée.',
    'exists' => 'La valeur sélectionnée pour :field est invalide.',
    'min' => [
        'string' => 'Le champ :field doit contenir au moins :min caractères.',
        'numeric' => 'Le champ :field doit être au moins égal à :min.',
    ],
    'max' => [
        'string' => 'Le champ :field ne doit pas dépasser :max caractères.',
        'numeric' => 'Le champ :field ne doit pas dépasser :max.',
    ],
];
