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
];
