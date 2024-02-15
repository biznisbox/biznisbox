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

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'array' => 'The :attribute must have between :min and :max items.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'numeric' => 'The :attribute must be between :min and :max.',
        'string' => 'The :attribute must be between :min and :max characters.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'Поље :attribute мора имати :digits цифара.',
    'digits_between' => 'Поље :attribute мора бити између :min и :max цифара.',
    'dimensions' => 'Поље :attribute има неисправне димензије слике.',
    'distinct' => 'Поље :attribute има дупли вредност.',
    'doesnt_end_with' => 'Поље :attribute не сме завршавати са једном од следећих вредности: :values.',
    'doesnt_start_with' => 'Поље :attribute не сме почети са једном од следећих вредности: :values.',
    'email' => 'Поље :attribute мора бити важећа адреса е-поште.',
    'ends_with' => 'Поље :attribute мора завршавати са једном од следећих вредности: :values.',
    'enum' => 'Изабрано поље :attribute је неважеће.',
    'exists' => 'Изабрано поље :attribute је неважеће.',
    'file' => 'Поље :attribute мора бити датотека.',
    'filled' => 'Поље :attribute мора имати вредност.',
    'gt' => [
        'array' => 'Поље :attribute мора имати више од :value ставки.',
        'file' => 'Поље :attribute мора бити веће од :value килобајта.',
        'numeric' => 'Поље :attribute мора бити веће од :value.',
        'string' => 'Поље :attribute мора бити веће од :value карактера.',
    ],
    'gte' => [
        'array' => 'Поље :attribute мора имати :value ставки или више.',
        'file' => 'Поље :attribute мора бити веће или једнако :value килобајта.',
        'numeric' => 'Поље :attribute мора бити веће или једнако :value.',
        'string' => 'Поље :attribute мора бити веће или једнако :value карактера.',
    ],
    'image' => 'Поље :attribute мора бити слика.',
    'in' => 'Изабрано поље :attribute је неважеће.',
    'in_array' => 'Поље :attribute не постоји у :other.',
    'integer' => 'Поље :attribute мора бити цео број.',
    'ip' => 'Поље :attribute мора бити важећа IP адреса.',
    'ipv4' => 'Поље :attribute мора бити важећа IPv4 адреса.',
    'ipv6' => 'Поље :attribute мора бити важећа IPv6 адреса.',
    'json' => 'Поље :attribute мора бити важећи JSON низ.',
    'lt' => [
        'array' => 'Поље :attribute мора имати мање од :value ставки.',
        'file' => 'Поље :attribute мора бити мање од :value килобајта.',
        'numeric' => 'Поље :attribute мора бити мање од :value.',
        'string' => 'Поље :attribute мора бити мање од :value знакова.',
    ],
    'lte' => [
        'array' => 'Поље :attribute не сме имати више од :value ставки.',
        'file' => 'Поље :attribute мора бити мање или једнако :value килобајта.',
        'numeric' => 'Поље :attribute мора бити мање или једнако :value.',
        'string' => 'Поље :attribute мора бити мање или једнако :value знакова.',
    ],
    'mac_address' => 'Поље :attribute мора бити важећа MAC адреса.',
    'max' => [
        'array' => 'Поље :attribute не сме имати више од :max ставки.',
        'file' => 'Поље :attribute не сме бити веће од :max килобајта.',
        'numeric' => 'Поље :attribute не сме бити веће од :max.',
        'string' => 'Поље :attribute не сме бити веће од :max знакова.',
    ],
    'max_digits' => 'Поље :attribute не сме имати више од :max цифара.',
    'mimes' => 'Поље :attribute мора бити датотека типа: :values.',
    'mimetypes' => 'Поље :attribute мора бити датотека типа: :values.',
    'min' => [
        'array' => 'Поље :attribute мора имати најмање :min ставки.',
        'file' => 'Поље :attribute мора бити најмање :min килобајта.',
        'numeric' => 'Поље :attribute мора бити најмање :min.',
        'string' => 'Поље :attribute мора имати најмање :min карактера.',
    ],
    'min_digits' => 'Поље :attribute мора имати најмање :min цифара.',
    'multiple_of' => 'Поље :attribute мора бити вишеструко од :value.',
    'not_in' => 'Изабрани :attribute је неважећи.',
    'not_regex' => 'Формат поља :attribute је неважећи.',
    'numeric' => 'Поље :attribute мора бити број.',
    'password' => [
        'letters' => 'Поље :attribute мора садржати бар једно слово.',
        'mixed' => 'Поље :attribute мора садржати бар једно велико и једно мало слово.',
        'numbers' => 'Поље :attribute мора садржати бар један број.',
        'symbols' => 'Поље :attribute мора садржати бар један симбол.',
        'uncompromised' => 'Дато поље :attribute се појавило у просеку. Молимо изаберите друго поље :attribute.',
    ],
    'present' => 'Поље :attribute мора бити присутно.',
    'prohibited' => 'Поље :attribute је забрањено.',
    'prohibited_if' => 'Поље :attribute је забрањено када је :other :value.',
    'prohibited_unless' => 'Поље :attribute је забрањено осим ако :other није у :values.',
    'prohibits' => 'Поље :attribute забрањује присуство :other.',
    'regex' => 'Формат поља :attribute је неважећи.',
    'required' => 'Поље :attribute је обавезно.',
    'required_array_keys' => 'Поље :attribute мора садржати уносе за: :values.',
    'required_if' => 'Поље :attribute је обавезно када је :other :value.',
    'required_unless' => 'Поље :attribute је обавезно осим ако :other није у :values.',
    'required_with' => 'Поље :attribute је обавезно када је :values присутно.',
    'required_with_all' => 'Поље :attribute је обавезно када су присутне :values.',
    'required_without' => 'Поље :attribute је обавезно када :values није присутно.',
    'required_without_all' => 'Поље :attribute је обавезно када ниједна од :values није присутна.',
    'same' => 'Поља :attribute и :other морају бити иста.',
    'size' => [
        'array' => 'Поље :attribute мора садржати :size ставки.',
        'file' => 'Поље :attribute мора бити :size килобајта.',
        'numeric' => 'Поље :attribute мора бити :size.',
        'string' => 'Поље :attribute мора бити :size карактера.',
    ],
    'starts_with' => 'Поље :attribute мора почети са једним од следећих: :values.',
    'string' => 'Поље :attribute мора бити текст.',
    'timezone' => 'Поље :attribute мора бити исправна временска зона.',
    'unique' => 'Поље :attribute је већ заузето.',
    'uploaded' => 'Поље :attribute није успело да се отпреми.',
    'url' => 'Поље :attribute мора бити исправан URL.',
    'uuid' => 'Поље :attribute мора бити исправан UUID.',

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
