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

    'accepted' => 'L\'atribut :attribute ha de ser acceptat.',
    'accepted_if' => 'L\'atribut :attribute ha de ser acceptat quan :other és :value.',
    'active_url' => 'L\'atribut :attribute no és una URL vàlida.',
    'after' => 'L\'atribut :attribute ha de ser una data posterior a :date.',
    'after_or_equal' => 'L\'atribut :attribute ha de ser una data posterior o igual a :date.',
    'alpha' => 'L\'atribut :attribute només pot contenir lletres.',
    'alpha_dash' => 'L\'atribut :attribute només pot contenir lletres, números, guions i guions baixos.',
    'alpha_num' => 'L\'atribut :attribute només pot contenir lletres i números.',
    'array' => 'L\'atribut :attribute ha de ser un array.',
    'before' => 'L\'atribut :attribute ha de ser una data anterior a :date.',
    'before_or_equal' => 'L\'atribut :attribute ha de ser una data anterior o igual a :date.',
    'between' => [
        'array' => 'L\'atribut :attribute ha de tenir entre :min i :max elements.',
        'file' => 'L\'atribut :attribute ha de tenir entre :min i :max kilobytes.',
        'numeric' => 'L\'atribut :attribute ha de ser entre :min i :max.',
        'string' => 'L\'atribut :attribute ha de tenir entre :min i :max caràcters.',
    ],
    'boolean' => 'El camp :attribute ha de ser verdader o fals.',
    'confirmed' => 'La confirmació de :attribute no coincideix.',
    'current_password' => 'La contrasenya és incorrecta.',
    'date' => 'L\'atribut :attribute no és una data vàlida.',
    'date_equals' => 'L\'atribut :attribute ha de ser una data igual a :date.',
    'date_format' => 'L\'atribut :attribute no coincideix amb el format :format.',
    'declined' => 'L\'atribut :attribute ha de ser declinat.',
    'declined_if' => 'L\'atribut :attribute ha de ser declinat quan :other és :value.',
    'different' => 'L\'atribut :attribute i :other han de ser diferents.',
    'digits' => 'L\'atribut :attribute ha de tenir :digits dígits.',
    'digits_between' => 'L\'atribut :attribute ha de tenir entre :min i :max dígits.',
    'dimensions' => 'L\'atribut :attribute té dimensions d\'imatge no vàlides.',
    'distinct' => 'El camp :attribute té un valor duplicat.',
    'doesnt_end_with' => 'L\'atribut :attribute no pot acabar amb cap dels següents: :values.',
    'doesnt_start_with' => 'L\'atribut :attribute no pot començar amb cap dels següents: :values.',
    'email' => 'L\'atribut :attribute ha de ser una adreça de correu electrònic vàlida.',
    'ends_with' => 'L\'atribut :attribute ha de acabar amb un dels següents: :values.',
    'enum' => 'El :attribute seleccionat no és vàlid.',
    'exists' => 'El :attribute seleccionat no és vàlid.',
    'file' => 'L\'atribut :attribute ha de ser un fitxer.',
    'filled' => 'El camp :attribute ha de tenir un valor.',
    'gt' => [
        'array' => 'L\'atribut :attribute ha de tenir més de :value elements.',
        'file' => 'L\'atribut :attribute ha de ser més gran que :value kilobytes.',
        'numeric' => 'L\'atribut :attribute ha de ser més gran que :value.',
        'string' => 'L\'atribut :attribute ha de ser més gran que :value caràcters.',
    ],
    'gte' => [
        'array' => 'L\'atribut :attribute ha de tenir :value elements o més.',
        'file' => 'L\'atribut :attribute ha de ser més gran o igual que :value kilobytes.',
        'numeric' => 'L\'atribut :attribute ha de ser més gran o igual que :value.',
        'string' => 'L\'atribut :attribute ha de ser més gran o igual que :value caràcters.',
    ],
    'image' => 'L\'atribut :attribute ha de ser una imatge.',
    'in' => 'El :attribute seleccionat no és vàlid.',
    'in_array' => 'El camp :attribute no existeix a :other.',
    'integer' => 'L\'atribut :attribute ha de ser un enter.',
    'ip' => 'L\':attribute ha de ser una adreça IP vàlida.',
    'ipv4' => 'L\':attribute ha de ser una adreça IPv4 vàlida.',
    'ipv6' => 'L\':attribute ha de ser una adreça IPv6 vàlida.',
    'json' => 'L\':attribute ha de ser una cadena JSON vàlida.',
    'lt' => [
        'array' => 'L\':attribute ha de tenir menys de :value elements.',
        'file' => 'L\':attribute ha de tenir menys de :value kilobytes.',
        'numeric' => 'L\':attribute ha de ser menor que :value.',
        'string' => 'L\':attribute ha de tenir menys de :value caràcters.',
    ],
    'lte' => [
        'array' => 'L\':attribute no ha de tenir més de :value elements.',
        'file' => 'L\':attribute ha de ser menor o igual a :value kilobytes.',
        'numeric' => 'L\':attribute ha de ser menor o igual a :value.',
        'string' => 'L\':attribute ha de ser menor o igual a :value caràcters.',
    ],
    'mac_address' => 'L\':attribute ha de ser una adreça MAC vàlida.',
    'max' => [
        'array' => 'L\':attribute no ha de tenir més de :max elements.',
        'file' => 'L\':attribute no ha de ser més gran de :max kilobytes.',
        'numeric' => 'L\':attribute no ha de ser més gran de :max.',
        'string' => 'L\':attribute no ha de ser més gran de :max caràcters.',
    ],
    'max_digits' => 'L\':attribute no ha de tenir més de :max dígits.',
    'mimes' => 'L\':attribute ha de ser un fitxer del tipus: :values.',
    'mimetypes' => 'L\':attribute ha de ser un fitxer del tipus: :values.',
    'min' => [
        'array' => 'L\':attribute ha de tenir com a mínim :min elements.',
        'file' => 'L\':attribute ha de tenir com a mínim :min kilobytes.',
        'numeric' => 'L\':attribute ha de ser com a mínim :min.',
        'string' => 'L\'atribut :attribute ha de tenir com a mínim :min caràcters.',
    ],
    'min_digits' => 'L\'atribut :attribute ha de tenir com a mínim :min dígits.',
    'multiple_of' => 'L\'atribut :attribute ha de ser un múltiple de :value.',
    'not_in' => 'L\'atribut seleccionat :attribute no és vàlid.',
    'not_regex' => 'El format de l\'atribut :attribute no és vàlid.',
    'numeric' => 'L\'atribut :attribute ha de ser un número.',
    'password' => [
        'letters' => 'L\'atribut :attribute ha de contenir com a mínim una lletra.',
        'mixed' => 'L\'atribut :attribute ha de contenir com a mínim una lletra majúscula i una minúscula.',
        'numbers' => 'L\'atribut :attribute ha de contenir com a mínim un número.',
        'symbols' => 'L\'atribut :attribute ha de contenir com a mínim un símbol.',
        'uncompromised' => 'L\'atribut :attribute proporcionat ha aparegut en una fuita de dades. Si us plau, escolliu un altre :attribute.',
    ],
    'present' => 'El camp de l\'atribut :attribute ha d\'estar present.',
    'prohibited' => 'El camp de l\'atribut :attribute està prohibit.',
    'prohibited_if' => 'El camp de l\'atribut :attribute està prohibit quan :other és :value.',
    'prohibited_unless' => 'El camp de l\'atribut :attribute està prohibit a menys que :other estigui a :values.',
    'prohibits' => 'El camp de l\'atribut :attribute prohibeix que :other estigui present.',
    'regex' => 'El format de l\'atribut :attribute no és vàlid.',
    'required' => 'El camp de l\'atribut :attribute és obligatori.',
    'required_array_keys' => 'El camp de l\'atribut :attribute ha de contenir entrades per a: :values.',
    'required_if' => 'El camp de l\'atribut :attribute és obligatori quan :other és :value.',
    'required_unless' => 'El camp de l\'atribut :attribute és obligatori a menys que :other estigui a :values.',
    'required_with' => 'El camp de l\'atribut :attribute és obligatori quan :values està present.',
    'required_with_all' => 'El camp de l\'atribut :attribute és obligatori quan :values estan presents.',
    'required_without' => 'El camp :attribute és obligatori quan :values no està present.',
    'required_without_all' => 'El camp :attribute és obligatori quan cap de :values està present.',
    'same' => 'El camp :attribute i :other han de coincidir.',
    'size' => [
        'array' => 'El camp :attribute ha de contenir :size elements.',
        'file' => 'El camp :attribute ha de ser :size kilobytes.',
        'numeric' => 'El camp :attribute ha de ser :size.',
        'string' => 'L\':attribute ha de tenir :size caràcters.',
    ],
    'starts_with' => 'L\':attribute ha de començar amb un dels següents: :values.',
    'string' => 'L\':attribute ha de ser una cadena de text.',
    'timezone' => 'L\':attribute ha de ser una zona horària vàlida.',
    'unique' => 'L\':attribute ja ha estat pres.',
    'uploaded' => 'No s\'ha pogut carregar l\':attribute.',
    'url' => 'L\':attribute ha de ser una URL vàlida.',
    'uuid' => 'L\':attribute ha de ser un UUID vàlid.',

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
            'rule-name' => 'missatge-personalitzat',
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
