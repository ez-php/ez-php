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
];
