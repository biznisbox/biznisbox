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

    'accepted' => 'Поле :attribute должно быть принято.',
    'accepted_if' => 'Значение :attribute должно быть принято, когда :other равно :value.',
    'active_url' => ':attribute не является допустимым URL.',
    'after' => ':attribute должен быть датой после :date.',
    'after_or_equal' => 'Значение :attribute должно быть датой после или равным :date.',
    'alpha' => 'Поле :attribute должно содержать только буквы.',
    'alpha_dash' => ':attribute должен содержать только буквы, цифры, тире и знаки подчеркивания.',
    'alpha_num' => 'Поле :attribute должно содержать только буквы и цифры.',
    'array' => ':attribute должен быть массивом.',
    'before' => ':attribute должно быть датой до :date.',
    'before_or_equal' => 'Значение :attribute должно быть датой до или равным :date.',
    'between' => [
        'array' => ':attribute должен иметь между :min и :max элементов.',
        'file' => ':attribute должен быть между :min и :max килобайт.',
        'numeric' => 'Поле :attribute должно быть между :min и :max.',
        'string' => 'Значение :attribute должно быть между :min и :max символов.',
    ],
    'boolean' => 'Поле :attribute должно быть true или false.',
    'confirmed' => 'Подтверждение :attribute не совпадает.',
    'current_password' => 'Неверный пароль.',
    'date' => ':attribute не является допустимой датой.',
    'date_equals' => 'Значение :attribute должно быть датой равной :date.',
    'date_format' => ':attribute не соответствует формату :format.',
    'declined' => ':attribute должен быть отклонен.',
    'declined_if' => 'Поле :attribute должно быть отклонено, когда :other равно :value.',
    'different' => ':attribute и :other должны быть разными.',
    'digits' => 'Значение :attribute должно быть :digits цифр.',
    'digits_between' => ':attribute должен быть между :min и :max цифр.',
    'dimensions' => 'Поле :attribute имеет неверные размеры изображения.',
    'distinct' => 'Поле :attribute имеет повторяющееся значение.',
    'doesnt_end_with' => ':attribute не может заканчиваться одним из следующих значений: :values.',
    'doesnt_start_with' => ':attribute не может начинаться с одного из следующих значений: :values.',
    'email' => 'Поле :attribute должно быть действительным адресом электронной почты.',
    'ends_with' => 'Значение :attribute должно заканчиваться одним из следующих: :values.',
    'enum' => 'Выбранный :attribute неверен.',
    'exists' => 'Выбранный :attribute неверен.',
    'file' => 'Поле :attribute должно быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'array' => 'Поле :attribute должно содержать больше чем :value-элементов.',
        'file' => 'Значение :attribute должно быть больше :value килобайт.',
        'numeric' => 'Значение :attribute должно быть больше чем :value.',
        'string' => 'Значение :attribute должно быть больше чем :value символов.',
    ],
    'gte' => [
        'array' => ':attribute должен иметь :value элементы или больше.',
        'file' => 'Значение :attribute должно быть больше или равно :value килобайт.',
        'numeric' => 'Значение :attribute должно быть больше или равно :value.',
        'string' => 'Значение :attribute должно быть больше или равно знакам :value.',
    ],
    'image' => 'Поле :attribute должно быть изображением.',
    'in' => 'Выбранный :attribute неверен.',
    'in_array' => 'Поле :attribute не существует в :other.',
    'integer' => ':attribute должно быть целым числом.',
    'ip' => 'Поле :attribute должно быть действительным IP-адресом.',
    'ipv4' => ':attribute должно быть допустимым IPv4 адресом.',
    'ipv6' => ':attribute должно быть допустимым IPv6 адресом.',
    'json' => ':attribute должен быть допустимой строкой JSON.',
    'lt' => [
        'array' => 'Значение :attribute должно быть меньше чем :value.',
        'file' => 'Значение :attribute должно быть меньше :value килобайт.',
        'numeric' => 'Значение :attribute должно быть меньше, чем :value.',
        'string' => 'Значение :attribute должно быть меньше :value.',
    ],
    'lte' => [
        'array' => 'Поле :attribute не должно содержать больше чем :value-элементов.',
        'file' => 'Значение :attribute должно быть меньше или равно :value килобайт.',
        'numeric' => 'Значение :attribute должно быть меньше или равно :value.',
        'string' => 'Значение :attribute должно быть меньше или равно знакам :value.',
    ],
    'mac_address' => 'Поле :attribute должно быть действительным MAC-адресом.',
    'max' => [
        'array' => 'Поле :attribute должно содержать не более :max элементов.',
        'file' => 'Значение :attribute не должно быть больше :max килобайт.',
        'numeric' => 'Поле :attribute не должно быть больше :max.',
        'string' => 'Значение :attribute должно быть не больше :max символов.',
    ],
    'max_digits' => 'Поле :attribute должно содержать не более :max цифр.',
    'mimes' => 'Значение :attribute должно быть файлом типа: :values.',
    'mimetypes' => 'Значение :attribute должно быть файлом типа: :values.',
    'min' => [
        'array' => 'Поле :attribute должно содержать не менее :min элементов.',
        'file' => 'Значение :attribute должно быть не менее :min килобайт.',
        'numeric' => 'Поле :attribute должно быть не менее :min.',
        'string' => 'Значение :attribute должно быть не менее :min символов.',
    ],
    'min_digits' => 'Поле :attribute должно содержать не менее :min цифр.',
    'multiple_of' => 'Поле :attribute должно быть кратким для :value.',
    'not_in' => 'Выбранный :attribute неверен.',
    'not_regex' => 'Формат :attribute неверен.',
    'numeric' => 'Поле :attribute должно быть числом.',
    'password' => [
        'letters' => ':attribute должно содержать хотя бы одну букву.',
        'mixed' => ':attribute должен содержать хотя бы одну заглавную букву и одну строчную букву.',
        'numbers' => ':attribute должен содержать по крайней мере одно число.',
        'symbols' => ':attribute должен содержать хотя бы один символ.',
        'uncompromised' => 'Данный :attribute появился при утечке данных. Пожалуйста, выберите другой :attribute.',
    ],
    'present' => 'Поле :attribute должно быть заполнено.',
    'prohibited' => 'Поле :attribute запрещено.',
    'prohibited_if' => 'Поле :attribute запрещено если :other равно :value.',
    'prohibited_unless' => 'Поле :attribute запрещено, если :other не находится в :values.',
    'prohibits' => 'Поле :attribute запрещает :other присутствуть.',
    'regex' => 'Формат :attribute неверен.',
    'required' => 'Поле :attribute является обязательным.',
    'required_array_keys' => 'Поле :attribute должно содержать записи для: :values.',
    'required_if' => 'Поле :attribute является обязательным, если :other равно :value.',
    'required_unless' => 'Поле :attribute является обязательным, если только :other не находится в :values.',
    'required_with' => 'Поле :attribute обязательно для заполнения, когда :values присутствует.',
    'required_with_all' => 'Поле :attribute является обязательным, когда :values присутствуют.',
    'required_without' => 'Поле :attribute является обязательным, если :values не указано.',
    'required_without_all' => 'Поле :attribute является обязательным, если ни одно из :values не указано.',
    'same' => ':attribute и :other должны совпадать.',
    'size' => [
        'array' => 'Поле :attribute должно содержать :size элементов.',
        'file' => 'Значение :attribute должно быть :size килобайт.',
        'numeric' => 'Поле :attribute должно быть :size.',
        'string' => 'Поле :attribute должно содержать :size символов.',
    ],
    'starts_with' => ':attribute должен начинаться с одного из следующих значений: :values.',
    'string' => 'Поле :attribute должно быть строкой.',
    'timezone' => 'Значение :attribute должно быть допустимым часовым поясом.',
    'unique' => ':attribute уже занято.',
    'uploaded' => 'Не удалось загрузить :attribute.',
    'url' => ':attribute должен быть допустимым URL.',
    'uuid' => 'Значение :attribute должно быть корректным UUID.',

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
            'rule-name' => 'пользовательское сообщение',
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
