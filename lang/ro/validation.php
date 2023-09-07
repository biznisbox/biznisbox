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

    'accepted' => ':attribute trebuie să fie acceptat.',
    'accepted_if' => ':attribute trebuie să fie acceptat atunci când :other este :value.',
    'active_url' => ':attribute nu este un URL valid.',
    'after' => ':attribute trebuie să fie o dată după :date.',
    'after_or_equal' => ':attribute trebuie să fie o dată ulterioară sau egală cu :date.',
    'alpha' => ':attribute trebuie să conțină doar litere.',
    'alpha_dash' => ':attribute trebuie să conțină doar litere, cifre, cratime și underscore.',
    'alpha_num' => ':attribute trebuie să conțină doar litere și cifre.',
    'array' => ':attribute trebuie să fie un array.',
    'before' => ':attribute trebuie să fie o dată înainte de :date.',
    'before_or_equal' => ':attribute trebuie să fie o dată înainte sau egală cu :date.',
    'between' => [
        'array' => ':attribute trebuie să aibă între :min şi :max elemente.',
        'file' => ':attribute trebuie să aibă între :min şi :max kiloocteţi.',
        'numeric' => ':attribute trebuie să fie între :min şi :max.',
        'string' => ':attribute trebuie să aibă între :min şi :max caractere.',
    ],
    'boolean' => 'Câmpul :attribute trebuie să fie adevărat sau fals.',
    'confirmed' => 'Confirmarea :attribute nu se potrivește.',
    'current_password' => 'Parola este incorectă.',
    'date' => ':attribute nu este o dată validă.',
    'date_equals' => ':attribute trebuie să fie o dată egală cu :date.',
    'date_format' => ':attribute nu se potrivește cu formatul :format.',
    'declined' => ':attribute trebuie să fie refuzat.',
    'declined_if' => ':attribute trebuie să fie refuzat când :other este :value.',
    'different' => ':attribute și :other trebuie să fie diferite.',
    'digits' => 'Câmpul :attribute trebuie s? aib? :digits cifre.',
    'digits_between' => ':attribute trebuie să aibă între :min şi :max cifre.',
    'dimensions' => ':attribute are dimensiuni de imagine invalide.',
    'distinct' => 'Câmpul :attribute are o valoare dublă.',
    'doesnt_end_with' => ':attribute nu se poate termina cu unul dintre următoarele :values.',
    'doesnt_start_with' => 'Câmpul :attribute nu poate începe cu unul dintre următoarele: :values.',
    'email' => ':attribute trebuie să fie o adresă de e-mail validă.',
    'ends_with' => ':attribute trebuie să se termine cu una dintre următoarele: :values.',
    'enum' => ':attribute selectat nu este valid.',
    'exists' => ':attribute selectat nu este valid.',
    'file' => ':attribute trebuie să fie un fișier.',
    'filled' => 'Câmpul :attribute trebuie să aibă o valoare.',
    'gt' => [
        'array' => ':attribute trebuie să aibă mai mult de :value elemente.',
        'file' => ':attribute trebuie să fie mai mare decât :value kilobytes.',
        'numeric' => ':attribute trebuie să fie mai mare decât :value.',
        'string' => ':attribute trebuie să fie mai mare decât :value caractere.',
    ],
    'gte' => [
        'array' => ':attribute trebuie să aibă :value elemente sau mai multe.',
        'file' => ':attribute trebuie să fie mai mare sau egală cu :value kilobytes.',
        'numeric' => ':attribute trebuie să fie mai mare sau egal cu :value.',
        'string' => ':attribute trebuie să fie mai mare sau egală cu :value caractere.',
    ],
    'image' => ':attribute trebuie să fie o imagine.',
    'in' => ':attribute selectat nu este valid.',
    'in_array' => 'Câmpul :attribute nu există în :other.',
    'integer' => ':attribute trebuie să fie un număr întreg.',
    'ip' => ':attribute trebuie să fie o adresă IP validă.',
    'ipv4' => ':attribute trebuie să fie o adresă IPv4 validă.',
    'ipv6' => ':attribute trebuie să fie o adresă IPv6 validă.',
    'json' => ':attribute trebuie să fie un şir JSON valid.',
    'lt' => [
        'array' => ':attribute trebuie să aibă mai puţin de :value elemente.',
        'file' => ':attribute trebuie să fie mai mic de :value kilobytes.',
        'numeric' => ':attribute trebuie să fie mai mic decât :value.',
        'string' => ':attribute trebuie să aibă mai puţin de :value caractere.',
    ],
    'lte' => [
        'array' => ':attribute nu trebuie să aibă mai mult de :value elemente.',
        'file' => ':attribute trebuie să fie mai mic sau egal cu :value kilobytes.',
        'numeric' => ':attribute trebuie să fie mai mic sau egal cu :value.',
        'string' => ':attribute trebuie să fie mai mic sau egal cu :value caractere.',
    ],
    'mac_address' => ':attribute trebuie să fie o adresă MAC validă.',
    'max' => [
        'array' => ':attribute nu trebuie să aibă mai mult de :max elemente.',
        'file' => ':attribute nu trebuie să fie mai mare de :max kiloocteţi.',
        'numeric' => ':attribute nu trebuie să fie mai mare de :max.',
        'string' => ':attribute nu trebuie să fie mai mare de :max caractere.',
    ],
    'max_digits' => ':attribute nu trebuie să aibă mai mult de :max cifre.',
    'mimes' => ':attribute trebuie să fie un fişier de tipul: :values.',
    'mimetypes' => ':attribute trebuie să fie un fişier de tipul: :values.',
    'min' => [
        'array' => 'Câmpul :attribute trebuie s? aib? cel pu?in :min elemente.',
        'file' => ':attribute trebuie să aibă cel puţin :min kiloocteţi.',
        'numeric' => ':attribute trebuie să aibă cel puţin :min.',
        'string' => ':attribute trebuie să aibă cel puţin :min caractere.',
    ],
    'min_digits' => 'Câmpul :attribute trebuie s? aib? cel pu?in :min cifre.',
    'multiple_of' => 'Câmpul :attribute trebuie s? fie un multiplu de :value.',
    'not_in' => ':attribute selectat nu este valid.',
    'not_regex' => 'Câmpul :attribute nu este valid.',
    'numeric' => ':attribute trebuie să fie un număr.',
    'password' => [
        'letters' => ':attribute trebuie să conțină cel puțin o literă.',
        'mixed' => ':attribute trebuie să conțină cel puțin o majusculă și o literă mică.',
        'numbers' => ':attribute trebuie să conțină cel puțin un număr.',
        'symbols' => ':attribute trebuie să conțină cel puțin un simbol.',
        'uncompromised' => 'Câmpul :attribute a apărut într-o pierdere de date. Vă rugăm să alegeți alt :attribute.',
    ],
    'present' => 'Câmpul :attribute trebuie să fie prezent.',
    'prohibited' => 'Câmpul :attribute este interzis.',
    'prohibited_if' => 'Câmpul :attribute este interzis atunci când :other este :value.',
    'prohibited_unless' => 'Câmpul :attribute este interzis, cu excepția cazului :other este în :values.',
    'prohibits' => 'Câmpul :attribute interzice :other să fie prezent.',
    'regex' => 'Câmpul :attribute nu este valid.',
    'required' => 'Câmpul :attribute este necesar.',
    'required_array_keys' => 'Câmpul :attribute trebuie să conțină intrări pentru: :values.',
    'required_if' => 'Câmpul :attribute este obligatoriu atunci când :other este :value.',
    'required_unless' => 'Câmpul :attribute este necesar, cu excepția cazului :other este în :values.',
    'required_with' => 'Câmpul :attribute este necesar când :values este prezent.',
    'required_with_all' => 'Câmpul :attribute este necesar când :values sunt prezente.',
    'required_without' => 'Câmpul :attribute este obligatoriu atunci când :values nu este prezent.',
    'required_without_all' => 'Câmpul :attribute este necesar când niciuna dintre :values nu este prezentă.',
    'same' => ':attribute și :other trebuie să se potrivească.',
    'size' => [
        'array' => 'Câmpul :attribute trebuie s? aib? :size elemente.',
        'file' => 'Câmpul :attribute trebuie s? aib? :size kiloocte?i.',
        'numeric' => ':attribute trebuie să fie :size.',
        'string' => ':attribute trebuie să aibă :size caractere.',
    ],
    'starts_with' => ':attribute trebuie să înceapă cu una dintre următoarele: :values.',
    'string' => 'Câmpul :attribute trebuie s? fie un string.',
    'timezone' => ':attribute trebuie să fie un fus orar valid.',
    'unique' => ':attribute a fost deja folosit.',
    'uploaded' => ':attribute nu a putut fi incarcat.',
    'url' => ':attribute trebuie să fie un URL valid.',
    'uuid' => ':attribute trebuie să fie un UUID valid.',

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
            'rule-name' => 'mesaj-personalizat',
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
