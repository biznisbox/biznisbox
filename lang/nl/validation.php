<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute moet geaccepteerd worden.',
    'accepted_if' => ':attribute moet geaccepteerd worden als :other :value is.',
    'active_url' => ':attribute is geen geldige URL.',
    'after' => ':attribute moet een datum zijn na :date.',
    'after_or_equal' => ':attribute moet een datum zijn na of gelijk aan :date.',
    'alpha' => ':attribute mag alleen letters bevatten.',
    'alpha_dash' => ':attribute mag alleen letters, cijfers, streepjes en liggende streepjes bevatten.',
    'alpha_num' => ':attribute mag alleen letters en cijfers bevatten.',
    'array' => ':attribute moet een array zijn.',
    'before' => ':attribute moet een datum voor :date zijn.',
    'before_or_equal' => ':attribute moet een datum zijn voor of gelijk aan :date.',
    'between' => [
        'array' => ':attribute moet tussen :min en :max items bevatten.',
        'file' => ':attribute moet tussen :min en :max kilobytes zijn.',
        'numeric' => ':attribute moet tussen de :min en de :max zijn.',
        'string' => ':attribute moet tussen de :min en :max karakters lang zijn.',
    ],
    'boolean' => ':attribute moet waar of onwaar zijn.',
    'confirmed' => ':attribute bevestiging komt niet overeen.',
    'current_password' => 'Het wachtwoord is onjuist.',
    'date' => ':attribute is geen geldige datum.',
    'date_equals' => ':attribute moet een datum gelijk zijn aan :date.',
    'date_format' => ':attribute komt niet overeen met het formaat :format.',
    'declined' => ':attribute moet worden geweigerd.',
    'declined_if' => ':attribute moet afgewezen worden als :other :value is.',
    'different' => ':attribute en :other mogen niet hetzelfde zijn.',
    'digits' => ':attribute moet uit :digits cijfers bestaan.',
    'digits_between' => ':attribute moet tussen de :min en :max cijfers zijn.',
    'dimensions' => ':attribute heeft geen geldige afmetingen voor afbeeldingen.',
    'distinct' => ':attribute veld heeft een dubbele waarde.',
    'doesnt_end_with' => ':attribute mag niet eindigen met een van de volgende :values.',
    'doesnt_start_with' => ':attribute mag niet beginnen met een van de volgende :values.',
    'email' => ':attribute moet een geldig e-mailadres zijn.',
    'ends_with' => ':attribute moet eindigen met een van de volgende :values.',
    'enum' => 'De geselecteerde :attribute is ongeldig.',
    'exists' => 'De geselecteerde :attribute is ongeldig.',
    'file' => ':attribute moet een bestand zijn.',
    'filled' => ':attribute veld moet een waarde hebben.',
    'gt' => [
        'array' => 'De :attribute moet meer dan :value items bevatten.',
        'file' => 'De :attribute moet groter zijn dan :value kilobytes.',
        'numeric' => ':attribute moet groter zijn dan :value.',
        'string' => 'De :attribute moet meer dan :value karakters bevatten.',
    ],
    'gte' => [
        'array' => 'De :attribute moet :value items of meer bevatten.',
        'file' => 'De :attribute moet groter of gelijk zijn aan :value kilobytes.',
        'numeric' => 'De :attribute moet groter of gelijk aan :value zijn.',
        'string' => 'De :attribute moet :value karakters of meer bevatten.',
    ],
    'image' => ':attribute moet een afbeelding zijn.',
    'in' => 'De geselecteerde :attribute is ongeldig.',
    'in_array' => ':attribute veld bestaat niet in :other.',
    'integer' => ':attribute moet een geheel getal zijn.',
    'ip' => ':attribute moet een geldig IP-adres zijn.',
    'ipv4' => ':attribute moet een geldig IPv4-adres zijn.',
    'ipv6' => ':attribute moet een geldig IPv6-adres zijn.',
    'json' => ':attribute moet een geldige JSON-string zijn.',
    'lt' => [
        'array' => 'De :attribute moet minder dan :value items bevatten.',
        'file' => 'De :attribute moet kleiner zijn dan :value kilobytes.',
        'numeric' => ':attribute moet kleiner zijn dan :value.',
        'string' => 'De :attribute moet minder dan :value karakters bevatten.',
    ],
    'lte' => [
        'array' => 'Het :attribute mag niet meer dan :value items bevatten.',
        'file' => 'De :attribute moet kleiner of gelijk zijn aan :value kilobytes.',
        'numeric' => 'De :attribute moet kleiner of gelijk aan :value zijn.',
        'string' => 'De :attribute moet minder of gelijk zijn aan :value tekens.',
    ],
    'mac_address' => ':attribute moet een geldig MAC-adres zijn.',
    'max' => [
        'array' => ':attribute mag niet meer dan :max items bevatten.',
        'file' => ':attribute mag niet groter zijn dan :max kilobytes.',
        'numeric' => ':attribute mag niet groter zijn dan :max.',
        'string' => ':attribute mag niet groter zijn dan :max tekens.',
    ],
    'max_digits' => ':attribute mag niet meer dan :max cijfers bevatten.',
    'mimes' => ':attribute moet een bestand zijn van het type: :values.',
    'mimetypes' => ':attribute moet een bestand zijn van het type: :values.',
    'min' => [
        'array' => ':attribute moet minstens :min items bevatten.',
        'file' => ':attribute moet minstens :min kilobytes zijn.',
        'numeric' => ':attribute moet minstens :min zijn.',
        'string' => ':attribute moet minstens :min karakters bevatten.',
    ],
    'min_digits' => ':attribute moet minstens :min cijfers bevatten.',
    'multiple_of' => ':attribute moet een veelvoud van :value zijn.',
    'not_in' => 'De geselecteerde :attribute is ongeldig.',
    'not_regex' => ':attribute formaat is ongeldig.',
    'numeric' => ':attribute moet een getal zijn.',
    'password' => [
        'letters' => ':attribute moet minstens één letter bevatten.',
        'mixed' => ':attribute moet ten minste één hoofdletter en één kleine letter bevatten.',
        'numbers' => ':attribute moet minstens één cijfer bevatten.',
        'symbols' => ':attribute moet minstens één teken bevatten.',
        'uncompromised' => 'Het gegeven :attribute is weergegeven in een gegevenslek. Kies een ander :attribuut.',
    ],
    'present' => ':attribute veld moet aanwezig zijn.',
    'prohibited' => ':attribute veld is verboden.',
    'prohibited_if' => ':attribute veld is verboden wanneer :other :value is.',
    'prohibited_unless' => ':attribute veld is verboden tenzij :other gelijk is aan :values.',
    'prohibits' => ':attribute veld verbiedt :other van aanwezig te zijn.',
    'regex' => ':attribute formaat is ongeldig.',
    'required' => ':attribute veld is verplicht.',
    'required_array_keys' => ':attribute veld moet items bevatten voor: :values.',
    'required_if' => ':attribute veld is verplicht als :other gelijk is aan :value.',
    'required_unless' => ':attribute veld is verplicht tenzij :other gelijk is aan :values.',
    'required_with' => ':attribute veld is verplicht wanneer :values aanwezig is.',
    'required_with_all' => ':attribute veld is verplicht wanneer :values aanwezig zijn.',
    'required_without' => ':attribute veld is verplicht als :values niet aanwezig is.',
    'required_without_all' => ':attribute veld is verplicht wanneer geen van :values aanwezig zijn.',
    'same' => ':attribute en :other moeten overeenkomen.',
    'size' => [
        'array' => ':attribute moet :size items bevatten.',
        'file' => ':attribute moet :size kilobytes zijn.',
        'numeric' => ':attribute moet :size zijn.',
        'string' => ':attribute moet :size karakters bevatten.',
    ],
    'starts_with' => ':attribute moet beginnen met een van de volgende :values.',
    'string' => ':attribute moet een tekenreeks zijn.',
    'timezone' => ':attribute moet een geldige tijdzone zijn.',
    'unique' => ':attribute is al in gebruik.',
    'uploaded' => 'Het uploaden van :attribute is mislukt.',
    'url' => ':attribute moet een geldige URL zijn.',
    'uuid' => ':attribute moet een geldige UUID zijn.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'eigen bericht',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],
];
