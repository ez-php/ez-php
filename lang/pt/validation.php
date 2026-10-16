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
    'confirmed' => 'A confirmação de :field não corresponde.',
    'same' => 'Os campos :field e :other devem coincidir.',
    'different' => 'Os campos :field e :other devem ser diferentes.',
    'file' => 'O campo :field deve ser um arquivo enviado válido.',
    'image' => 'O campo :field deve ser uma imagem.',
    'date' => 'O campo :field não é uma data válida.',
    'date_format' => 'O campo :field não corresponde ao formato :format.',
    'before' => 'O campo :field deve ser uma data anterior a :date.',
    'after' => 'O campo :field deve ser uma data posterior a :date.',
    'before_or_equal' => 'O campo :field deve ser uma data anterior ou igual a :date.',
    'after_or_equal' => 'O campo :field deve ser uma data posterior ou igual a :date.',
    'mimes' => 'O campo :field deve ser um arquivo do tipo: :values.',
    'max_size' => 'O campo :field não pode exceder :max kilobytes.',
    'dimensions' => 'O campo :field tem dimensões de imagem inválidas.',
    'in' => 'O campo :field deve ser um dos seguintes: :values.',
    'not_in' => 'O campo :field não pode ser nenhum dos seguintes: :values.',
    'array' => 'O campo :field deve ser um array.',
    'between' => [
        'string' => 'O campo :field deve ter entre :min e :max caracteres.',
        'numeric' => 'O campo :field deve estar entre :min e :max.',
    ],
    'boolean' => 'O campo :field deve ser verdadeiro ou falso.',
    'uuid' => 'O campo :field deve ser um UUID válido.',
    'alpha' => 'O campo :field só pode conter letras.',
    'alpha_num' => 'O campo :field só pode conter letras e números.',
    'alpha_dash' => 'O campo :field só pode conter letras, números, hífens e sublinhados.',
    'distinct' => 'O campo :field tem um valor duplicado.',
];
