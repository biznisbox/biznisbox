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

    'accepted' => '필드 :attribute은(는) 수락되어야 합니다.',
    'accepted_if' => '필드 :attribute은(는) :other이(가) :value일 때만 수락되어야 합니다.',
    'active_url' => '필드 :attribute은(는) 유효한 URL이 아닙니다.',
    'after' => '필드 :attribute은(는) :date 이후의 날짜여야 합니다.',
    'after_or_equal' => '필드 :attribute은(는) :date 이후 또는 같은 날짜여야 합니다.',
    'alpha' => '필드 :attribute은(는) 문자만 포함해야 합니다.',
    'alpha_dash' => '필드 :attribute은(는) 문자, 숫자, 대시(-) 및 언더스코어(_)만 포함해야 합니다.',
    'alpha_num' => '필드 :attribute은(는) 문자와 숫자만 포함해야 합니다.',
    'array' => '필드 :attribute은(는) 배열이어야 합니다.',
    'before' => '필드 :attribute은(는) :date 이전의 날짜여야 합니다.',
    'before_or_equal' => '필드 :attribute은(는) :date 이전 또는 같은 날짜여야 합니다.',
    'between' => [
        'array' => '필드 :attribute은(는) :min에서 :max까지의 항목을 가져야 합니다.',
        'file' => '필드 :attribute은(는) :min에서 :max 킬로바이트 사이여야 합니다.',
        'numeric' => '필드 :attribute은(는) :min에서 :max 사이여야 합니다.',
        'string' => '필드 :attribute은(는) :min에서 :max 글자 사이여야 합니다.',
    ],
    'boolean' => '필드 :attribute은(는) true 또는 false이어야 합니다.',
    'confirmed' => '필드 :attribute의 확인이 일치하지 않습니다.',
    'current_password' => '비밀번호가 잘못되었습니다.',
    'date' => '필드 :attribute은(는) 유효한 날짜가 아닙니다.',
    'date_equals' => '필드 :attribute은(는) :date와 같은 날짜여야 합니다.',
    'date_format' => '필드 :attribute은(는) :format 형식과 일치하지 않습니다.',
    'declined' => '필드 :attribute은(는) 거절되어야 합니다.',
    'declined_if' => '필드 :attribute은(는) :other이(가) :value일 때만 거절되어야 합니다.',
    'different' => '필드 :attribute과(와) :other은(는) 서로 달라야 합니다.',
    'digits' => '속성은 :digits 자리 숫자여야 합니다.',
    'digits_between' => '속성은 :min에서 :max 자리 사이여야 합니다.',
    'dimensions' => '속성의 이미지 크기가 올바르지 않습니다.',
    'distinct' => '속성 필드에 중복된 값이 있습니다.',
    'doesnt_end_with' => '속성은 다음 중 하나로 끝나지 않아야 합니다: :values.',
    'doesnt_start_with' => '속성은 다음 중 하나로 시작하지 않아야 합니다: :values.',
    'email' => '유효한 이메일 주소여야 합니다.',
    'ends_with' => '속성은 다음 중 하나로 끝나야 합니다: :values.',
    'enum' => '선택한 :attribute은(는) 유효하지 않습니다.',
    'exists' => '선택한 :attribute은(는) 유효하지 않습니다.',
    'file' => '파일이어야 합니다.',
    'filled' => '필드에 값이 있어야 합니다.',
    'gt' => [
        'array' => '속성은 :value개 이상이어야 합니다.',
        'file' => '속성은 :value킬로바이트보다 커야 합니다.',
        'numeric' => '속성은 :value보다 커야 합니다.',
        'string' => '속성은 :value자보다 커야 합니다.',
    ],
    'gte' => [
        'array' => '속성은 :value개 이상이어야 합니다.',
        'file' => '속성은 :value킬로바이트 이상이어야 합니다.',
        'numeric' => '속성은 :value 이상이어야 합니다.',
        'string' => '속성은 :value자 이상이어야 합니다.',
    ],
    'image' => '이미지여야 합니다.',
    'in' => '선택한 :attribute은(는) 유효하지 않습니다.',
    'in_array' => '필드는 :other에 존재하지 않습니다.',
    'integer' => '정수여야 합니다.',
    'ip' => '속성은 유효한 IP 주소여야 합니다.',
    'ipv4' => '속성은 유효한 IPv4 주소여야 합니다.',
    'ipv6' => '속성은 유효한 IPv6 주소여야 합니다.',
    'json' => '속성은 유효한 JSON 문자열이어야 합니다.',
    'lt' => [
        'array' => '속성은 :value개보다 적어야 합니다.',
        'file' => '속성은 :value킬로바이트보다 작아야 합니다.',
        'numeric' => '속성은 :value보다 작아야 합니다.',
        'string' => '속성은 :value자보다 작아야 합니다.',
    ],
    'lte' => [
        'array' => '속성은 :value개보다 많을 수 없습니다.',
        'file' => '속성은 :value킬로바이트보다 작거나 같아야 합니다.',
        'numeric' => '속성은 :value보다 작거나 같아야 합니다.',
        'string' => '속성은 :value자보다 작거나 같아야 합니다.',
    ],
    'mac_address' => '속성은 유효한 MAC 주소여야 합니다.',
    'max' => [
        'array' => '속성은 :max개보다 많을 수 없습니다.',
        'file' => '속성은 :max킬로바이트보다 크지 않아야 합니다.',
        'numeric' => '속성은 :max보다 크지 않아야 합니다.',
        'string' => '속성은 :max자보다 크지 않아야 합니다.',
    ],
    'max_digits' => '속성은 :max자리보다 많은 자리수를 가질 수 없습니다.',
    'mimes' => '속성은 다음 유형의 파일이어야 합니다: :values.',
    'mimetypes' => '속성은 다음 유형의 파일이어야 합니다: :values.',
    'min' => [
        'array' => '속성은 적어도 :min개를 가져야 합니다.',
        'file' => '속성은 적어도 :min킬로바이트여야 합니다.',
        'numeric' => '속성은 적어도 :min이어야 합니다.',
        'string' => '속성은 최소한 :min 글자여야 합니다.',
    ],
    'min_digits' => '속성은 최소한 :min 자리의 숫자여야 합니다.',
    'multiple_of' => '속성은 :value의 배수여야 합니다.',
    'not_in' => '선택한 :attribute은(는) 잘못되었습니다.',
    'not_regex' => '속성 형식이 잘못되었습니다.',
    'numeric' => '속성은 숫자여야 합니다.',
    'password' => [
        'letters' => '속성은 적어도 하나의 문자를 포함해야 합니다.',
        'mixed' => '속성은 적어도 하나의 대문자와 소문자를 포함해야 합니다.',
        'numbers' => '속성은 적어도 하나의 숫자를 포함해야 합니다.',
        'symbols' => '속성은 적어도 하나의 기호를 포함해야 합니다.',
        'uncompromised' => '주어진 :attribute은(는) 데이터 유출에 나타났습니다. 다른 :attribute을(를) 선택하세요.',
    ],
    'present' => '필드 :attribute은(는) 필수입니다.',
    'prohibited' => '필드 :attribute은(는) 금지되었습니다.',
    'prohibited_if' => '필드 :attribute은(는) :other이(가) :value일 때 금지됩니다.',
    'prohibited_unless' => '필드 :attribute은(는) :other이(가) :values에 속하지 않을 때 금지됩니다.',
    'prohibits' => '필드 :attribute은(는) :other이(가) 존재하지 않도록 금지합니다.',
    'regex' => '속성 형식이 잘못되었습니다.',
    'required' => '필드 :attribute은(는) 필수입니다.',
    'required_array_keys' => '필드 :attribute은(는) :values에 대한 항목이 있어야 합니다.',
    'required_if' => '필드 :attribute은(는) :other이(가) :value일 때 필수입니다.',
    'required_unless' => '필드 :attribute은(는) :other이(가) :values에 속하지 않을 때 필수입니다.',
    'required_with' => '필드 :values이(가) 존재할 때 필드 :attribute은(는) 필수입니다.',
    'required_with_all' => '필드 :values이(가) 존재할 때 필드 :attribute은(는) 필수입니다.',
    'required_without' => '필드 :attribute은(는) :values이(가) 없을 때 필수입니다.',
    'required_without_all' => '필드 :attribute은(는) :values 중 어느 것도 없을 때 필수입니다.',
    'same' => '필드 :attribute과(와) :other은(는) 일치해야 합니다.',
    'size' => [
        'array' => '필드 :attribute은(는) :size개의 항목을 포함해야 합니다.',
        'file' => '필드 :attribute은(는) :size 킬로바이트여야 합니다.',
        'numeric' => '필드 :attribute은(는) :size여야 합니다.',
        'string' => '속성은 :size 글자여야 합니다.',
    ],
    'starts_with' => '속성은 다음 중 하나로 시작해야 합니다: :values.',
    'string' => '속성은 문자열이어야 합니다.',
    'timezone' => '속성은 유효한 시간대여야 합니다.',
    'unique' => '이 속성은 이미 사용 중입니다.',
    'uploaded' => '속성 업로드에 실패했습니다.',
    'url' => '속성은 유효한 URL이어야 합니다.',
    'uuid' => '속성은 유효한 UUID여야 합니다.',

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
            'rule-name' => '사용자 정의 메시지',
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
