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

    'accepted' => ':attribute は、承認される必要があります。',
    'accepted_if' => ':otherが:valueの場合、:attributeを受け付ける必要があります。',
    'active_url' => ':attribute は有効なURLではありません。',
    'after' => ':attribute は :date よりも後の日付にして下さい。',
    'after_or_equal' => ':attribute は :date よりも後の日付か同じ日付にして下さい。',
    'alpha' => ':attributeには、文字を含める必要があります。',
    'alpha_dash' => ':attribute は、文字、数字、ダッシュ、アンダースコアのみ含める必要があります。',
    'alpha_num' => ':attribute は、文字列と数字のみ含める必要があります。',
    'array' => ':attribute は配列にして下さい。',
    'before' => ':attribute は :date よりも前の日付にして下さい。',
    'before_or_equal' => ':attribute は :date よりも前の日付か同じ日にして下さい。',
    'between' => [
        'array' => ':attribute は :min から :max 内のアイテムにして下さい。',
        'file' => ':attribute は :min から :max キロバイトの範囲内にして下さい。',
        'numeric' => ':attribute は :min から :max の範囲内にして下さい。',
        'string' => ':attribute は :min から :max 文字の範囲内にして下さい。',
    ],
    'boolean' => ':attribute フィールドは、true または false にして下さい。',
    'confirmed' => ':attribute の確認が一致しません。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attribute は、有効な日付ではありません。',
    'date_equals' => ':attribute は :date と同じ日付にして下さい。',
    'date_format' => ':attribute は :format と一致しません。',
    'declined' => ':attributeを拒否する必要があります。',
    'declined_if' => ':otherが:valueの場合は、:attributeを拒否してください。',
    'different' => ':attribute と :other は、異なっている必要があります。',
    'digits' => ':attribute は :digits 数字にして下さい。',
    'digits_between' => ':attribute は :min から :max 桁の数字にして下さい。',
    'dimensions' => ':attribute に無効な画像サイズがあります。',
    'distinct' => ':attribute フィールドが重複しています。',
    'doesnt_end_with' => ':attributeは、以下のいずれかの値で終了することはできません。',
    'doesnt_start_with' => ':attributeは、:valuesで始めることはできません。',
    'email' => ':attribute は有効なメールアドレスにして下さい。',
    'ends_with' => ':attribute は、以下のいずれかの値で終了する必要があります。',
    'enum' => '選択した:attributeが正しくありません。',
    'exists' => '選択した:attributeが正しくありません。',
    'file' => ':attribute はファイルにして下さい。',
    'filled' => ':attribute フィールドには値が必要です。',
    'gt' => [
        'array' => ':attribute は :value 以上にして下さい。',
        'file' => ':attribute は :value キロバイト以上にして下さい。',
        'numeric' => ':attribute は :value 以上にして下さい。',
        'string' => ':attribute は :value 文字以上にして下さい。',
    ],
    'gte' => [
        'array' => ':attribute は :value アイテム以上にして下さい。',
        'file' => ':attribute は :value キロバイト以上にして下さい。',
        'numeric' => ':attribute は :value 以上にして下さい。',
        'string' => ':attribute は :value 文字以上にして下さい。',
    ],
    'image' => ':attribute は画像にして下さい。',
    'in' => '選択した:attributeが正しくありません。',
    'in_array' => ':attribute フィールドが :other に存在しません。',
    'integer' => ':attribute は整数にして下さい。',
    'ip' => ':attribute は有効なIPアドレスにして下さい。',
    'ipv4' => ':attribute は有効なIPv4アドレスにして下さい。',
    'ipv6' => ':attribute は有効なIPv6アドレスにして下さい。',
    'json' => ':attribute は有効なJSON文字列にして下さい。',
    'lt' => [
        'array' => ':attribute は :value 以下のアイテムにして下さい。',
        'file' => ':attribute は :value キロバイト未満にして下さい。',
        'numeric' => ':attribute は :value 未満にして下さい。',
        'string' => ':attribute は :value 文字以下にして下さい。',
    ],
    'lte' => [
        'array' => ':attribute は :value 以上にして下さい。',
        'file' => ':attribute は :value キロバイト以下にして下さい。',
        'numeric' => ':attribute は :value 以下にして下さい。',
        'string' => ':attribute は :value 文字以下にして下さい。',
    ],
    'mac_address' => ':attribute は有効なMACアドレスにして下さい。',
    'max' => [
        'array' => ':attribute は :max 以上にして下さい。',
        'file' => ':attribute は :max キロバイト以上にして下さい。',
        'numeric' => ':attribute は :max 以上にして下さい。',
        'string' => ':attribute は :max 文字以上にして下さい。',
    ],
    'max_digits' => ':attribute は :max 桁以上にして下さい。',
    'mimes' => ':attributeには、:values型のファイルを指定してください。',
    'mimetypes' => ':attributeには、:values型のファイルを指定してください。',
    'min' => [
        'array' => ':attribute は :min 以上にして下さい。',
        'file' => ':attribute は :min キロバイト以上にして下さい。',
        'numeric' => ':attribute は、少なくとも :min 以上にして下さい。',
        'string' => ':attribute は、少なくとも :min 文字以上にして下さい。',
    ],
    'min_digits' => ':attribute は、少なくとも :min 数字以上にして下さい。',
    'multiple_of' => ':attribute は :value の倍数にして下さい。',
    'not_in' => '選択した:attributeが正しくありません。',
    'not_regex' => ':attribute フォーマットが不正です。',
    'numeric' => ':attribute は数字にして下さい。',
    'password' => [
        'letters' => ':attribute は、少なくとも1文字以上にして下さい。',
        'mixed' => ':attribute は、少なくとも1つの大文字と小文字を含める必要があります。',
        'numbers' => ':attributeには、少なくとも1つの数値を含める必要があります。',
        'symbols' => ':attributeには、少なくとも1つのシンボルを含める必要があります。',
        'uncompromised' => '指定された :attribute がデータ漏洩になっています。別の:attributeを選択してください。',
    ],
    'present' => ':attribute フィールドは必須です。',
    'prohibited' => ':attribute フィールドは禁止されています。',
    'prohibited_if' => ':other が :value の場合、:attribute フィールドは禁止されています。',
    'prohibited_unless' => ':other が :value でない限り、:attribute フィールドは禁止されています。',
    'prohibits' => ':attribute フィールドに:other の存在が禁止されています。',
    'regex' => ':attribute フォーマットが不正です。',
    'required' => ':attribute フィールドは必須です。',
    'required_array_keys' => ':attribute フィールドには、次のエントリが必要です: :values',
    'required_if' => ':otherが:valueの場合、:attributeを指定してください。',
    'required_unless' => ':other が :value でない限り、:attribute フィールドは必須です。',
    'required_with' => ':valuesが存在する場合、:attributeを指定してください。',
    'required_with_all' => ':valuesが存在する場合、:attributeを指定してください。',
    'required_without' => ':valuesが指定されていない場合、:attributeを指定してください。',
    'required_without_all' => ':valuesが指定されていない場合、:attributeを指定してください。',
    'same' => ':attribute と :other は、一致する必要があります。',
    'size' => [
        'array' => ':attribute は :size にして下さい。',
        'file' => ':attribute は :size キロバイトにして下さい。',
        'numeric' => ':attribute は :size にして下さい。',
        'string' => ':attribute は :size 文字にして下さい。',
    ],
    'starts_with' => ':attribute は、以下のいずれかの値で始まる必要があります。',
    'string' => ':attribute は文字列にして下さい。',
    'timezone' => ':attribute は有効なタイムゾーンにして下さい。',
    'unique' => ':attributeは既に使用されています。',
    'uploaded' => ':attribute のアップロードに失敗しました。',
    'url' => ':attribute は有効なURLにして下さい。',
    'uuid' => ':attribute は有効なUUIDにして下さい。',

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
