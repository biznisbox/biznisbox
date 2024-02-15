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

    'accepted' => ':attribute musí být přijat.',
    'accepted_if' => ':attribute musí být přijat, pokud :other je :value.',
    'active_url' => ':attribute není platná adresa URL.',
    'after' => ':attribute musí být datum po :date.',
    'after_or_equal' => ':attribute musí být datum po nebo rovno :date.',
    'alpha' => ':attribute musí obsahovat pouze písmena.',
    'alpha_dash' => ':attribute musí obsahovat pouze písmena, číslice, pomlčky a podtržítka.',
    'alpha_num' => ':attribute musí obsahovat pouze písmena a čísla.',
    'array' => ':attribute musí být pole.',
    'before' => ':attribute musí být datum před :date.',
    'before_or_equal' => ':attribute musí být datum před nebo rovno :date.',
    'between' => [
        'array' => ':attribute musí mít mezi :min a :max položkami.',
        'file' => ':attribute musí být v rozmezí :min až :max kilobajtů.',
        'numeric' => ':attribute musí být mezi :min a :max.',
        'string' => ':attribute musí být v rozmezí :min a :max znaků.',
    ],
    'boolean' => ':attribute musí být pravda nebo nepravda.',
    'confirmed' => 'Potvrzení :attribute se neshoduje.',
    'current_password' => 'Nesprávné heslo.',
    'date' => ':attribute není platné datum.',
    'date_equals' => ':attribute musí být datum rovnající se :date.',
    'date_format' => ':attribute neodpovídá formátu :format.',
    'declined' => ':attribute musí být zamítnut.',
    'declined_if' => ':attribute musí být odmítnut, pokud :other je :value.',
    'different' => ':attribute a :other se musí lišit.',
    'digits' => ':attribute musí obsahovat :digits číslic.',
    'digits_between' => ':attribute musí být v rozmezí :min a :max číslic.',
    'dimensions' => ':attribute má neplatné rozměry obrázku.',
    'distinct' => 'Pole :attribute má duplicitní hodnotu.',
    'doesnt_end_with' => ':attribute nesmí končit jedním z těchto znaků: :values.',
    'doesnt_start_with' => ':attribute nesmí začínat jedním z následujících :values.',
    'email' => ':attribute musí být platná e-mailová adresa.',
    'ends_with' => ':attribute musí končit jedním z těchto znaků: :values.',
    'enum' => 'Vybraný :attribute je neplatný.',
    'exists' => 'Vybraný :attribute je neplatný.',
    'file' => ':attribute musí být soubor.',
    'filled' => 'Pole :attribute musí mít hodnotu.',
    'gt' => [
        'array' => ':attribute musí obsahovat více než :value položek.',
        'file' => ':attribute musí být větší než :value kilobajtů.',
        'numeric' => ':attribute musí být větší než :value.',
        'string' => ':attribute musí být větší než :value znaků.',
    ],
    'gte' => [
        'array' => ':attribute musí mít :value položky nebo více.',
        'file' => ':attribute musí být větší nebo roven :value kilobajtů.',
        'numeric' => ':attribute musí být větší nebo roven :value.',
        'string' => ':attribute musí být větší nebo roven :value znaků.',
    ],
    'image' => ':attribute musí být obrázek.',
    'in' => 'Vybraný :attribute je neplatný.',
    'in_array' => 'Pole :attribute neexistuje v :other.',
    'integer' => ':attribute musí být celé číslo.',
    'ip' => ':attribute musí být platná IP adresa.',
    'ipv4' => ':attribute musí být platná IPv4 adresa.',
    'ipv6' => ':attribute musí být platná IPv6 adresa.',
    'json' => ':attribute musí být platný řetězec JSON.',
    'lt' => [
        'array' => ':attribute musí mít méně než :value položek.',
        'file' => ':attribute musí být menší než :value kilobajtů.',
        'numeric' => ':attribute musí být menší než :value.',
        'string' => ':attribute musí být menší než :value znaků.',
    ],
    'lte' => [
        'array' => ':attribute nesmí obsahovat více než :value položek.',
        'file' => ':attribute musí být menší nebo roven :value kilobajtů.',
        'numeric' => ':attribute musí být menší nebo roven :value.',
        'string' => ':attribute musí být menší nebo roven :value znaků.',
    ],
    'mac_address' => ':attribute musí být platná MAC adresa.',
    'max' => [
        'array' => ':attribute nesmí obsahovat více než :max položek.',
        'file' => ':attribute nesmí být větší než :max kilobajtů.',
        'numeric' => ':attribute nesmí být větší než :max.',
        'string' => ':attribute nesmí být větší než :max znaků.',
    ],
    'max_digits' => ':attribute nesmí obsahovat více než :max číslic.',
    'mimes' => ':attribute musí být soubor typu: :values.',
    'mimetypes' => ':attribute musí být soubor typu: :values.',
    'min' => [
        'array' => ':attribute musí obsahovat alespoň :min položek.',
        'file' => ':attribute musí mít alespoň :min kilobajtů.',
        'numeric' => ':attribute musí být alespoň :min.',
        'string' => ':attribute musí mít alespoň :min znaků.',
    ],
    'min_digits' => ':attribute musí mít alespoň :min číslic.',
    'multiple_of' => ':attribute musí být násobek :value.',
    'not_in' => 'Vybraný :attribute je neplatný.',
    'not_regex' => 'Formát :attribute je neplatný.',
    'numeric' => ':attribute musí být číslo.',
    'password' => [
        'letters' => ':attribute musí obsahovat alespoň jedno písmeno.',
        'mixed' => ':attribute musí obsahovat alespoň jedno velké písmeno a jedno malé písmeno.',
        'numbers' => ':attribute musí obsahovat alespoň jedno číslo.',
        'symbols' => ':attribute musí obsahovat alespoň jeden symbol.',
        'uncompromised' => 'Uvedený :attribute se objevil v úniku dat. Zvolte prosím jiný :attribute atribut.',
    ],
    'present' => ':attribute musí být vyplněno.',
    'prohibited' => 'Pole :attribute je zakázáno.',
    'prohibited_if' => ':attribute je zakázáno pokud :other je :value.',
    'prohibited_unless' => ':attribute je zakázáno pokud :other není v :values.',
    'prohibits' => 'Pole :attribute zakazuje :other být přítomno.',
    'regex' => 'Formát :attribute je neplatný.',
    'required' => 'Pole :attribute je povinné.',
    'required_array_keys' => ':attribute musí obsahovat záznamy pro: :values.',
    'required_if' => ':attribute je vyžadováno pokud :other je :value.',
    'required_unless' => ':attribute je vyžadováno pokud :other není v :values.',
    'required_with' => 'Pole :attribute je vyžadováno, pokud je zvoleno :values.',
    'required_with_all' => 'Pole :attribute je vyžadováno, pokud je k dispozici :values.',
    'required_without' => 'Pole :attribute je vyžadováno, pokud :values není k dispozici.',
    'required_without_all' => 'Pole :attribute je vyžadováno, pokud není k dispozici žádná z :values.',
    'same' => ':attribute a :other se musí shodovat.',
    'size' => [
        'array' => ':attribute musí obsahovat :size položek.',
        'file' => ':attribute musí mít :size kilobajtů.',
        'numeric' => ':attribute musí být :size.',
        'string' => ':attribute musí mít :size znaků.',
    ],
    'starts_with' => ':attribute musí začínat jedním z těchto atributů: :values.',
    'string' => ':attribute musí být řetězec.',
    'timezone' => ':attribute musí být platné časové pásmo.',
    'unique' => ':attribute již byl použit.',
    'uploaded' => ':attribute se nepodařilo nahrát.',
    'url' => ':attribute musí být platná adresa URL.',
    'uuid' => ':attribute musí být platný UUID.',

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
            'rule-name' => 'vlastní zpráva',
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
