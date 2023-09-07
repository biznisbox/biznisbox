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

    'accepted' => ':attribute يجب قبوله.',
    'accepted_if' => 'يجب قبول :attribute عندما يكون :other :value.',
    'active_url' => ':attribute ليس عنوان URL صالح.',
    'after' => 'يجب أن يكون تاريخ :attribute بعد :date.',
    'after_or_equal' => 'يجب أن يكون تاريخ :attribute بعد أو يساوي :date.',
    'alpha' => ':attribute يجب أن يحتوي على أحرف فقط.',
    'alpha_dash' => ':attribute يجب أن يحتوي فقط على أحرف وأرقام وشرطات والشرطات السفلية السفلية.',
    'alpha_num' => ':attribute يجب أن يحتوي فقط على أحرف وأرقام.',
    'array' => 'يجب أن يكون :attribute مصفوف.',
    'before' => 'يجب أن يكون تاريخ :attribute قبل :date.',
    'before_or_equal' => 'يجب أن يكون تاريخ :attribute قبل أو يساوي :date.',
    'between' => [
        'array' => 'يجب أن يكون :attribute بين :min و :max من العناصر.',
        'file' => 'يجب أن يكون :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن يكون :attribute بين :min و :max.',
        'string' => 'يجب أن يكون :attribute بين :min و :max حرفاً.',
    ],
    'boolean' => 'يجب أن يكون الحقل :attribute صحيحا أو خاطئا.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => ':attribute تاريخ غير صالح.',
    'date_equals' => 'يجب أن يكون تاريخ :attribute مساوياً لـ :date.',
    'date_format' => ':attribute لا يتطابق مع تنسيق :format.',
    'declined' => ':attribute يجب رفضه.',
    'declined_if' => 'يجب رفض :attribute عندما يكون :other :value.',
    'different' => ':attribute و :other يجب أن يكونا مختلفين.',
    'digits' => 'يجب أن يكون :attribute :digits أرقام',
    'digits_between' => 'يجب أن يكون :attribute بين :min و :max رقم.',
    'dimensions' => ':attribute له أبعاد صورة غير صالحة.',
    'distinct' => 'يحتوي الحقل :attribute على قيمة مكررة.',
    'doesnt_end_with' => ':attribute قد لا ينتهي بواحد مما يلي: :values.',
    'doesnt_start_with' => ':attribute قد لا تبدأ بواحد مما يلي: :values.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالح.',
    'ends_with' => 'يجب أن تنتهي خانة :attribute بواحد مما يلي: :values.',
    'enum' => ':attribute المحدد غير صالح.',
    'exists' => ':attribute المحدد غير صالح.',
    'file' => 'يجب أن يكون :attribute ملفاً.',
    'filled' => 'يجب أن يكون الحقل :attribute قيمة.',
    'gt' => [
        'array' => 'يجب أن يحتوي :attribute على أكثر من :value عنصرة.',
        'file' => ':attribute يجب أن يكون أكبر من :value kilobytes.',
        'numeric' => ':attribute يجب أن يكون أكبر من :value.',
        'string' => 'يجب أن يكون :attribute أكبر من :value حرف.',
    ],
    'gte' => [
        'array' => ':attribute يجب أن يحتوي على :value عنصر أو أكثر.',
        'file' => ':attribute يجب أن يكون أكبر من أو يساوي :value kilobytes.',
        'numeric' => 'يجب أن يكون :attribute أكبر من أو يساوي :value.',
        'string' => 'يجب أن يكون :attribute أكبر من أو يساوي :value الأحرف.',
    ],
    'image' => 'يجب أن تكون :attribute صورة.',
    'in' => ':attribute المحدد غير صالح.',
    'in_array' => 'الحقل :attribute غير موجود في :other.',
    'integer' => ':attribute يجب أن يكون عددًا صحيحًا.',
    'ip' => 'يجب أن يكون :attribute عنوان IP صالح.',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صالح.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صالح.',
    'json' => 'يجب أن يكون :attribute سلسلة JSON صالحة.',
    'lt' => [
        'array' => ':attribute يجب أن يحتوي على أقل من :value عنصرة.',
        'file' => ':attribute يجب أن يكون أقل من :value kilobytes.',
        'numeric' => ':attribute يجب أن يكون أقل من :value.',
        'string' => 'يجب أن يكون :attribute أقل من :value حرف.',
    ],
    'lte' => [
        'array' => ':attribute يجب أن لا يحتوي على أكثر من :value عنصرا.',
        'file' => ':attribute يجب أن يكون أقل من أو يساوي :value kilobytes.',
        'numeric' => 'يجب أن يكون :attribute أقل من أو يساوي :value.',
        'string' => 'يجب أن يكون :attribute أقل من أو يساوي :value الأحرف.',
    ],
    'mac_address' => 'يجب أن يكون :attribute عنوان MAC صالح.',
    'max' => [
        'array' => ':attribute يجب ألا يحتوي على أكثر من :max من العناصر.',
        'file' => ':attribute يجب أن لا يكون أكبر من :max كيلوبايت.',
        'numeric' => ':attribute يجب أن لا يكون أكبر من :max.',
        'string' => 'يجب أن لا يكون :attribute أكبر من :max حرفاً.',
    ],
    'max_digits' => ':attribute يجب ألا يحتوي على أكثر من :max رقم.',
    'mimes' => 'يجب أن يكون :attribute ملف من النوع: :values.',
    'mimetypes' => 'يجب أن يكون :attribute ملف من النوع: :values.',
    'min' => [
        'array' => 'يجب أن يحتوي :attribute على عناصر :min على الأقل.',
        'file' => ':attribute يجب أن يكون على الأقل :min kilobytes.',
        'numeric' => ':attribute يجب أن يكون على الأقل :min.',
        'string' => ':attribute يجب أن يكون على الأقل :min حرفاً.',
    ],
    'min_digits' => 'يجب أن يكون :attribute على الأقل :min الرقم.',
    'multiple_of' => 'يجب أن يكون :attribute مضاعفا من :value.',
    'not_in' => ':attribute المحدد غير صالح.',
    'not_regex' => 'صيغة :attribute غير صالحة.',
    'numeric' => ':attribute يجب أن يكون رقما.',
    'password' => [
        'letters' => 'يجب أن يحتوي :attribute على حرف واحد على الأقل.',
        'mixed' => 'يجب أن يحتوي :attribute على حرف كبير واحد وحرف صغير واحد على الأقل.',
        'numbers' => 'يجب أن يحتوي :attribute على رقم واحد على الأقل.',
        'symbols' => 'يجب أن يحتوي :attribute على رمز واحد على الأقل.',
        'uncompromised' => 'لقد ظهر :attribute المعطى في تسرب البيانات. الرجاء اختيار :attribute.',
    ],
    'present' => 'يجب أن يكون الحقل :attribute موجودا.',
    'prohibited' => 'حقل :attribute محظور.',
    'prohibited_if' => 'الحقل :attribute محظور عندما يكون :other :value.',
    'prohibited_unless' => 'الحقل :attribute محظور ما لم يكن :other في :values.',
    'prohibits' => 'الحقل :attribute يمنع :other من أن تكون حاضرا.',
    'regex' => 'صيغة :attribute غير صالحة.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'يجب أن يحتوي الحقل :attribute على إدخالات لـ:values.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other :value.',
    'required_unless' => 'الحقل :attribute مطلوب ما لم يكن :other في :values.',
    'required_with' => 'حقل :attribute مطلوب عند وجود :valu.',
    'required_with_all' => 'حقل :attribute مطلوب عند وجود :valu.',
    'required_without' => 'حقل :attribute مطلوب عندما يكون :values غير موجود.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا يوجد أي من :valu.',
    'same' => ':attribute و :other يجب أن يتطابق.',
    'size' => [
        'array' => 'يجب أن يحتوي :attribute على :size من العناصر.',
        'file' => ':attribute يجب أن يكون :size كيلوبايت.',
        'numeric' => ':attribute يجب أن يكون :size.',
        'string' => ':attribute يجب أن يكون :size حرفاً.',
    ],
    'starts_with' => 'يجب أن تبدأ خانة :attribute بواحد مما يلي: :values.',
    'string' => 'يجب أن يكون :attribute سلسلة.',
    'timezone' => 'يجب أن يكون :attribute منطقة زمنية صالحة.',
    'unique' => ':attribute تم أخذه مسبقاً.',
    'uploaded' => 'فشل تحميل :attribute',
    'url' => 'يجب أن يكون :attribute عنوان URL صالح.',
    'uuid' => 'يجب أن يكون :attribute UID.',

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
            'rule-name' => 'رسالة مخصصة',
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
