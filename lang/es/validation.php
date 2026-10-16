<?php

declare(strict_types=1);

return [
    'required' => 'El campo :field es obligatorio.',
    'string' => 'El campo :field debe ser una cadena de texto.',
    'integer' => 'El campo :field debe ser un número entero.',
    'email' => 'El campo :field debe ser una dirección de correo electrónico válida.',
    'regex' => 'El formato del campo :field es inválido.',
    'unique' => 'El valor del campo :field ya está en uso.',
    'exists' => 'El valor seleccionado para :field es inválido.',
    'min' => [
        'string' => 'El campo :field debe tener al menos :min caracteres.',
        'numeric' => 'El campo :field debe ser al menos :min.',
    ],
    'max' => [
        'string' => 'El campo :field no debe superar :max caracteres.',
        'numeric' => 'El campo :field no debe superar :max.',
    ],
    'confirmed' => 'La confirmación de :field no coincide.',
    'same' => 'Los campos :field y :other deben coincidir.',
    'different' => 'Los campos :field y :other deben ser diferentes.',
    'file' => 'El campo :field debe ser un archivo subido válido.',
    'image' => 'El campo :field debe ser una imagen.',
    'date' => 'El campo :field no es una fecha válida.',
    'date_format' => 'El campo :field no coincide con el formato :format.',
    'before' => 'El campo :field debe ser una fecha anterior a :date.',
    'after' => 'El campo :field debe ser una fecha posterior a :date.',
    'before_or_equal' => 'El campo :field debe ser una fecha anterior o igual a :date.',
    'after_or_equal' => 'El campo :field debe ser una fecha posterior o igual a :date.',
    'mimes' => 'El campo :field debe ser un archivo de tipo: :values.',
    'max_size' => 'El campo :field no debe superar los :max kilobytes.',
    'dimensions' => 'El campo :field tiene dimensiones de imagen no válidas.',
    'in' => 'El campo :field debe ser uno de: :values.',
    'not_in' => 'El campo :field no debe ser ninguno de: :values.',
    'array' => 'El campo :field debe ser un array.',
    'between' => [
        'string' => 'El campo :field debe tener entre :min y :max caracteres.',
        'numeric' => 'El campo :field debe estar entre :min y :max.',
    ],
    'boolean' => 'El campo :field debe ser verdadero o falso.',
    'uuid' => 'El campo :field debe ser un UUID válido.',
    'alpha' => 'El campo :field solo puede contener letras.',
    'alpha_num' => 'El campo :field solo puede contener letras y números.',
    'alpha_dash' => 'El campo :field solo puede contener letras, números, guiones y guiones bajos.',
    'distinct' => 'El campo :field tiene un valor duplicado.',
];
