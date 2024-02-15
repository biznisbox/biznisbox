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

    'accepted' => 'Attributten skal accepteres.',
    'accepted_if' => 'Attributten skal accepteres, når:other er:value',
    'active_url' => 'Attributten er ikke en gyldig URL.',
    'after' => 'Attributten skal være en dato efter: dato.',
    'after_or_equal' => 'Attributten skal være en dato efter eller lig med: dato.',
    'alpha' => 'Attributten må kun indeholde bogstaver.',
    'alpha_dash' => 'Attributten må kun indeholde bogstaver, tal, bindestreger og understregninger.',
    'alpha_num' => 'Attributten må kun indeholde bogstaver og tal.',
    'array' => 'Attributten skal være et array.',
    'before' => 'Attributten skal være en dato før:date.',
    'before_or_equal' => 'Attributten skal være en dato før eller lig med: dato.',
    'between' => [
        'array' => 'Attributten skal have mellem: min og: max elementer.',
        'file' => 'Attributten skal være mellem: min og: max kilobytes.',
        'numeric' => 'Attributten skal være mellem: min og: max.',
        'string' => 'Attributten skal være mellem: min og: max tegn.',
    ],
    'boolean' => 'Attributfeltet skal være sandt eller falsk.',
    'confirmed' => 'Attributbekræftelsen stemmer ikke overens.',
    'current_password' => 'Adgangskoden er forkert.',
    'date' => 'Attributten er ikke en gyldig dato.',
    'date_equals' => 'Attributten skal være en dato lig med: dato.',
    'date_format' => 'Attributten matcher ikke formatet: format.',
    'declined' => 'Attributten skal afvises.',
    'declined_if' => 'Attributten skal afvises når:other er:value',
    'different' => 'Attributten og: andet skal være anderledes.',
    'digits' => 'Attributten skal være: cifre cifre.',
    'digits_between' => 'Attributten skal være mellem: min og: max cifre.',
    'dimensions' => 'Attributten har ugyldige billeddimensioner.',
    'distinct' => 'Attributfeltet har en duplikeret værdi.',
    'doesnt_end_with' => 'Attributten kan ikke slutte med en af følgende: :values.',
    'doesnt_start_with' => 'Attributten må ikke starte med en af følgende: :values.',
    'email' => 'Attributten skal være en gyldig e-mail-adresse.',
    'ends_with' => 'Attributten skal slutte med en af følgende: :values.',
    'enum' => 'Den valgte :attribute er ugyldig.',
    'exists' => 'Den valgte :attribute er ugyldig.',
    'file' => 'Attributten skal være en fil.',
    'filled' => 'Attributfeltet skal have en værdi.',
    'gt' => [
        'array' => 'Attributten skal have mere end :value items.',
        'file' => 'Attributten skal være større end :value kilobytes.',
        'numeric' => 'Attributten skal være større end :value.',
        'string' => 'Attributten skal være større end :value tegn.',
    ],
    'gte' => [
        'array' => 'Attributten skal have:value elementer eller mere.',
        'file' => 'Attributten skal være større end eller lig med: værdi kilobytes.',
        'numeric' => 'Attributten skal være større end eller lig med: værdi.',
        'string' => 'Attributten skal være større end eller lig med: værdi tegn.',
    ],
    'image' => 'Attributten skal være et billede.',
    'in' => 'Den valgte :attribute er ugyldig.',
    'in_array' => 'Attributfeltet findes ikke i: andet.',
    'integer' => 'Attributten skal være et heltal.',
    'ip' => 'Attributten skal være en gyldig IP-adresse.',
    'ipv4' => 'Attributten skal være en gyldig IPv4-adresse.',
    'ipv6' => 'Attributten skal være en gyldig IPv6-adresse.',
    'json' => 'Attributten skal være en gyldig JSON streng.',
    'lt' => [
        'array' => 'Attributten skal have mindre end :value items.',
        'file' => 'Attributten skal være mindre end :value kilobytes.',
        'numeric' => 'Attributten skal være mindre end :value.',
        'string' => 'Attributten skal være mindre end :value tegn.',
    ],
    'lte' => [
        'array' => 'Attributten må ikke have mere end :value items.',
        'file' => 'Attributten skal være mindre end eller lig med: value kilobytes.',
        'numeric' => 'Attributten skal være mindre end eller lig med: værdi.',
        'string' => 'Attributten skal være mindre end eller lig med: værdi tegn.',
    ],
    'mac_address' => 'Attributten skal være en gyldig MAC-adresse.',
    'max' => [
        'array' => 'Attributten må ikke have mere end :max elementer.',
        'file' => 'Attributten må ikke være større end :max kilobytes.',
        'numeric' => 'Attributten må ikke være større end :max.',
        'string' => 'Attributten må ikke være større end :max tegn.',
    ],
    'max_digits' => 'Attributten må ikke have mere end :max cifre.',
    'mimes' => 'Attributten skal være en fil af typen:: værdier.',
    'mimetypes' => 'Attributten skal være en fil af typen:: værdier.',
    'min' => [
        'array' => 'Attributten skal have mindst: min elementer.',
        'file' => 'Attributten skal være mindst: min kilobytes.',
        'numeric' => 'Attributten skal være mindst: min.',
        'string' => 'Attributten skal være mindst: min tegn.',
    ],
    'min_digits' => 'Attributten skal have mindst: min cifre.',
    'multiple_of' => 'Attributten skal være et multiplum af :value.',
    'not_in' => 'Den valgte :attribute er ugyldig.',
    'not_regex' => 'Attributformatet er ugyldigt.',
    'numeric' => 'Attributten skal være et tal.',
    'password' => [
        'letters' => 'Attributten skal indeholde mindst ét bogstav.',
        'mixed' => 'Attributten skal indeholde mindst et stort bogstav og et lille bogstav.',
        'numbers' => 'Attributten skal indeholde mindst et tal.',
        'symbols' => 'Attributten skal indeholde mindst et symbol.',
        'uncompromised' => 'Den givne :attribute er dukket op i en datalæk. Vælg venligst en anden :attribut.',
    ],
    'present' => 'Attributfeltet skal være til stede.',
    'prohibited' => 'Attributfeltet er forbudt.',
    'prohibited_if' => 'Attributfeltet er forbudt, når: andet er:værdi.',
    'prohibited_unless' => 'Attributfeltet er forbudt medmindre :other er i: værdier.',
    'prohibits' => 'Attributfeltet forbyder :other at være til stede.',
    'regex' => 'Attributformatet er ugyldigt.',
    'required' => 'Attributfeltet er påkrævet.',
    'required_array_keys' => 'Attributfeltet skal indeholde poster for: værdier.',
    'required_if' => 'Attributfeltet er påkrævet, når: andet er:værdi.',
    'required_unless' => 'Attributfeltet er påkrævet, medmindre: andet er i: værdier.',
    'required_with' => 'Attributfeltet er påkrævet, når: værdier er til stede.',
    'required_with_all' => 'Attributfeltet er påkrævet, når: værdier er til stede.',
    'required_without' => 'Attributfeltet er påkrævet, når:values ikke er til stede.',
    'required_without_all' => 'Attributfeltet er påkrævet, når ingen af :values er til stede.',
    'same' => 'Attributten og: andet skal matche.',
    'size' => [
        'array' => 'Attributten skal indeholde: størrelse elementer.',
        'file' => 'Attributten skal være: size kilobytes.',
        'numeric' => 'Attributten skal være: størrelse.',
        'string' => 'Attributten skal være: størrelse tegn.',
    ],
    'starts_with' => 'Attributten skal starte med en af følgende: :values.',
    'string' => 'Attributten skal være en streng.',
    'timezone' => 'Attributten skal være en gyldig tidszone.',
    'unique' => 'Attributten er allerede taget.',
    'uploaded' => 'Attributten kunne ikke uploades.',
    'url' => 'Attributten skal være en gyldig URL.',
    'uuid' => 'Attributten skal være et gyldigt UUID.',

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
            'rule-name' => 'brugerdefineret besked',
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
