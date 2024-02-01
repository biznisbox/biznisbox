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

    'accepted' => 'A(z) :attribute el kell fogadni.',
    'accepted_if' => 'A(z) :attribute el kell fogadni, ha a(z) :other értéke :value.',
    'active_url' => 'A(z) :attribute érvénytelen URL.',
    'after' => 'A(z) :attribute dátumnak kell lennie a(z) :date után.',
    'after_or_equal' => 'A(z) :attribute dátumnak kell lennie a(z) :date után vagy azzal egyenlő.',
    'alpha' => 'A(z) :attribute csak betűket tartalmazhat.',
    'alpha_dash' => 'A(z) :attribute csak betűket, számokat, kötőjeleket és aláhúzásjeleket tartalmazhat.',
    'alpha_num' => 'A(z) :attribute csak betűket és számokat tartalmazhat.',
    'array' => 'A(z) :attribute tömbnek kell lennie.',
    'before' => 'A(z) :attribute dátumnak kell lennie a(z) :date előtt.',
    'before_or_equal' => 'A(z) :attribute dátumnak kell lennie a(z) :date előtt vagy azzal egyenlőnek.',
    'between' => [
        'array' => 'A(z) :attribute-nak :min és :max elem között kell lennie.',
        'file' => 'A(z) :attribute-nak :min és :max kilobájt között kell lennie.',
        'numeric' => 'A(z) :attribute-nak :min és :max között kell lennie.',
        'string' => 'A(z) :attribute-nak :min és :max karakter között kell lennie.',
    ],
    'boolean' => 'A(z) :attribute mezőnek igaznak vagy hamisnak kell lennie.',
    'confirmed' => 'A(z) :attribute megerősítés nem egyezik.',
    'current_password' => 'Helytelen jelszó.',
    'date' => 'A(z) :attribute érvénytelen dátum.',
    'date_equals' => 'A(z) :attribute dátumnak kell lennie a(z) :date-val egyenlőnek.',
    'date_format' => 'A(z) :attribute nem felel meg a(z) :format formátumnak.',
    'declined' => 'A(z) :attribute el kell utasítani.',
    'declined_if' => 'A(z) :attribute el kell utasítani, ha a(z) :other értéke :value.',
    'different' => 'A(z) :attribute és a(z) :other különbözőek kell legyenek.',
    'digits' => 'A(z) :attribute mezőnek :digits számjegyből kell állnia.',
    'digits_between' => 'A(z) :attribute mezőnek :min és :max számjegy között kell lennie.',
    'dimensions' => 'A(z) :attribute mező képmérete érvénytelen.',
    'distinct' => 'A(z) :attribute mező értéke megegyezik egy másik mező értékével.',
    'doesnt_end_with' => 'A(z) :attribute mező nem végződhet az alábbiak egyikével: :values.',
    'doesnt_start_with' => 'A(z) :attribute mező nem kezdődhet az alábbiak egyikével: :values.',
    'email' => 'A(z) :attribute mezőnek érvényes email címnek kell lennie.',
    'ends_with' => 'A(z) :attribute mezőnek az alábbiakkal kell végződnie: :values.',
    'enum' => 'A kiválasztott :attribute érvénytelen.',
    'exists' => 'A kiválasztott :attribute érvénytelen.',
    'file' => 'A(z) :attribute mezőnek fájlnak kell lennie.',
    'filled' => 'A(z) :attribute mező értékének meg kell lennie.',
    'gt' => [
        'array' => 'A(z) :attribute mezőnek :value-nál több eleme kell legyen.',
        'file' => 'A(z) :attribute mezőnek :value kilobájtnál nagyobbnak kell lennie.',
        'numeric' => 'A(z) :attribute mezőnek :value-nál nagyobbnak kell lennie.',
        'string' => 'A(z) :attribute mezőnek :value karakternél hosszabbnak kell lennie.',
    ],
    'gte' => [
        'array' => 'A(z) :attribute mezőnek :value elemmel vagy többel kell rendelkeznie.',
        'file' => 'A(z) :attribute mezőnek legalább :value kilobájtnak kell lennie.',
        'numeric' => 'A(z) :attribute mezőnek legalább :value-nak kell lennie.',
        'string' => 'A(z) :attribute mezőnek legalább :value karakternek kell lennie.',
    ],
    'image' => 'A(z) :attribute mezőnek képnek kell lennie.',
    'in' => 'A kiválasztott :attribute érvénytelen.',
    'in_array' => 'A(z) :attribute mező nem létezik a(z) :other mezőben.',
    'integer' => 'A(z) :attribute mezőnek egész számnak kell lennie.',
    'ip' => 'A(z) :attribute érvényes IP címnek kell lennie.',
    'ipv4' => 'A(z) :attribute érvényes IPv4 címnek kell lennie.',
    'ipv6' => 'A(z) :attribute érvényes IPv6 címnek kell lennie.',
    'json' => 'A(z) :attribute érvényes JSON karakterláncnak kell lennie.',
    'lt' => [
        'array' => 'A(z) :attribute kevesebb, mint :value elemet kell tartalmazzon.',
        'file' => 'A(z) :attribute kevesebb, mint :value kilobájt kell legyen.',
        'numeric' => 'A(z) :attribute kevesebb, mint :value kell legyen.',
        'string' => 'A(z) :attribute kevesebb, mint :value karakter kell legyen.',
    ],
    'lte' => [
        'array' => 'A(z) :attribute nem tartalmazhat több, mint :value elemet.',
        'file' => 'A(z) :attribute kevesebb vagy egyenlő, mint :value kilobájt kell legyen.',
        'numeric' => 'A(z) :attribute kevesebb vagy egyenlő, mint :value kell legyen.',
        'string' => 'A(z) :attribute kevesebb vagy egyenlő, mint :value karakter kell legyen.',
    ],
    'mac_address' => 'A(z) :attribute érvényes MAC címnek kell lennie.',
    'max' => [
        'array' => 'A(z) :attribute nem tartalmazhat több, mint :max elemet.',
        'file' => 'A(z) :attribute nem lehet nagyobb, mint :max kilobájt.',
        'numeric' => 'A(z) :attribute nem lehet nagyobb, mint :max.',
        'string' => 'A(z) :attribute nem lehet nagyobb, mint :max karakter.',
    ],
    'max_digits' => 'A(z) :attribute nem lehet több, mint :max számjegy.',
    'mimes' => 'A(z) :attribute :values fájltípusnak kell lennie.',
    'mimetypes' => 'A(z) :attribute :values fájltípusnak kell lennie.',
    'min' => [
        'array' => 'A(z) :attribute legalább :min elemet kell tartalmazzon.',
        'file' => 'A(z) :attribute legalább :min kilobájt kell legyen.',
        'numeric' => 'A(z) :attribute legalább :min kell legyen.',
        'string' => 'A(z) :attribute legalább :min karakter hosszú kell legyen.',
    ],
    'min_digits' => 'A(z) :attribute legalább :min számjegyű kell legyen.',
    'multiple_of' => 'A(z) :attribute :value többszöröse kell legyen.',
    'not_in' => 'A kiválasztott :attribute érvénytelen.',
    'not_regex' => 'A(z) :attribute formátuma érvénytelen.',
    'numeric' => 'A(z) :attribute számnak kell lennie.',
    'password' => [
        'letters' => 'A(z) :attribute tartalmaznia kell legalább egy betűt.',
        'mixed' => 'A(z) :attribute tartalmaznia kell legalább egy nagy- és egy kisbetűt.',
        'numbers' => 'A(z) :attribute tartalmaznia kell legalább egy számot.',
        'symbols' => 'A(z) :attribute tartalmaznia kell legalább egy szimbólumot.',
        'uncompromised' => 'A megadott :attribute előfordult adatlekérésben. Kérlek, válassz másik :attribute-t.',
    ],
    'present' => 'A mező :attribute jelen kell legyen.',
    'prohibited' => 'A mező :attribute tiltott.',
    'prohibited_if' => 'A mező :attribute tiltott, ha :other :value.',
    'prohibited_unless' => 'A mező :attribute tiltott, hacsak :other :values között nincs.',
    'prohibits' => 'A mező :attribute megakadályozza, hogy :other jelen legyen.',
    'regex' => 'A(z) :attribute formátuma érvénytelen.',
    'required' => 'A mező :attribute kötelező.',
    'required_array_keys' => 'A mező :attribute tartalmaznia kell az alábbiakat: :values.',
    'required_if' => 'A mező :attribute kötelező, ha :other :value.',
    'required_unless' => 'A mező :attribute kötelező, hacsak :other :values között nincs.',
    'required_with' => 'A mező :attribute kötelező, ha :values jelen van.',
    'required_with_all' => 'A mező :attribute kötelező, ha :values jelen vannak.',
    'required_without' => 'A(z) :attribute mező kitöltése kötelező, ha a(z) :values nem áll rendelkezésre.',
    'required_without_all' => 'A(z) :attribute mező kitöltése kötelező, ha a(z) :values egyik sem áll rendelkezésre.',
    'same' => 'A(z) :attribute és a(z) :other mezőnek egyeznie kell.',
    'size' => [
        'array' => 'A(z) :attribute mező :size elemet kell tartalmazzon.',
        'file' => 'A(z) :attribute mérete :size kilobájt kell legyen.',
        'numeric' => 'A(z) :attribute mérete :size kell legyen.',
        'string' => 'A(z) :attribute :size karakter kell, hogy legyen.',
    ],
    'starts_with' => 'A(z) :attribute egyike kell legyen a következőknek: :values.',
    'string' => 'A(z) :attribute szövegnek kell lennie.',
    'timezone' => 'A(z) :attribute érvényes időzóna kell legyen.',
    'unique' => 'A(z) :attribute már foglalt.',
    'uploaded' => 'A(z) :attribute feltöltése sikertelen.',
    'url' => 'A(z) :attribute érvényes URL kell legyen.',
    'uuid' => 'A(z) :attribute érvényes UUID kell legyen.',

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
            'rule-name' => 'egyéni-üzenet',
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
