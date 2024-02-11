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

    'accepted' => '必須接受 :attribute。',
    'accepted_if' => '當 :other 為 :value 時，必須接受 :attribute。',
    'active_url' => ':attribute 不是有效的 URL。',
    'after' => ':attribute 必須是 :date 之後的日期。',
    'after_or_equal' => ':attribute 必須是 :date 之後或等於的日期。',
    'alpha' => ':attribute 只能包含字母。',
    'alpha_dash' => ':attribute 只能包含字母、數字、破折號和底線。',
    'alpha_num' => ':attribute 只能包含字母和數字。',
    'array' => ':attribute 必須是一個陣列。',
    'before' => ':attribute 必須是 :date 之前的日期。',
    'before_or_equal' => ':attribute 必須是 :date 之前或等於的日期。',
    'between' => [
        'array' => ':attribute 必須有 :min 至 :max 個項目。',
        'file' => ':attribute 必須介於 :min 至 :max 千位元組之間。',
        'numeric' => ':attribute 必須介於 :min 至 :max 之間。',
        'string' => ':attribute 必須是 :min 至 :max 個字元。',
    ],
    'boolean' => ':attribute 欄位必須是 true 或 false。',
    'confirmed' => ':attribute 確認不符。',
    'current_password' => '密碼不正確。',
    'date' => ':attribute 不是有效的日期。',
    'date_equals' => ':attribute 必須是 :date 相等的日期。',
    'date_format' => ':attribute 不符合格式 :format。',
    'declined' => ':attribute 必須被拒絕。',
    'declined_if' => '當 :other 為 :value 時，必須被拒絕 :attribute。',
    'different' => ':attribute 和 :other 必須不同。',
    'digits' => '必須是 :digits 位數字。',
    'digits_between' => '必須介於 :min 至 :max 位數字之間。',
    'dimensions' => '圖片尺寸無效。',
    'distinct' => '該欄位已存在重複值。',
    'doesnt_end_with' => '不得以以下任何一個值結尾：:values。',
    'doesnt_start_with' => '不得以以下任何一個值開頭：:values。',
    'email' => '必須是有效的電子郵件地址。',
    'ends_with' => '必須以以下任何一個值結尾：:values。',
    'enum' => '所選的 :attribute 無效。',
    'exists' => '所選的 :attribute 無效。',
    'file' => '必須是檔案。',
    'filled' => '該欄位必須有值。',
    'gt' => [
        'array' => '必須有超過 :value 個項目。',
        'file' => '必須大於 :value KB。',
        'numeric' => '必須大於 :value。',
        'string' => '必須大於 :value 個字元。',
    ],
    'gte' => [
        'array' => '必須有 :value 個項目或更多。',
        'file' => '必須大於或等於 :value KB。',
        'numeric' => '必須大於或等於 :value。',
        'string' => '必須大於或等於 :value 個字元。',
    ],
    'image' => '必須是圖片。',
    'in' => '所選的 :attribute 無效。',
    'in_array' => '該欄位在 :other 中不存在。',
    'integer' => '必須是整數。',
    'ip' => ':attribute 必須是有效的 IP 位址。',
    'ipv4' => ':attribute 必須是有效的 IPv4 位址。',
    'ipv6' => ':attribute 必須是有效的 IPv6 位址。',
    'json' => ':attribute 必須是有效的 JSON 字串。',
    'lt' => [
        'array' => ':attribute 必須少於 :value 個項目。',
        'file' => ':attribute 必須小於 :value KB。',
        'numeric' => ':attribute 必須小於 :value。',
        'string' => ':attribute 必須少於 :value 個字元。',
    ],
    'lte' => [
        'array' => ':attribute 不得超過 :value 個項目。',
        'file' => ':attribute 必須小於或等於 :value KB。',
        'numeric' => ':attribute 必須小於或等於 :value。',
        'string' => ':attribute 必須小於或等於 :value 個字元。',
    ],
    'mac_address' => ':attribute 必須是有效的 MAC 位址。',
    'max' => [
        'array' => ':attribute 不得超過 :max 個項目。',
        'file' => ':attribute 不得大於 :max KB。',
        'numeric' => ':attribute 不得大於 :max。',
        'string' => ':attribute 不得大於 :max 個字元。',
    ],
    'max_digits' => ':attribute 不得超過 :max 個位數。',
    'mimes' => ':attribute 必須是以下類型的檔案: :values。',
    'mimetypes' => ':attribute 必須是以下類型的檔案: :values。',
    'min' => [
        'array' => ':attribute 必須至少有 :min 個項目。',
        'file' => ':attribute 必須至少 :min KB。',
        'numeric' => ':attribute 必須至少為 :min。',
        'string' => ':attribute 必須至少為 :min 個字符。',
    ],
    'min_digits' => ':attribute 必須至少有 :min 個數字。',
    'multiple_of' => ':attribute 必須是 :value 的倍數。',
    'not_in' => '所選的 :attribute 無效。',
    'not_regex' => ':attribute 格式無效。',
    'numeric' => ':attribute 必須是一個數字。',
    'password' => [
        'letters' => ':attribute 必須包含至少一個字母。',
        'mixed' => ':attribute 必須包含至少一個大寫字母和一個小寫字母。',
        'numbers' => ':attribute 必須包含至少一個數字。',
        'symbols' => ':attribute 必須包含至少一個符號。',
        'uncompromised' => '所提供的 :attribute 已出現在數據泄露中。請選擇不同的 :attribute。',
    ],
    'present' => ':attribute 字段必須存在。',
    'prohibited' => '禁止使用 :attribute 字段。',
    'prohibited_if' => '當 :other 為 :value 時，禁止使用 :attribute 字段。',
    'prohibited_unless' => '除非 :other 在 :values 中，否則禁止使用 :attribute 字段。',
    'prohibits' => '禁止 :other 出現時使用 :attribute 字段。',
    'regex' => ':attribute 格式無效。',
    'required' => ':attribute 字段是必需的。',
    'required_array_keys' => ':attribute 字段必須包含以下項目： :values。',
    'required_if' => '當 :other 為 :value 時， :attribute 字段是必需的。',
    'required_unless' => '除非 :other 在 :values 中，否則 :attribute 字段是必需的。',
    'required_with' => '當 :values 存在時， :attribute 字段是必需的。',
    'required_with_all' => '當 :values 存在時，:attribute 欄位是必需的。',
    'required_without' => '當 :values 不存在時，:attribute 欄位是必需的。',
    'required_without_all' => '當 :values 都不存在時，:attribute 欄位是必需的。',
    'same' => ':attribute 和 :other 必須相符。',
    'size' => [
        'array' => ':attribute 必須包含 :size 項目。',
        'file' => ':attribute 必須是 :size 千字節。',
        'numeric' => ':attribute 必須是 :size。',
        'string' => 'attribute 必須是 :size 個字元。',
    ],
    'starts_with' => 'attribute 必須以以下之一開頭: :values。',
    'string' => 'attribute 必須是字串。',
    'timezone' => 'attribute 必須是有效的時區。',
    'unique' => 'attribute 已經存在。',
    'uploaded' => 'attribute 上傳失敗。',
    'url' => 'attribute 必須是有效的網址。',
    'uuid' => 'attribute 必須是有效的 UUID。',

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
            'rule-name' => '自訂訊息',
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
