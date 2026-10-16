<?php

declare(strict_types=1);

return [
    'required' => 'Het veld :field is verplicht.',
    'string' => 'Het veld :field moet een tekstreeks zijn.',
    'integer' => 'Het veld :field moet een geheel getal zijn.',
    'email' => 'Het veld :field moet een geldig e-mailadres zijn.',
    'regex' => 'Het formaat van het veld :field is ongeldig.',
    'unique' => 'De waarde van het veld :field is al in gebruik.',
    'exists' => 'De geselecteerde waarde voor :field is ongeldig.',
    'min' => [
        'string' => 'Het veld :field moet minimaal :min tekens bevatten.',
        'numeric' => 'Het veld :field moet minimaal :min zijn.',
    ],
    'max' => [
        'string' => 'Het veld :field mag niet meer dan :max tekens bevatten.',
        'numeric' => 'Het veld :field mag niet meer dan :max zijn.',
    ],
    'confirmed' => 'De bevestiging van :field komt niet overeen.',
    'same' => ':field en :other moeten overeenkomen.',
    'different' => ':field en :other moeten verschillen.',
    'file' => 'Het veld :field moet een geldig geüpload bestand zijn.',
    'image' => 'Het veld :field moet een afbeelding zijn.',
    'date' => 'Het veld :field is geen geldige datum.',
    'date_format' => 'Het veld :field komt niet overeen met het formaat :format.',
    'before' => 'Het veld :field moet een datum vóór :date zijn.',
    'after' => 'Het veld :field moet een datum na :date zijn.',
    'before_or_equal' => 'Het veld :field moet een datum vóór of gelijk aan :date zijn.',
    'after_or_equal' => 'Het veld :field moet een datum na of gelijk aan :date zijn.',
    'mimes' => 'Het veld :field moet een bestand van het type :values zijn.',
    'max_size' => 'Het veld :field mag niet groter zijn dan :max kilobytes.',
    'dimensions' => 'Het veld :field heeft ongeldige afbeeldingsafmetingen.',
    'in' => 'Het veld :field moet een van de volgende waarden zijn: :values.',
    'not_in' => 'Het veld :field mag geen van de volgende waarden zijn: :values.',
    'array' => 'Het veld :field moet een array zijn.',
    'between' => [
        'string' => 'Het veld :field moet tussen :min en :max tekens lang zijn.',
        'numeric' => 'Het veld :field moet tussen :min en :max liggen.',
    ],
    'boolean' => 'Het veld :field moet waar of onwaar zijn.',
    'uuid' => 'Het veld :field moet een geldige UUID zijn.',
    'alpha' => 'Het veld :field mag alleen letters bevatten.',
    'alpha_num' => 'Het veld :field mag alleen letters en cijfers bevatten.',
    'alpha_dash' => 'Het veld :field mag alleen letters, cijfers, streepjes en underscores bevatten.',
    'distinct' => 'Het veld :field bevat een dubbele waarde.',
];
