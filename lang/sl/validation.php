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

    'accepted' => ':attribute mora biti potrjen.',
    'accepted_if' => ':attribute je potrebno sprejeti ko :other je :value.',
    'active_url' => ':attribute ni veljaven URL.',
    'after' => ':attribute mora biti datum za :date.',
    'after_or_equal' => 'Atribut mora biti datum po ali enak: datumu.',
    'alpha' => ':attribute naj vsebuje le črke.',
    'alpha_dash' => ':attribute naj vsebuje le črke, številke, pomišljaje in podčrtaje.',
    'alpha_num' => ':attribute naj vsebuje le črke in številke.',
    'array' => ':attribute mora biti polje.',
    'before' => ':attribute naj bo datum pred :date.',
    'before_or_equal' => ':attribute mora biti datum pred ali enak :date.',
    'between' => [
        'array' => ':attribute naj bo vmes med :min in :max elementi.',
        'file' => ':attribute mora biti med :min in :max kilobajti.',
        'numeric' => ':attribute mora biti med :min in :max.',
        'string' => ':attribute mora biti med :min in :max znakov.',
    ],
    'boolean' => ':attribute polje naj bo pravilno ali napačno.',
    'confirmed' => 'Potrditev :attribute se ne ujema.',
    'current_password' => 'Geslo je napačno.',
    'date' => ':attribute ni veljaven datum.',
    'date_equals' => ':attribute mora biti datum enak :date.',
    'date_format' => ':attribute se ne ujema z obliko :format.',
    'declined' => ':attribute mora biti zavrnjen.',
    'declined_if' => ':attribute je potrebno zavrniti ko :other je :value.',
    'different' => ':attribute in :other morata biti različna.',
    'digits' => ':attribute mora imeti :digits cifer.',
    'digits_between' => ':attribute mora biti med :min in :max števkami.',
    'dimensions' => ':attribute ima nepravilno dimenzijo slike.',
    'distinct' => ':attribute polje ima podvojeno vrednost.',
    'doesnt_end_with' => ':attribute naj se konča z eno od naslednjih :values.',
    'doesnt_start_with' => ':attribute naj bi se začel z eno od naslednjih :values.',
    'email' => ':attribute mora biti veljaven e-naslov.',
    'ends_with' => ':attribute naj se konča z eno od naslednjih :values.',
    'enum' => 'Izbran :attribute je neveljaven.',
    'exists' => 'Izbran :attribute je neveljaven.',
    'file' => ':attribute mora biti datoteka.',
    'filled' => ':attribute polje mora imeti vrednost.',
    'gt' => [
        'array' => ':attribute naj ima več od :value elementov.',
        'file' => ':attribute naj bi večji od :value kilobajtov.',
        'numeric' => ':attribute mora biti večji kot :value.',
        'string' => ':attribute naj bo večji od :value znakov.',
    ],
    'gte' => [
        'array' => ':attribute mora imeti :value znakov ali več.',
        'file' => ':attribute naj bo večji ali enak :value kilobajtov.',
        'numeric' => ':attribute naj bi večji od ali enak :value.',
        'string' => ':attribute naj bo večji ali enak :value znakov.',
    ],
    'image' => ':attribute naj bo slika.',
    'in' => 'Izbran :attribute je neveljaven.',
    'in_array' => ':attribute polje ne obstaja v :other.',
    'integer' => ':attribute mora biti celo število.',
    'ip' => ':attribute mora biti veljaven IP naslov.',
    'ipv4' => ':attribute naj ima veljaven IPv4 naslov.',
    'ipv6' => ':attribute mora biti veljaven IPv6 naslov.',
    'json' => ':attribute naj bo veljaven JSON.',
    'lt' => [
        'array' => ':attribute mora imeti manj kot :value elementov.',
        'file' => ':attribute naj bi manjši od :value kilobajtov.',
        'numeric' => ':attribute naj bo manj od :value.',
        'string' => ':attribute mora biti manj kot :value znakov.',
    ],
    'lte' => [
        'array' => ':attribute naj bi imel več kot :value elementov.',
        'file' => ':atribute naj bi bil manjši ali enak :value kilobajtov.',
        'numeric' => ':attribute naj bi imel manj ali enako kot :value.',
        'string' => ':attribute naj bi bil manj ali enak :value znakov.',
    ],
    'mac_address' => ':attribute mora biti veljaven MAC naslov.',
    'max' => [
        'array' => ':attribute naj ne bi imel več kot :max znakov.',
        'file' => ':attribute naj ne bi bil večji od :max kilobajtov.',
        'numeric' => ':attribute naj ne bi bil večji od :max.',
        'string' => ':attribute naj ne bi bil večji kot :max znakov.',
    ],
    'max_digits' => ':attribute naj ne bi imel več kot :max številk.',
    'mimes' => ':attribute mora biti datoteka type: :values.',
    'mimetypes' => ':attribute mora biti datoteka type: :values.',
    'min' => [
        'array' => ':attribute mora imeti vsaj :min elementov.',
        'file' => ':attribute naj bi bil vsaj :min kilobajtov.',
        'numeric' => ':attribute naj bi bil vsaj :min.',
        'string' => ':attribute mora imeti najmanj :min znakov.',
    ],
    'min_digits' => ':attribute mora imeti vsaj :min števil.',
    'multiple_of' => ':attribute naj bi bil večkratnik od :value.',
    'not_in' => 'Izbran :attribute je neveljaven.',
    'not_regex' => ':attribute oblika ni veljavna.',
    'numeric' => ':attribute mora biti število.',
    'password' => [
        'letters' => ':attribute mora vsebovati vsaj eno črko.',
        'mixed' => 'The :attribute must contain at least one uppercase and one lowercase letter.',
        'numbers' => ':attribute mora vsebovati vsaj eno število.',
        'symbols' => ':attribute mora vsebovati vsaj en znak.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => ':attribute polje naj bi bilo izpolnjeno.',
    'prohibited' => ':attribute polje je prepovedano.',
    'prohibited_if' => ':attribute polje je obvezno, če :other je :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => ':attribute oblika ni veljavna.',
    'required' => ':attribute polje je obvezno.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => ':attribute polje je obvezno, če :other je :value.',
    'required_unless' => ':attribute polje je obvezno, razen če :other je v :values.',
    'required_with' => ':attribute polje je obvezno ko je prisotna :values.',
    'required_with_all' => ':attribute polje je obvezno ko je prisotna :values.',
    'required_without' => ':attribute polje je obvezno, ko :values ni prisotno.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'array' => 'The :attribute must contain :size items.',
        'file' => 'The :attribute must be :size kilobytes.',
        'numeric' => 'The :attribute must be :size.',
        'string' => 'Atribut mora biti: velikost znakov.',
    ],
    'starts_with' => ':attribute naj bi se začel z eno od naslednjih :values.',
    'string' => ':attribute mora biti niz.',
    'timezone' => ':attribute mora biti veljavna časovni pas.',
    'unique' => ':attribute je že zasedeno.',
    'uploaded' => 'Nalaganje :attribute ni uspelo.',
    'url' => ':attribute naj bi bil veljaven URL.',
    'uuid' => ':attribute mora biti veljaven UUID.',

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
            'rule-name' => 'sporočilo po meri',
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
