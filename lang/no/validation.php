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

    'accepted' => 'Attributtet :attribute må velges.',
    'accepted_if' => 'Attributtet :attribute må aksepteres når :other er :value.',
    'active_url' => ':attribute er ikke en gyldig URL.',
    'after' => ':attribute må være en dato etter :date.',
    'after_or_equal' => 'Attributtet :attribute må være en dato etter eller lik :date.',
    'alpha' => ':attribute må kun inneholde bokstaver.',
    'alpha_dash' => 'Attributtet :attribute kan kun inneholde bokstaver, tall, bindestrek og understrek.',
    'alpha_num' => ':attribute må kun inneholde bokstaver og tall.',
    'array' => ':attribute må være en matrise.',
    'before' => ':attribute må være en dato før :date.',
    'before_or_equal' => 'Attributtet :attribute må være en dato før eller lik :date.',
    'between' => [
        'array' => 'Attributtet må ha mellom: min og: maks elementer.',
        'file' => ':attribute må være mellom :min og :max tegn.',
        'numeric' => 'Attributtet :attribute må være mellom :min og :max.',
        'string' => ':attribute må være mellom :min og :max tegn.',
    ],
    'boolean' => ':attribute må være sann eller usann.',
    'confirmed' => 'Bekreftelse på attributtet :attribute stemmer ikke.',
    'current_password' => 'Passordet er feil.',
    'date' => ':attribute er ikke en gyldig dato.',
    'date_equals' => ':attribute må være en dato lik :date.',
    'date_format' => ':attribute samsvarer ikke med formatet :format.',
    'declined' => ':attribute må bli avslått.',
    'declined_if' => ':attribute må avvises når :other er :value.',
    'different' => 'Attributtet :attribute og :other er forskjellige.',
    'digits' => 'Attributtet :attribute må være :digits sifre.',
    'digits_between' => 'Attributtet :attribute må være mellom :min og :max sifre.',
    'dimensions' => 'Attributtet har ugyldige bildedimensjoner.',
    'distinct' => ':attribute feltet har en duplisert verdi.',
    'doesnt_end_with' => ':attribute kan ikke ende med én av følgende: :values.',
    'doesnt_start_with' => ':attribute kan ikke starte med en av følgende: :values.',
    'email' => 'Attributtet :attribute må være en gyldig e-postadresse.',
    'ends_with' => ':attribute må avsluttes med en av følgende: :values.',
    'enum' => 'Valgt attributt :attribute er ugyldig.',
    'exists' => 'Valgt attributt :attribute er ugyldig.',
    'file' => ':attribute må være en fil.',
    'filled' => 'Den :attribute må ha en verdi.',
    'gt' => [
        'array' => ':attribute må inneholde mer enn :value elementer.',
        'file' => ':attribute må være større enn :value kilobytes.',
        'numeric' => ':attribute må være større enn :value.',
        'string' => ':attribute må være større enn :value tegn.',
    ],
    'gte' => [
        'array' => 'Attributtet :attribute må ha :value items eller mer.',
        'file' => ':attribute må være større enn eller lik :value kilobytes.',
        'numeric' => ':attribute må være større enn eller lik :value.',
        'string' => ':attribute må være større enn eller lik :value tegn.',
    ],
    'image' => ':attribute må være et bilde.',
    'in' => 'Valgt attributt :attribute er ugyldig.',
    'in_array' => ':attribute feltet finnes ikke i :other.',
    'integer' => ':attribute må være et heltall.',
    'ip' => 'Attributtet :attribute må være en gyldig IP-adresse.',
    'ipv4' => 'Attributtet :attribute må være en gyldig IPv4-adresse.',
    'ipv6' => 'Attributtet :attribute må være en gyldig IPv6-adresse.',
    'json' => ':attribute må være en gyldig JSON-streng.',
    'lt' => [
        'array' => ':attribute må inneholde mindre enn :value elementer.',
        'file' => ':attribute må være mindre enn :value kilobytes.',
        'numeric' => ':attribute må være mindre enn :value.',
        'string' => ':attribute må være mindre enn :value tegn.',
    ],
    'lte' => [
        'array' => ':attribute må ikke inneholde mer enn :value elementer.',
        'file' => ':attribute må være mindre enn eller lik :value kilobytes.',
        'numeric' => ':attribute må være mindre enn eller lik :value.',
        'string' => ':attribute må være mindre enn eller lik :value tegn.',
    ],
    'mac_address' => 'Attributtet :attribute må være en gyldig MAC-adresse.',
    'max' => [
        'array' => ':attribute må ikke inneholde mer enn :max elementer.',
        'file' => ':attribute må ikke være større enn :max kilobytes.',
        'numeric' => 'Attributtet :attribute må ikke være større enn :max.',
        'string' => ':attribute må ikke være større enn :max tegn.',
    ],
    'max_digits' => ':attribute må ikke ha mer enn :max sifre.',
    'mimes' => 'Attributtet :attribute må være en fil av typen: :values.',
    'mimetypes' => 'Attributtet :attribute må være en fil av typen: :values.',
    'min' => [
        'array' => 'Attributtet må ha minst: min elementer.',
        'file' => ':attribute må være minst :min kilobytes.',
        'numeric' => ':attribute må være minst :min.',
        'string' => ':attribute må ha minst :min tegn.',
    ],
    'min_digits' => ':attribute må ha minst :min sifre.',
    'multiple_of' => ':attribute må være et multiplum av :value.',
    'not_in' => 'Valgt attributt :attribute er ugyldig.',
    'not_regex' => 'Attributt-formatet :attribute er ugyldig.',
    'numeric' => 'Attributtet :attribute må være et nummer.',
    'password' => [
        'letters' => ':attribute må inneholde minst én bokstav.',
        'mixed' => ':attribute må inneholde minst en stor og en liten bokstav.',
        'numbers' => ':attribute må inneholde minst ett nummer.',
        'symbols' => ':attribute må inneholde minst ett symbol.',
        'uncompromised' => 'Attributtet :attribute har dukket opp i en datalekkasje. Velg et annet :attribute.',
    ],
    'present' => 'Atributtfeltet :attribute må ha en verdi.',
    'prohibited' => 'Attributt-feltet :attribute er forbudt.',
    'prohibited_if' => 'Attributt-feltet :attribute er forbudt når :other er :value.',
    'prohibited_unless' => 'Attributt-feltet :attribute er forbudt med mindre: annet er i: verdier.',
    'prohibits' => 'Attributt-feltet :attribute forbyr :other fra å være tilstede.',
    'regex' => 'Attributt-formatet :attribute er ugyldig.',
    'required' => 'Attributt-feltet :attribute er påkrevd.',
    'required_array_keys' => 'Feltet :attribute må inneholde enheter for: :values.',
    'required_if' => 'Attributt-feltet :attribute er påkrevd når :other er :value.',
    'required_unless' => 'Attributtfeltet kreves med mindre: annet er i: verdier.',
    'required_with' => 'Attributt-feltet :attribute er påkrevd når :values er tilstede.',
    'required_with_all' => 'Attributt-feltet :attribute er påkrevd når :values er tilstede.',
    'required_without' => 'Attributt-feltet :attribute er påkrevd når :values ikke er tilstede.',
    'required_without_all' => 'Attributtfeltet kreves når ingen av: verdiene er til stede.',
    'same' => ':attribute og :other må være like.',
    'size' => [
        'array' => ':attribute må inneholde :size elementer.',
        'file' => ':attribute må være :size kilobytes.',
        'numeric' => 'Attributtet :attribute må være :size.',
        'string' => 'Attributtet :attribute må være :size tegn.',
    ],
    'starts_with' => ':attribute må starte med en av følgende: :values.',
    'string' => ':attribute må være en tekst.',
    'timezone' => ':attribute må være en gyldig tidssone.',
    'unique' => 'Attributtet :attribute er allerede tatt.',
    'uploaded' => 'Attributtet :attribute kunne ikke lastes opp.',
    'url' => ':attribute må være en gyldig URL.',
    'uuid' => ':attribute må være en gyldig UUID.',

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
            'rule-name' => 'egenvalgt melding',
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
