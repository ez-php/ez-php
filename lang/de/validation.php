<?php

declare(strict_types=1);

return [
    'required' => 'Das Feld :field ist erforderlich.',
    'string' => 'Das Feld :field muss eine Zeichenkette sein.',
    'integer' => 'Das Feld :field muss eine ganze Zahl sein.',
    'email' => 'Das Feld :field muss eine gültige E-Mail-Adresse sein.',
    'regex' => 'Das Format des Feldes :field ist ungültig.',
    'unique' => 'Der Wert für :field ist bereits vergeben.',
    'exists' => 'Der ausgewählte Wert für :field ist ungültig.',
    'min' => [
        'string' => 'Das Feld :field muss mindestens :min Zeichen lang sein.',
        'numeric' => 'Das Feld :field muss mindestens :min betragen.',
    ],
    'max' => [
        'string' => 'Das Feld :field darf höchstens :max Zeichen lang sein.',
        'numeric' => 'Das Feld :field darf höchstens :max betragen.',
    ],
    'confirmed' => 'Die Bestätigung von :field stimmt nicht überein.',
    'same' => ':field und :other müssen übereinstimmen.',
    'different' => ':field und :other müssen sich unterscheiden.',
    'file' => 'Das Feld :field muss eine gültige hochgeladene Datei sein.',
    'image' => 'Das Feld :field muss ein Bild sein.',
    'date' => 'Das Feld :field ist kein gültiges Datum.',
    'date_format' => 'Das Feld :field entspricht nicht dem Format :format.',
    'before' => 'Das Feld :field muss ein Datum vor :date sein.',
    'after' => 'Das Feld :field muss ein Datum nach :date sein.',
    'before_or_equal' => 'Das Feld :field muss ein Datum vor oder gleich :date sein.',
    'after_or_equal' => 'Das Feld :field muss ein Datum nach oder gleich :date sein.',
    'mimes' => 'Das Feld :field muss eine Datei des Typs :values sein.',
    'max_size' => 'Das Feld :field darf höchstens :max Kilobyte groß sein.',
    'dimensions' => 'Das Feld :field hat ungültige Bildabmessungen.',
    'in' => 'Das Feld :field muss einer der folgenden Werte sein: :values.',
    'not_in' => 'Das Feld :field darf keiner der folgenden Werte sein: :values.',
    'array' => 'Das Feld :field muss ein Array sein.',
    'between' => [
        'string' => 'Das Feld :field muss zwischen :min und :max Zeichen lang sein.',
        'numeric' => 'Das Feld :field muss zwischen :min und :max liegen.',
    ],
    'boolean' => 'Das Feld :field muss wahr oder falsch sein.',
    'uuid' => 'Das Feld :field muss eine gültige UUID sein.',
    'alpha' => 'Das Feld :field darf nur Buchstaben enthalten.',
    'alpha_num' => 'Das Feld :field darf nur Buchstaben und Zahlen enthalten.',
    'alpha_dash' => 'Das Feld :field darf nur Buchstaben, Zahlen, Binde- und Unterstriche enthalten.',
    'distinct' => 'Das Feld :field enthält einen doppelten Wert.',
];
