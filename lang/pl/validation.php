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

    'accepted' => ':attribute musi zostać zaakceptowany.',
    'accepted_if' => ':attribute musi być zaakceptowany, gdy :other jest :value.',
    'active_url' => ':attribute nie jest prawidłowym adresem URL.',
    'after' => ':attribute musi być datą po :date.',
    'after_or_equal' => ':attribute musi być datą po lub równą :date.',
    'alpha' => ':attribute musi zawierać tylko litery.',
    'alpha_dash' => ':attribute musi zawierać tylko litery, cyfry, myślniki i podkreślenia.',
    'alpha_num' => ':attribute musi zawierać tylko litery i cyfry.',
    'array' => ':attribute musi być tablicą.',
    'before' => ':attribute musi być datą przed :date.',
    'before_or_equal' => ':attribute musi być datą przed lub równą :date.',
    'between' => [
        'array' => ':attribute musi mieć od :min do :max elementów.',
        'file' => ':attribute musi zawierać się między :min a :max kilobajtów.',
        'numeric' => ':attribute musi być pomiędzy :min a :max.',
        'string' => ':attribute musi mieć od :min do :max znaków.',
    ],
    'boolean' => 'Pole :attribute musi być prawdziwe lub fałszywe.',
    'confirmed' => 'Potwierdzenie :attribute nie pasuje.',
    'current_password' => 'Hasło jest nieprawidłowe.',
    'date' => ':attribute nie jest prawidłową datą.',
    'date_equals' => ':attribute musi być datą równą :date.',
    'date_format' => ':attribute nie pasuje do formatu :format.',
    'declined' => ':attribute musi zostać odrzucony.',
    'declined_if' => ':attribute musi zostać odrzucony, gdy :other jest :value.',
    'different' => ':attribute i :other muszą być różne.',
    'digits' => ':attribute musi mieć :digits cyfr.',
    'digits_between' => ':attribute musi zawierać się między :min a :max cyfr.',
    'dimensions' => ':attribute ma nieprawidłowe wymiary obrazu.',
    'distinct' => ':attribute ma zduplikowaną wartość.',
    'doesnt_end_with' => ':attribute nie może kończyć się jednym z następujących: :values.',
    'doesnt_start_with' => ':attribute nie może zaczynać się od jednego z następujących elementów: :values.',
    'email' => ':attribute musi być prawidłowym adresem e-mail.',
    'ends_with' => ':attribute musi kończyć się jednym z następujących: :values.',
    'enum' => 'Wybrany :attribute jest nieprawidłowy.',
    'exists' => 'Wybrany :attribute jest nieprawidłowy.',
    'file' => ':attribute musi być plikiem.',
    'filled' => 'Pole :attribute musi mieć wartość.',
    'gt' => [
        'array' => ':attribute musi mieć więcej niż :value elementów.',
        'file' => ':attribute musi być większy niż :value kilobajtów.',
        'numeric' => ':attribute musi być większy niż :value.',
        'string' => ':attribute musi być większy niż :value znaków.',
    ],
    'gte' => [
        'array' => ':attribute musi mieć :value lub więcej.',
        'file' => ':attribute musi być większy lub równy :value kilobajtów.',
        'numeric' => ':attribute musi być większy lub równy :value.',
        'string' => ':attribute musi być większy lub równy :value znaków.',
    ],
    'image' => ':attribute musi być zdjęciem.',
    'in' => 'Wybrany :attribute jest nieprawidłowy.',
    'in_array' => 'Pole :attribute nie istnieje w :other.',
    'integer' => ':attribute musi być liczbą całkowitą.',
    'ip' => ':attribute musi być prawidłowym adresem IP.',
    'ipv4' => ':attribute musi być prawidłowym adresem IPv4.',
    'ipv6' => ':attribute musi być prawidłowym adresem IPv6.',
    'json' => ':attribute musi być prawidłowym ciągiem JSON.',
    'lt' => [
        'array' => ':attribute musi mieć mniej niż :value elementów.',
        'file' => ':attribute musi być mniejszy niż :value kilobajtów.',
        'numeric' => ':attribute musi być mniejszy niż :value.',
        'string' => ':attribute musi być mniejszy niż :value znaków.',
    ],
    'lte' => [
        'array' => ':attribute nie może mieć więcej niż :value elementów.',
        'file' => ':attribute musi być mniejszy lub równy :value kilobajtów.',
        'numeric' => ':attribute musi być mniejszy lub równy :value.',
        'string' => ':attribute musi być mniejszy lub równy :value znaków.',
    ],
    'mac_address' => ':attribute musi być prawidłowym adresem MAC.',
    'max' => [
        'array' => ':attribute nie może mieć więcej niż :max elementów.',
        'file' => ':attribute nie może być większy niż :max kilobajtów.',
        'numeric' => ':attribute nie może być większy niż :max.',
        'string' => ':attribute nie może być większy niż :max znaków.',
    ],
    'max_digits' => ':attribute nie może mieć więcej niż :max cyfr.',
    'mimes' => ':attribute musi być plikiem typu: :values.',
    'mimetypes' => ':attribute musi być plikiem typu: :values.',
    'min' => [
        'array' => ':attribute musi mieć co najmniej :min elementów.',
        'file' => ':attribute musi mieć co najmniej :min kilobajtów.',
        'numeric' => ':attribute musi być co najmniej :min.',
        'string' => ':attribute musi mieć co najmniej :min znaków.',
    ],
    'min_digits' => ':attribute musi mieć co najmniej :min cyfr.',
    'multiple_of' => ':attribute musi być wielokrotnością :value.',
    'not_in' => 'Wybrany :attribute jest nieprawidłowy.',
    'not_regex' => 'Format :attribute jest nieprawidłowy.',
    'numeric' => ':attribute musi być liczbą.',
    'password' => [
        'letters' => ':attribute musi zawierać co najmniej jedną literę.',
        'mixed' => ':attribute musi zawierać co najmniej jedną wielką literę i jedną małą literę.',
        'numbers' => ':attribute musi zawierać co najmniej jedną liczbę.',
        'symbols' => ':attribute musi zawierać co najmniej jeden symbol.',
        'uncompromised' => 'Podany :attribute pojawił się w wycieku danych. Proszę wybrać inny :attribute.',
    ],
    'present' => 'Pole :attribute musi być obecne.',
    'prohibited' => 'Pole :attribute jest zabronione.',
    'prohibited_if' => 'Pole :attribute jest zabronione, gdy :other to :value.',
    'prohibited_unless' => 'Pole :attribute jest zabronione, chyba że :other znajduje się w :values.',
    'prohibits' => 'Pole :attribute zabrania :other obecności .',
    'regex' => 'Format :attribute jest nieprawidłowy.',
    'required' => 'Pole :attribute jest wymagane.',
    'required_array_keys' => 'Pole :attribute musi zawierać wpisy dla: :values.',
    'required_if' => 'Pole :attribute jest wymagane, gdy :other jest :value.',
    'required_unless' => 'Pole :attribute jest wymagane, chyba że :other jest w :values.',
    'required_with' => 'Pole :attribute jest wymagane, gdy :values jest obecne.',
    'required_with_all' => 'Pole :attribute jest wymagane, gdy :values są obecne.',
    'required_without' => 'Pole :attribute jest wymagane, gdy :values nie jest obecny.',
    'required_without_all' => 'Pole :attribute jest wymagane, gdy żaden z :values nie jest obecny.',
    'same' => ':attribute i :other muszą się zgadzać.',
    'size' => [
        'array' => ':attribute musi zawierać :size elementów.',
        'file' => ':attribute musi mieć :size kilobajtów.',
        'numeric' => ':attribute musi być :size.',
        'string' => ':attribute musi mieć :size znaków.',
    ],
    'starts_with' => ':attribute musi zaczynać się od jednego z następujących elementów: :values.',
    'string' => ':attribute musi być ciągiem.',
    'timezone' => ':attribute musi być poprawną strefą czasową.',
    'unique' => ':attribute jest już zajęty.',
    'uploaded' => ':attribute nie udało się przesłać.',
    'url' => ':attribute musi być prawidłowym adresem URL.',
    'uuid' => ':attribute musi być prawidłowym UUID.',

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
            'rule-name' => 'niestandardowa wiadomość',
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
