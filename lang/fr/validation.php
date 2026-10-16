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
    'confirmed' => 'La confirmation du champ :field ne correspond pas.',
    'same' => 'Les champs :field et :other doivent correspondre.',
    'different' => 'Les champs :field et :other doivent être différents.',
    'file' => 'Le champ :field doit être un fichier téléversé valide.',
    'image' => 'Le champ :field doit être une image.',
    'date' => 'Le champ :field n\'est pas une date valide.',
    'date_format' => 'Le champ :field ne correspond pas au format :format.',
    'before' => 'Le champ :field doit être une date antérieure au :date.',
    'after' => 'Le champ :field doit être une date postérieure au :date.',
    'before_or_equal' => 'Le champ :field doit être une date antérieure ou égale au :date.',
    'after_or_equal' => 'Le champ :field doit être une date postérieure ou égale au :date.',
    'mimes' => 'Le champ :field doit être un fichier de type : :values.',
    'max_size' => 'Le champ :field ne doit pas dépasser :max kilo-octets.',
    'dimensions' => 'Le champ :field a des dimensions d\'image non valides.',
    'in' => 'Le champ :field doit être l\'une des valeurs suivantes : :values.',
    'not_in' => 'Le champ :field ne doit être aucune des valeurs suivantes : :values.',
    'array' => 'Le champ :field doit être un tableau.',
    'between' => [
        'string' => 'Le champ :field doit contenir entre :min et :max caractères.',
        'numeric' => 'Le champ :field doit être compris entre :min et :max.',
    ],
    'boolean' => 'Le champ :field doit être vrai ou faux.',
    'uuid' => 'Le champ :field doit être un UUID valide.',
    'alpha' => 'Le champ :field ne doit contenir que des lettres.',
    'alpha_num' => 'Le champ :field ne doit contenir que des lettres et des chiffres.',
    'alpha_dash' => 'Le champ :field ne doit contenir que des lettres, des chiffres, des tirets et des tirets bas.',
    'distinct' => 'Le champ :field contient une valeur en double.',
];
