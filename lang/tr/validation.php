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

    'accepted' => 'The :attribute kabul edilmelidir.',
    'accepted_if' => 'The :attribute, :other :value olduğunda kabul edilmelidir.',
    'active_url' => 'The :attribute geçerli bir URL değil.',
    'after' => 'The :attribute :date tarihinden sonra olmalıdır.',
    'after_or_equal' => 'The :attribute :date tarihinden sonra veya aynı tarihte olmalıdır.',
    'alpha' => 'The :attribute sadece harfler içermelidir.',
    'alpha_dash' => 'The :attribute sadece harfler, rakamlar, tireler ve alt çizgiler içermelidir.',
    'alpha_num' => 'The :attribute sadece harfler ve rakamlar içermelidir.',
    'array' => 'The :attribute bir dizi olmalıdır.',
    'before' => 'The :attribute :date tarihinden önce olmalıdır.',
    'before_or_equal' => 'The :attribute :date tarihinden önce veya aynı tarihte olmalıdır.',
    'between' => [
        'array' => 'The :attribute :min ve :max öğe arasında olmalıdır.',
        'file' => 'The :attribute :min ve :max kilobayt arasında olmalıdır.',
        'numeric' => 'The :attribute :min ve :max arasında olmalıdır.',
        'string' => 'The :attribute :min ve :max karakter arasında olmalıdır.',
    ],
    'boolean' => 'The :attribute alanı doğru veya yanlış olmalıdır.',
    'confirmed' => 'The :attribute onayı uyuşmuyor.',
    'current_password' => 'Şifre yanlış.',
    'date' => 'The :attribute geçerli bir tarih değil.',
    'date_equals' => 'The :attribute :date ile aynı tarihte olmalıdır.',
    'date_format' => 'The :attribute :format formatına uymuyor.',
    'declined' => 'The :attribute reddedilmelidir.',
    'declined_if' => 'The :attribute, :other :value olduğunda reddedilmelidir.',
    'different' => 'The :attribute ve :other farklı olmalıdır.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'doesnt_end_with' => 'The :attribute may not end with one of the following: :values.',
    'doesnt_start_with' => 'The :attribute may not start with one of the following: :values.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'array' => 'The :attribute must have more than :value items.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'numeric' => 'The :attribute must be greater than :value.',
        'string' => 'The :attribute must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute must have :value items or more.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => '\':attribute\' geçerli bir IP adresi olmalıdır.',
    'ipv4' => '\':attribute\' geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => '\':attribute\' geçerli bir IPv6 adresi olmalıdır.',
    'json' => '\':attribute\' geçerli bir JSON dizgesi olmalıdır.',
    'lt' => [
        'array' => '\':attribute\' öğesinin :value öğeden az olması gerekmektedir.',
        'file' => '\':attribute\' öğesinin boyutu :value kilobayttan az olmalıdır.',
        'numeric' => '\':attribute\' değeri :value\'dan az olmalıdır.',
        'string' => '\':attribute\' öğesinin uzunluğu :value karakterden az olmalıdır.',
    ],
    'lte' => [
        'array' => '\':attribute\' öğesinin :value öğeden fazla olmaması gerekmektedir.',
        'file' => '\':attribute\' öğesinin boyutu :value kilobayt veya daha az olmalıdır.',
        'numeric' => '\':attribute\' değeri :value veya daha az olmalıdır.',
        'string' => '\':attribute\' öğesinin uzunluğu :value karakter veya daha az olmalıdır.',
    ],
    'mac_address' => '\':attribute\' geçerli bir MAC adresi olmalıdır.',
    'max' => [
        'array' => '\':attribute\' öğesinin :max öğeden fazla olmaması gerekmektedir.',
        'file' => '\':attribute\' öğesinin boyutu :max kilobayttan fazla olmamalıdır.',
        'numeric' => '\':attribute\' değeri :max\'dan büyük olmamalıdır.',
        'string' => '\':attribute\' öğesinin uzunluğu :max karakterden fazla olmamalıdır.',
    ],
    'max_digits' => '\':attribute\' öğesinin uzunluğu :max basamaktan fazla olmamalıdır.',
    'mimes' => '\':attribute\' öğesi :values türünde bir dosya olmalıdır.',
    'mimetypes' => '\':attribute\' öğesi :values türünde bir dosya olmalıdır.',
    'min' => [
        'array' => '\':attribute\' öğesinin en az :min öğesi olmalıdır.',
        'file' => '\':attribute\' öğesinin boyutu en az :min kilobayt olmalıdır.',
        'numeric' => '\':attribute\' değeri en az :min olmalıdır.',
        'string' => 'attribute en az :min karakter olmalıdır.',
    ],
    'min_digits' => 'attribute en az :min basamaklı olmalıdır.',
    'multiple_of' => 'attribute :value sayısının katı olmalıdır.',
    'not_in' => 'Seçilen :attribute geçersiz.',
    'not_regex' => 'attribute biçimi geçersiz.',
    'numeric' => 'attribute bir sayı olmalıdır.',
    'password' => [
        'letters' => 'attribute en az bir harf içermelidir.',
        'mixed' => 'attribute en az bir büyük harf ve bir küçük harf içermelidir.',
        'numbers' => 'attribute en az bir rakam içermelidir.',
        'symbols' => 'attribute en az bir sembol içermelidir.',
        'uncompromised' => 'Verilen :attribute bir veri sızıntısında göründü. Lütfen farklı bir :attribute seçin.',
    ],
    'present' => 'attribute alanı mevcut olmalıdır.',
    'prohibited' => 'attribute alanı yasaktır.',
    'prohibited_if' => 'attribute alanı :other :value olduğunda yasaktır.',
    'prohibited_unless' => 'attribute alanı :other :values içinde olmadığı sürece yasaktır.',
    'prohibits' => 'attribute alanı :other mevcut olduğunda yasaktır.',
    'regex' => 'attribute biçimi geçersiz.',
    'required' => 'attribute alanı gereklidir.',
    'required_array_keys' => 'attribute alanı için :values girişleri gereklidir.',
    'required_if' => 'attribute alanı :other :value olduğunda gereklidir.',
    'required_unless' => 'attribute alanı :other :values içinde olmadığında gereklidir.',
    'required_with' => 'attribute alanı :values mevcut olduğunda gereklidir.',
    'required_with_all' => 'attribute alanı :values mevcut olduğunda gereklidir.',
    'required_without' => 'Alanın :attribute, :values yokken zorunludur.',
    'required_without_all' => 'Alanın :attribute, :values\'in hiçbiri yokken zorunludur.',
    'same' => 'Alanın :attribute ve :other eşleşmelidir.',
    'size' => [
        'array' => 'Alanın :attribute, :size öğe içermesi gerekmektedir.',
        'file' => 'Alanın :attribute, :size kilobayt olması gerekmektedir.',
        'numeric' => 'Alanın :attribute, :size olması gerekmektedir.',
        'string' => '\':attribute\' :size karakter olmalıdır.',
    ],
    'starts_with' => '\':attribute\' şunlardan biriyle başlamalıdır: :values.',
    'string' => '\':attribute\' bir dize olmalıdır.',
    'timezone' => '\':attribute\' geçerli bir zaman dilimi olmalıdır.',
    'unique' => '\':attribute\' zaten alınmıştır.',
    'uploaded' => '\':attribute\' yüklenemedi.',
    'url' => '\':attribute\' geçerli bir URL olmalıdır.',
    'uuid' => '\':attribute\' geçerli bir UUID olmalıdır.',

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
            'rule-name' => 'özel-mesaj',
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
