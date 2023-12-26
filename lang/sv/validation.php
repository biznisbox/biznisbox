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

    'accepted' => ':attribute måste accepteras.',
    'accepted_if' => ':attribute måste accepteras när :other är :value.',
    'active_url' => ':attribute är inte en giltig URL.',
    'after' => ':attribute måste vara ett datum efter :date.',
    'after_or_equal' => ':attribute måste vara ett datum efter eller lika med :date.',
    'alpha' => ':attribute får endast innehålla bokstäver.',
    'alpha_dash' => ':attribute får endast innehålla bokstäver, siffror, bindestreck och understreck.',
    'alpha_num' => ':attribute får endast innehålla bokstäver och siffror.',
    'array' => ':attribute måste vara en array.',
    'before' => ':attribute måste vara ett datum före :date.',
    'before_or_equal' => ':attribute måste vara ett datum före eller lika med :date.',
    'between' => [
        'array' => ':attribute måste ha mellan :min och :max objekt.',
        'file' => ':attribute måste vara mellan :min och :max kilobyte.',
        'numeric' => ':attribute måste vara mellan :min och :max.',
        'string' => ':attribute måste vara mellan :min och :max tecken.',
    ],
    'boolean' => ':attribute måste vara sant eller falskt.',
    'confirmed' => ':attribute bekräftelsen matchar inte.',
    'current_password' => 'Lösenordet är felaktigt.',
    'date' => ':attribute är inte ett giltigt datum.',
    'date_equals' => ':attribute måste vara ett datum som motsvarar :date.',
    'date_format' => ':attribute matchar inte formatet :format.',
    'declined' => ':attribute måste avvisas.',
    'declined_if' => ':attribute måste avvisas när :other är :value.',
    'different' => ':attribute och :other måste vara olika.',
    'digits' => ':attribute måste vara :digits siffror.',
    'digits_between' => ':attribute måste vara mellan :min och :max siffror.',
    'dimensions' => ':attribute har ogiltiga bilddimensioner.',
    'distinct' => 'Fältet :attribute har ett duplicerat värde.',
    'doesnt_end_with' => ':attribute får inte avslutas med något av följande: :values.',
    'doesnt_start_with' => ':attribute får inte börja med något av följande: :values.',
    'email' => ':attribute måste vara en giltig e-postadress.',
    'ends_with' => ':attribute måste avslutas med något av följande: :values.',
    'enum' => 'Det valda :attribute är ogiltigt.',
    'exists' => 'Det valda :attribute är ogiltigt.',
    'file' => ':attribute måste vara en fil.',
    'filled' => ':attribute måste ha ett värde.',
    'gt' => [
        'array' => ':attribute måste ha mer än :value objekt.',
        'file' => ':attribute måste vara större än :value kilobytes.',
        'numeric' => ':attribute måste vara större än :value.',
        'string' => ':attribute måste vara större än :value tecken.',
    ],
    'gte' => [
        'array' => ':attribute måste ha :value objekt eller mer.',
        'file' => ':attribute måste vara större än eller lika med :value kilobyte.',
        'numeric' => ':attribute måste vara större än eller lika med :value.',
        'string' => ':attribute måste vara större än eller lika med :value tecken.',
    ],
    'image' => ':attribute måste vara en bild.',
    'in' => 'Det valda :attribute är ogiltigt.',
    'in_array' => 'Fältet :attribute finns inte i :other.',
    'integer' => ':attribute måste vara ett heltal.',
    'ip' => ':attribute måste vara en giltig IP-adress.',
    'ipv4' => ':attribute måste vara en giltig IPv4-adress.',
    'ipv6' => ':attribute måste vara en giltig IPv6-adress.',
    'json' => ':attribute måste vara en giltig JSON-sträng.',
    'lt' => [
        'array' => ':attribute måste ha mindre än :value objekt.',
        'file' => ':attribute måste vara mindre än :value kilobytes.',
        'numeric' => ':attribute måste vara mindre än :value.',
        'string' => ':attribute måste vara mindre än :value tecken.',
    ],
    'lte' => [
        'array' => ':attribute får inte ha mer än :value objekt.',
        'file' => ':attribute måste vara mindre än eller lika med :value kilobyte.',
        'numeric' => ':attribute måste vara mindre än eller lika med :value.',
        'string' => ':attribute måste vara mindre än eller lika med :value tecken.',
    ],
    'mac_address' => ':attribute måste vara en giltig MAC-adress.',
    'max' => [
        'array' => ':attribute får inte innehålla mer än :max objekt.',
        'file' => ':attribute får inte vara större än :max kilobyte.',
        'numeric' => ':attribute får inte vara större än :max.',
        'string' => ':attribute får inte vara större än :max tecken.',
    ],
    'max_digits' => ':attribute får inte innehålla fler än :max siffror.',
    'mimes' => ':attribute måste vara en fil av typ: :values.',
    'mimetypes' => ':attribute måste vara en fil av typ: :values.',
    'min' => [
        'array' => ':attribute måste innehålla minst :min objekt.',
        'file' => ':attribute måste vara minst :min kilobyte.',
        'numeric' => ':attribute måste vara minst :min.',
        'string' => ':attribute måste innehålla minst :min tecken.',
    ],
    'min_digits' => ':attribute måste innehålla minst :min siffror.',
    'multiple_of' => ':attribute måste vara en multipel av :value.',
    'not_in' => 'Det valda :attribute är ogiltigt.',
    'not_regex' => ':attribute format är ogiltigt.',
    'numeric' => ':attribute måste vara ett tal.',
    'password' => [
        'letters' => ':attribute måste innehålla minst en bokstav.',
        'mixed' => ':attribute måste innehålla minst ett versaler och en versal.',
        'numbers' => ':attribute måste innehålla minst ett nummer.',
        'symbols' => ':attribute måste innehålla minst en symbol.',
        'uncompromised' => 'Det angivna :attribute har dykt upp i en dataläcka. Välj ett annat :attribut.',
    ],
    'present' => 'Fältet :attribute måste vara närvarande.',
    'prohibited' => 'Fältet :attribute är förbjudet.',
    'prohibited_if' => 'Fältet :attribute är förbjudet när :other är :value.',
    'prohibited_unless' => 'Fältet :attribute är förbjudet om inte :other finns i :values.',
    'prohibits' => 'Fältet :attribute förbjuder :other från att vara närvarande.',
    'regex' => ':attribute format är ogiltigt.',
    'required' => 'Fältet :attribute är obligatoriskt.',
    'required_array_keys' => 'Fältet :attribute måste innehålla poster för: :values.',
    'required_if' => 'Fältet :attribute är obligatoriskt när :other är :value.',
    'required_unless' => ':attribute är obligatoriskt om inte :other finns i :values.',
    'required_with' => ':attribute fältet är obligatoriskt när :values är angivet.',
    'required_with_all' => 'Fältet :attribute är obligatoriskt när :values är presenterade.',
    'required_without' => 'Fältet :attribute är obligatoriskt när :values inte visas.',
    'required_without_all' => 'Fältet :attribute är obligatoriskt när inget av :values är presenterat.',
    'same' => ':attribute och :other måste matcha.',
    'size' => [
        'array' => ':attribute måste innehålla :size objekt.',
        'file' => ':attribute måste vara :size kilobyte.',
        'numeric' => ':attribute måste vara :size.',
        'string' => ':attribute måste vara :size tecken.',
    ],
    'starts_with' => ':attribute måste börja med något av följande: :values.',
    'string' => ':attribute måste vara en sträng.',
    'timezone' => ':attribute måste vara en giltig tidszon.',
    'unique' => ':attribute har redan tagits.',
    'uploaded' => ':attribute kunde inte laddas upp.',
    'url' => ':attribute måste vara en giltig URL.',
    'uuid' => ':attribute måste vara ett giltigt UUID.',

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
            'rule-name' => 'anpassat meddelande',
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
