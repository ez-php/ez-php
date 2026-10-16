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
    'confirmed' => 'La conferma di :field non corrisponde.',
    'same' => 'I campi :field e :other devono coincidere.',
    'different' => 'I campi :field e :other devono essere diversi.',
    'file' => 'Il campo :field deve essere un file caricato valido.',
    'image' => 'Il campo :field deve essere un\'immagine.',
    'date' => 'Il campo :field non è una data valida.',
    'date_format' => 'Il campo :field non corrisponde al formato :format.',
    'before' => 'Il campo :field deve essere una data precedente a :date.',
    'after' => 'Il campo :field deve essere una data successiva a :date.',
    'before_or_equal' => 'Il campo :field deve essere una data precedente o uguale a :date.',
    'after_or_equal' => 'Il campo :field deve essere una data successiva o uguale a :date.',
    'mimes' => 'Il campo :field deve essere un file di tipo: :values.',
    'max_size' => 'Il campo :field non deve superare :max kilobyte.',
    'dimensions' => 'Il campo :field ha dimensioni dell\'immagine non valide.',
    'in' => 'Il campo :field deve essere uno tra: :values.',
    'not_in' => 'Il campo :field non deve essere uno tra: :values.',
    'array' => 'Il campo :field deve essere un array.',
    'between' => [
        'string' => 'Il campo :field deve contenere tra :min e :max caratteri.',
        'numeric' => 'Il campo :field deve essere compreso tra :min e :max.',
    ],
    'boolean' => 'Il campo :field deve essere vero o falso.',
    'uuid' => 'Il campo :field deve essere un UUID valido.',
    'alpha' => 'Il campo :field può contenere solo lettere.',
    'alpha_num' => 'Il campo :field può contenere solo lettere e numeri.',
    'alpha_dash' => 'Il campo :field può contenere solo lettere, numeri, trattini e trattini bassi.',
    'distinct' => 'Il campo :field contiene un valore duplicato.',
];
