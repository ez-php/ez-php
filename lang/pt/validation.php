<?php

declare(strict_types=1);

return [
    'required' => 'O campo :field é obrigatório.',
    'string' => 'O campo :field deve ser uma string.',
    'integer' => 'O campo :field deve ser um número inteiro.',
    'email' => 'O campo :field deve ser um endereço de e-mail válido.',
    'regex' => 'O formato do campo :field é inválido.',
    'unique' => 'O valor do campo :field já está em uso.',
    'exists' => 'O valor selecionado para :field é inválido.',
    'min' => [
        'string' => 'O campo :field deve ter pelo menos :min caracteres.',
        'numeric' => 'O campo :field deve ser pelo menos :min.',
    ],
    'max' => [
        'string' => 'O campo :field não deve exceder :max caracteres.',
        'numeric' => 'O campo :field não deve exceder :max.',
    ],
];
