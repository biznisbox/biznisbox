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

    'accepted' => 'Bạn phải chấp nhận :attribute.',
    'accepted_if' => 'Bạn phải chấp nhận :attribute khi :other là :value.',
    'active_url' => ':attribute không phải là một URL hợp lệ.',
    'after' => ':attribute phải là một ngày sau :date.',
    'after_or_equal' => ':attribute phải là một ngày sau hoặc bằng :date.',
    'alpha' => ':attribute chỉ được chứa chữ cái.',
    'alpha_dash' => ':attribute chỉ được chứa chữ cái, số, dấu gạch ngang và gạch dưới.',
    'alpha_num' => ':attribute chỉ được chứa chữ cái và số.',
    'array' => ':attribute phải là một mảng.',
    'before' => ':attribute phải là một ngày trước :date.',
    'before_or_equal' => ':attribute phải là một ngày trước hoặc bằng :date.',
    'between' => [
        'array' => ':attribute phải có từ :min đến :max mục.',
        'file' => ':attribute phải có từ :min đến :max kilobyte.',
        'numeric' => ':attribute phải có từ :min đến :max.',
        'string' => ':attribute phải có từ :min đến :max ký tự.',
    ],
    'boolean' => 'Trường :attribute phải là true hoặc false.',
    'confirmed' => 'Xác nhận :attribute không khớp.',
    'current_password' => 'Mật khẩu không đúng.',
    'date' => ':attribute không phải là một ngày hợp lệ.',
    'date_equals' => ':attribute phải là một ngày bằng :date.',
    'date_format' => ':attribute không khớp với định dạng :format.',
    'declined' => 'Bạn phải từ chối :attribute.',
    'declined_if' => 'Bạn phải từ chối :attribute khi :other là :value.',
    'different' => ':attribute và :other phải khác nhau.',
    'digits' => 'Trường :attribute phải có :digits chữ số.',
    'digits_between' => 'Trường :attribute phải có giá trị từ :min đến :max chữ số.',
    'dimensions' => 'Trường :attribute có kích thước hình ảnh không hợp lệ.',
    'distinct' => 'Trường :attribute có giá trị trùng lặp.',
    'doesnt_end_with' => 'Trường :attribute không được kết thúc bằng một trong các giá trị sau: :values.',
    'doesnt_start_with' => 'Trường :attribute không được bắt đầu bằng một trong các giá trị sau: :values.',
    'email' => 'Trường :attribute phải là địa chỉ email hợp lệ.',
    'ends_with' => 'Trường :attribute phải kết thúc bằng một trong các giá trị sau: :values.',
    'enum' => 'Trường :attribute được chọn không hợp lệ.',
    'exists' => 'Trường :attribute được chọn không hợp lệ.',
    'file' => 'Trường :attribute phải là một tệp.',
    'filled' => 'Trường :attribute phải có giá trị.',
    'gt' => [
        'array' => 'Trường :attribute phải có nhiều hơn :value mục.',
        'file' => 'Trường :attribute phải lớn hơn :value kilobyte.',
        'numeric' => 'Trường :attribute phải lớn hơn :value.',
        'string' => 'Trường :attribute phải lớn hơn :value ký tự.',
    ],
    'gte' => [
        'array' => 'Trường :attribute phải có :value mục hoặc nhiều hơn.',
        'file' => 'Trường :attribute phải lớn hơn hoặc bằng :value kilobyte.',
        'numeric' => 'Trường :attribute phải lớn hơn hoặc bằng :value.',
        'string' => 'Trường :attribute phải lớn hơn hoặc bằng :value ký tự.',
    ],
    'image' => 'Trường :attribute phải là hình ảnh.',
    'in' => 'Trường :attribute được chọn không hợp lệ.',
    'in_array' => 'Trường :attribute không tồn tại trong :other.',
    'integer' => 'Trường :attribute phải là một số nguyên.',
    'ip' => 'Thuộc tính :attribute phải là địa chỉ IP hợp lệ.',
    'ipv4' => 'Thuộc tính :attribute phải là địa chỉ IPv4 hợp lệ.',
    'ipv6' => 'Thuộc tính :attribute phải là địa chỉ IPv6 hợp lệ.',
    'json' => 'Thuộc tính :attribute phải là chuỗi JSON hợp lệ.',
    'lt' => [
        'array' => 'Thuộc tính :attribute phải có ít hơn :value mục.',
        'file' => 'Thuộc tính :attribute phải nhỏ hơn :value kilobytes.',
        'numeric' => 'Thuộc tính :attribute phải nhỏ hơn :value.',
        'string' => 'Thuộc tính :attribute phải nhỏ hơn :value ký tự.',
    ],
    'lte' => [
        'array' => 'Thuộc tính :attribute không được có nhiều hơn :value mục.',
        'file' => 'Thuộc tính :attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'numeric' => 'Thuộc tính :attribute phải nhỏ hơn hoặc bằng :value.',
        'string' => 'Thuộc tính :attribute phải nhỏ hơn hoặc bằng :value ký tự.',
    ],
    'mac_address' => 'Thuộc tính :attribute phải là địa chỉ MAC hợp lệ.',
    'max' => [
        'array' => 'Thuộc tính :attribute không được có nhiều hơn :max mục.',
        'file' => 'Thuộc tính :attribute không được lớn hơn :max kilobytes.',
        'numeric' => 'Thuộc tính :attribute không được lớn hơn :max.',
        'string' => 'Thuộc tính :attribute không được lớn hơn :max ký tự.',
    ],
    'max_digits' => 'Thuộc tính :attribute không được có nhiều hơn :max chữ số.',
    'mimes' => 'Thuộc tính :attribute phải là tệp có loại: :values.',
    'mimetypes' => 'Thuộc tính :attribute phải là tệp có loại: :values.',
    'min' => [
        'array' => 'Thuộc tính :attribute phải có ít nhất :min mục.',
        'file' => 'Thuộc tính :attribute phải có ít nhất :min kilobytes.',
        'numeric' => 'Thuộc tính :attribute phải có ít nhất :min.',
        'string' => 'Thuộc tính :attribute phải có ít nhất :min ký tự.',
    ],
    'min_digits' => 'Thuộc tính :attribute phải có ít nhất :min chữ số.',
    'multiple_of' => 'Thuộc tính :attribute phải là bội số của :value.',
    'not_in' => 'Giá trị :attribute đã chọn không hợp lệ.',
    'not_regex' => 'Định dạng :attribute không hợp lệ.',
    'numeric' => 'Thuộc tính :attribute phải là một số.',
    'password' => [
        'letters' => 'Thuộc tính :attribute phải chứa ít nhất một chữ cái.',
        'mixed' => 'Thuộc tính :attribute phải chứa ít nhất một chữ cái viết hoa và một chữ cái viết thường.',
        'numbers' => 'Thuộc tính :attribute phải chứa ít nhất một số.',
        'symbols' => 'Thuộc tính :attribute phải chứa ít nhất một ký tự đặc biệt.',
        'uncompromised' => 'Thuộc tính :attribute đã cho đã xuất hiện trong một rò rỉ dữ liệu. Vui lòng chọn một :attribute khác.',
    ],
    'present' => 'Trường :attribute phải có mặt.',
    'prohibited' => 'Trường :attribute bị cấm.',
    'prohibited_if' => 'Trường :attribute bị cấm khi :other là :value.',
    'prohibited_unless' => 'Trường :attribute bị cấm trừ khi :other nằm trong :values.',
    'prohibits' => 'Trường :attribute cấm :other xuất hiện.',
    'regex' => 'Định dạng :attribute không hợp lệ.',
    'required' => 'Trường :attribute là bắt buộc.',
    'required_array_keys' => 'Trường :attribute phải chứa các mục cho: :values.',
    'required_if' => 'Trường :attribute là bắt buộc khi :other là :value.',
    'required_unless' => 'Trường :attribute là bắt buộc trừ khi :other nằm trong :values.',
    'required_with' => 'Trường :attribute là bắt buộc khi :values có mặt.',
    'required_with_all' => 'Trường :attribute là bắt buộc khi :values có mặt.',
    'required_without' => 'Trường :attribute là bắt buộc khi :values không có mặt.',
    'required_without_all' => 'Trường :attribute là bắt buộc khi không có một trong các giá trị :values.',
    'same' => 'Trường :attribute và :other phải khớp nhau.',
    'size' => [
        'array' => 'Trường :attribute phải chứa :size mục.',
        'file' => 'Trường :attribute phải là :size kilobyte.',
        'numeric' => 'Trường :attribute phải là :size.',
        'string' => 'Thuộc tính :attribute phải có :size ký tự.',
    ],
    'starts_with' => 'Thuộc tính :attribute phải bắt đầu bằng một trong các giá trị sau: :values.',
    'string' => 'Thuộc tính :attribute phải là một chuỗi.',
    'timezone' => 'Thuộc tính :attribute phải là múi giờ hợp lệ.',
    'unique' => 'Thuộc tính :attribute đã được sử dụng.',
    'uploaded' => 'Thuộc tính :attribute tải lên không thành công.',
    'url' => 'Thuộc tính :attribute phải là một URL hợp lệ.',
    'uuid' => 'Thuộc tính :attribute phải là một UUID hợp lệ.',

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
            'rule-name' => 'thông điệp-tùy chỉnh',
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
