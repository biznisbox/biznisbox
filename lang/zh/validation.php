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

    'accepted' => ':attribute 必须被接受。',
    'accepted_if' => ':attribute 必须在 :other 是 :value 时被接受。',
    'active_url' => ':attribute 不是一个有效的 URL。',
    'after' => ':attribute 必须在 :date 之后。',
    'after_or_equal' => ':attribute 必须是晚于或等于 :date 的日期。',
    'alpha' => ':attribute 只能包含字母',
    'alpha_dash' => ':attribute 只能包含字母、 数字、 破折号和下划线。',
    'alpha_num' => ':attribute 只能包含字母和数字。',
    'array' => ':attribute 必须是一个数组。',
    'before' => ':attribute 必须在 :date 之前。',
    'before_or_equal' => ':attribute 必须早于或等于 :date 的日期。',
    'between' => [
        'array' => ':attribute 必须在 :min 到 :max 项目之间。',
        'file' => ':attribute 必须介于 :min 到 :max kb 之间。',
        'numeric' => ':attribute 必须在 :min 到 :max 之间。',
        'string' => ':attribute 必须介于 :min 到 :max 字符之间。',
    ],
    'boolean' => ':attribute 字段必须为 true 或 false。',
    'confirmed' => ':attribute 不匹配',
    'current_password' => '密码不正确。',
    'date' => ':attribute 不是一个有效的日期。',
    'date_equals' => ':attribute 必须等于:date',
    'date_format' => ':attribute 与格式 :format 不匹配。',
    'declined' => ':attribute 必须被拒绝。',
    'declined_if' => ':attribute 必须在 :other 是 :value 时被拒绝。',
    'different' => ':attribute 和 :other 必须不同。',
    'digits' => ':attribute 必须是 :digits 数字',
    'digits_between' => ':attribute 必须介于 :min 到 :max 位数字之间。',
    'dimensions' => ':attribute 的图像尺寸无效。',
    'distinct' => ':attribute 具有重复值。',
    'doesnt_end_with' => ':attribute 不能以以下一个结尾：:values',
    'doesnt_start_with' => ':attribute 不能以以下一个开始：:value。',
    'email' => ':attribute 必须是一个有效的电子邮件地址。',
    'ends_with' => ':attribute 必须以以下一个结尾：:values',
    'enum' => '选中的 :attribute 无效。',
    'exists' => '选中的 :attribute 无效。',
    'file' => ':attribute 必须是一个文件。',
    'filled' => ':attribute 字段必须有一个值。',
    'gt' => [
        'array' => ':attribute 必须超过 :value 项。',
        'file' => ':attribute 必须大于 :value kbytes。',
        'numeric' => ':attribute 必须大于 :value',
        'string' => ':attribute 必须大于 :value 字符。',
    ],
    'gte' => [
        'array' => ':attribute 必须有 :value 项目或更多。',
        'file' => ':attribute 必须大于或等于 :value kbytes。',
        'numeric' => ':attribute 必须大于或等于 :value',
        'string' => ':attribute 必须大于或等于 :value 字符。',
    ],
    'image' => ':attribute 必须是一个图像。',
    'in' => '选中的 :attribute 无效。',
    'in_array' => ':attribute 字段不存在 :other 中。',
    'integer' => ':attribute 必须是整数。',
    'ip' => ':attribute 必须是一个有效的 IP 地址。',
    'ipv4' => ':attribute 必须是一个有效的IPv4地址。',
    'ipv6' => ':attribute 必须是一个有效的IPv6地址。',
    'json' => ':attribute 必须是一个有效的 JSON 字符串。',
    'lt' => [
        'array' => ':attribute 必须小于 :value 项。',
        'file' => ':attribute 必须小于 :value kbytes。',
        'numeric' => ':attribute 必须小于 :value',
        'string' => ':attribute 必须小于 :value 字符。',
    ],
    'lte' => [
        'array' => ':attribute 不能超过 :value 项。',
        'file' => ':attribute 必须小于或等于 :value kbytes。',
        'numeric' => ':attribute 必须小于或等于 :value',
        'string' => ':attribute 必须小于或等于 :value 字符。',
    ],
    'mac_address' => ':attribute 必须是一个有效的 MAC 地址。',
    'max' => [
        'array' => ':attribute 不能超过 :max 项。',
        'file' => ':attribute 不能大于 :max kbytes。',
        'numeric' => ':attribute 不能大于 :max',
        'string' => ':attribute 不能大于 :max 字符。',
    ],
    'max_digits' => ':attribute 不能超过 :max 数字。',
    'mimes' => ':attribute 必须是一个类型的文件：:values',
    'mimetypes' => ':attribute 必须是一个类型的文件：:values',
    'min' => [
        'array' => ':attribute 必须至少有 :min 项',
        'file' => ':attribute 必须至少 :min 千字节。',
        'numeric' => ':attribute 必须至少 :min。',
        'string' => ':attribute 必须至少 :min 字符。',
    ],
    'min_digits' => ':attribute 必须至少 :min 位数字。',
    'multiple_of' => ':attribute 必须是 :value 的倍数。',
    'not_in' => '选中的 :attribute 无效。',
    'not_regex' => ':attribute 格式不正确。',
    'numeric' => ':attribute 必须是一个数字。',
    'password' => [
        'letters' => ':attribute 必须包含至少一个字母。',
        'mixed' => ':attribute 必须至少包含一个大写字母和一个小写字母。',
        'numbers' => ':attribute 必须至少包含一个数字。',
        'symbols' => ':attribute 必须至少包含一个符号。',
        'uncompromised' => '给定的 :attribute 出现在数据泄漏中。请选择一个不同的 :attribute 。',
    ],
    'present' => ':attribute 字段必须存在',
    'prohibited' => ':attribute 字段被禁止。',
    'prohibited_if' => '当:other 是 :value 时，:attribute 字段被禁止。',
    'prohibited_unless' => ':attribute 字段被禁止，除非:other 在 :values.',
    'prohibits' => ':attribute 字段禁用 :other 存在。',
    'regex' => ':attribute 格式不正确。',
    'required' => ':attribute 字段是必需的。',
    'required_array_keys' => ':attribute 字段必须包含: :values',
    'required_if' => '当:other 是 :value 时，:attribute 字段是必需的。',
    'required_unless' => ':attribute 字段是必需的，除非:other 是 :values.',
    'required_with' => ':attribute 字段是必需的 :values 是存在的。',
    'required_with_all' => ':attribute 字段是必需的 :values 是存在的。',
    'required_without' => '当:values 不存在时，:attribute 字段是必需的。',
    'required_without_all' => '当没有 :values 不存在时，:attribute 字段是必需的。',
    'same' => ':attribute 和 :other 必须匹配。',
    'size' => [
        'array' => ':attribute 必须包含 :size 项。',
        'file' => ':attribute 必须是 :size kobytes。',
        'numeric' => ':attribute 必须是 :size',
        'string' => ':attribute 必须是 :size 字符。',
    ],
    'starts_with' => ':attribute 必须以以下一个开始：:values',
    'string' => ':attribute 必须是一个字符串。',
    'timezone' => ':attribute 必须是一个有效的时区。',
    'unique' => ':attribute 已经被占用。',
    'uploaded' => ':attribute 上传失败。',
    'url' => ':attribute 必须是一个有效的 URL。',
    'uuid' => ':attribute 必须是一个有效的 UUID。',

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
            'rule-name' => '自定义消息',
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
