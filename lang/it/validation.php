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

    'accepted' => 'Attributo :attribute deve essere accettato.',
    'accepted_if' => 'Il campo :attribute deve essere accettato quando :other è :value.',
    'active_url' => 'Attributo :attribute non è un URL valido.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'Il campo :attribute deve contenere solo lettere.',
    'alpha_dash' => 'Il campo :attribute deve contenere solo lettere, numeri, trattini e trattini.',
    'alpha_num' => 'Il campo :attribute deve contenere solo lettere e numeri.',
    'array' => 'Attributo :attribute deve essere un array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'array' => 'Il campo :attribute deve avere tra :min e :max elementi.',
        'file' => 'Attributo :attribute deve essere compreso tra :min e :max kilobytes.',
        'numeric' => 'Attributo :attribute deve essere compreso tra :min e :max.',
        'string' => 'Attributo :attribute deve essere compreso tra :min e :max caratteri.',
    ],
    'boolean' => 'Il campo :attribute deve essere vero o falso.',
    'confirmed' => 'La conferma :attribute non corrisponde.',
    'current_password' => 'La password non è corretta.',
    'date' => 'Attributo :attribute non è una data valida.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'Il campo :attribute non corrisponde al formato :format.',
    'declined' => 'Attributo :attribute deve essere rifiutato.',
    'declined_if' => 'Il campo :attribute deve essere rifiutato quando :other è :value.',
    'different' => 'Il campo :attribute e :other devono essere diversi.',
    'digits' => 'Attributo :attribute deve contenere :digits cifre.',
    'digits_between' => 'Attributo :attribute deve essere compreso tra :min e :max cifre.',
    'dimensions' => 'Attributo :attribute ha dimensioni dell\'immagine non valide.',
    'distinct' => 'Il campo :attribute ha un valore duplicato.',
    'doesnt_end_with' => 'The :attribute may not end with one of the following :values.',
    'doesnt_start_with' => 'The :attribute may not start with one of the following :values.',
    'email' => 'Attributo :attribute deve essere un indirizzo email valido.',
    'ends_with' => 'Attributo :attribute deve terminare con uno dei seguenti: :values.',
    'enum' => 'Il campo :attribute selezionato non è valido.',
    'exists' => 'Il campo :attribute selezionato non è valido.',
    'file' => 'Il campo :attribute deve essere un file.',
    'filled' => 'Il campo :attribute deve avere un valore.',
    'gt' => [
        'array' => 'The :attribute must have more than :value items.',
        'file' => 'Attributo :attribute deve essere maggiore di :value kilobytes.',
        'numeric' => 'Attributo :attribute deve essere maggiore di :value.',
        'string' => 'Attributo :attribute deve essere maggiore di :value caratteri.',
    ],
    'gte' => [
        'array' => 'The :attribute must have :value items or more.',
        'file' => 'Attributo :attribute deve essere maggiore o uguale a :value kilobytes.',
        'numeric' => 'Attributo :attribute deve essere maggiore o uguale a :value.',
        'string' => 'The :attribute must be greater or equal to :value characters.',
    ],
    'image' => 'Attributo :attribute deve essere un\'immagine.',
    'in' => 'Il campo :attribute selezionato non è valido.',
    'in_array' => 'Il campo :attribute non esiste in :other.',
    'integer' => 'Attributo :attribute deve essere un numero intero.',
    'ip' => 'Attributo :attribute deve essere un indirizzo IP valido.',
    'ipv4' => 'Attributo :attribute deve essere un indirizzo IPv4 valido.',
    'ipv6' => 'Attributo :attribute deve essere un indirizzo IPv6 valido.',
    'json' => 'Attributo :attribute deve essere una stringa JSON valida.',
    'lt' => [
        'array' => 'The :attribute must have less than :value items.',
        'file' => 'Attributo :attribute deve essere inferiore a :value kilobytes.',
        'numeric' => 'Attributo :attribute deve essere inferiore a :value.',
        'string' => 'The :attribute must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute must not have more than :value items.',
        'file' => 'Attributo :attribute deve essere minore o uguale a :value kilobytes.',
        'numeric' => 'Attributo :attribute deve essere minore o uguale a :value.',
        'string' => 'Attributo :attribute deve essere minore o uguale a :value caratteri.',
    ],
    'mac_address' => 'Attributo :attribute deve essere un indirizzo MAC valido.',
    'max' => [
        'array' => 'Il campo :attribute non deve avere più di :max elementi.',
        'file' => 'Attributo :attribute non deve essere maggiore di :max kilobytes.',
        'numeric' => 'Attributo :attribute non deve essere maggiore di :max.',
        'string' => 'Attributo :attribute non deve essere maggiore di :max caratteri.',
    ],
    'max_digits' => 'Attributo :attribute non deve avere più di :max cifre.',
    'mimes' => 'Attributo :attribute deve essere un file di tipo: :values.',
    'mimetypes' => 'Attributo :attribute deve essere un file di tipo: :values.',
    'min' => [
        'array' => 'Il campo :attribute deve avere almeno :min elementi.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'numeric' => 'Attributo :attribute deve essere almeno :min.',
        'string' => 'Il campo :attribute deve contenere almeno :min caratteri.',
    ],
    'min_digits' => 'Il campo :attribute deve avere almeno :min cifre.',
    'multiple_of' => 'Il campo :attribute deve essere multiplo di :value.',
    'not_in' => 'Il campo :attribute selezionato non è valido.',
    'not_regex' => 'Il formato :attribute non è valido.',
    'numeric' => 'Attributo :attribute deve essere un numero.',
    'password' => [
        'letters' => 'Attributo :attribute deve contenere almeno una lettera.',
        'mixed' => 'Attributo :attribute deve contenere almeno una lettera maiuscola e una lettera minuscola.',
        'numbers' => 'Il campo :attribute deve contenere almeno un numero.',
        'symbols' => 'Attributo :attribute deve contenere almeno un simbolo.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'Il campo :attribute deve essere presente.',
    'prohibited' => 'Il campo :attribute è vietato.',
    'prohibited_if' => 'Il campo :attribute è vietato quando :other è :value.',
    'prohibited_unless' => 'Il campo :attribute è vietato a meno che :other non sia in :values.',
    'prohibits' => 'Il campo :attribute vieta :other di essere presente.',
    'regex' => 'Il formato :attribute non è valido.',
    'required' => 'Il campo :attribute è richiesto.',
    'required_array_keys' => 'Il campo :attribute deve contenere voci per: :values.',
    'required_if' => 'Il campo :attribute è obbligatorio quando :other è :value.',
    'required_unless' => 'Il campo :attribute è obbligatorio a meno che :other non sia in :values.',
    'required_with' => 'Il campo :attribute è obbligatorio quando :values è presente.',
    'required_with_all' => 'Il campo :attribute è obbligatorio quando :values sono presenti.',
    'required_without' => 'Il campo :attribute è obbligatorio quando :values non è presente.',
    'required_without_all' => 'Il campo :attribute è obbligatorio quando nessuno dei :values è presente.',
    'same' => 'Le :attribute e :other devono corrispondere.',
    'size' => [
        'array' => 'Il campo :attribute deve contenere :size elementi.',
        'file' => 'Attributo :attribute deve essere :size kilobytes.',
        'numeric' => 'Attributo :attribute deve essere :size.',
        'string' => 'Il campo :attribute deve contenere :size caratteri.',
    ],
    'starts_with' => 'Attributo :attribute deve iniziare con uno dei seguenti: :values.',
    'string' => 'Attributo :attribute deve essere una stringa.',
    'timezone' => 'Attributo :attribute deve essere un fuso orario valido.',
    'unique' => 'Il campo :attribute è già stato utilizzato.',
    'uploaded' => 'L\'attributo :attribute non è stato caricato.',
    'url' => 'Attributo :attribute deve essere un URL valido.',
    'uuid' => 'Attributo :attribute deve essere un UUID valido.',

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
            'rule-name' => 'custom-message',
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
