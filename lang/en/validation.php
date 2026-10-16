<?php

declare(strict_types=1);

return [
    'required' => 'The :field field is required.',
    'string' => 'The :field field must be a string.',
    'integer' => 'The :field field must be an integer.',
    'email' => 'The :field field must be a valid email address.',
    'regex' => 'The :field field format is invalid.',
    'unique' => 'The :field has already been taken.',
    'exists' => 'The selected :field is invalid.',
    'min' => [
        'string' => 'The :field field must be at least :min characters.',
        'numeric' => 'The :field field must be at least :min.',
    ],
    'max' => [
        'string' => 'The :field field must not exceed :max characters.',
        'numeric' => 'The :field field must not exceed :max.',
    ],
    'confirmed' => 'The :field confirmation does not match.',
    'same' => 'The :field and :other must match.',
    'different' => 'The :field and :other must be different.',
    'file' => 'The :field must be a valid uploaded file.',
    'image' => 'The :field must be an image.',
    'date' => 'The :field is not a valid date.',
    'date_format' => 'The :field does not match the format :format.',
    'before' => 'The :field must be a date before :date.',
    'after' => 'The :field must be a date after :date.',
    'before_or_equal' => 'The :field must be a date before or equal to :date.',
    'after_or_equal' => 'The :field must be a date after or equal to :date.',
    'mimes' => 'The :field must be a file of type: :values.',
    'max_size' => 'The :field must not exceed :max kilobytes.',
    'dimensions' => 'The :field has invalid image dimensions.',
    'in' => 'The :field must be one of: :values.',
    'not_in' => 'The :field must not be one of: :values.',
    'array' => 'The :field must be an array.',
    'between' => [
        'string' => 'The :field must be between :min and :max characters.',
        'numeric' => 'The :field must be between :min and :max.',
    ],
    'boolean' => 'The :field field must be true or false.',
    'uuid' => 'The :field must be a valid UUID.',
    'alpha' => 'The :field field must only contain letters.',
    'alpha_num' => 'The :field field must only contain letters and numbers.',
    'alpha_dash' => 'The :field field must only contain letters, numbers, dashes, and underscores.',
    'distinct' => 'The :field field has a duplicate value.',
];
