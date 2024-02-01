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

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'array' => 'The :attribute must have between :min and :max items.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'numeric' => 'The :attribute must be between :min and :max.',
        'string' => 'The :attribute must be between :min and :max characters.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'De :attribute mutt :digits Zaln.',
    'digits_between' => 'De :attribute mutt zwische :min unn :max Zaln Zaln.',
    'dimensions' => 'De :attribute hot ungültich Bild-Dimensioone.',
    'distinct' => 'De :attribute Feld hot en Duplicate-Wert.',
    'doesnt_end_with' => 'De :attribute darf net en vun denne Endunge hunn: :values.',
    'doesnt_start_with' => 'De :attribute darf net en vun denne Uffonge hunn: :values.',
    'email' => 'De :attribute mutt en gültegen E-Mail-Adresse sinn.',
    'ends_with' => 'De :attribute mutt en vun denne Endunge hunn: :values.',
    'enum' => 'De ausgewählte :attribute is ungültich.',
    'exists' => 'De ausgewählte :attribute is ungültich.',
    'file' => 'De :attribute mutt en Datei sinn.',
    'filled' => 'De :attribute Feld muss en Wert hunn.',
    'gt' => [
        'array' => 'De :attribute mutt méi wéi :value Elementer hunn.',
        'file' => 'De :attribute mutt méi wéi :value Kilobyte grouss sinn.',
        'numeric' => 'De :attribute mutt méi wéi :value sinn.',
        'string' => 'De :attribute mutt méi wéi :value Zeechen hunn.',
    ],
    'gte' => [
        'array' => 'De :attribute muss :value Elementer oder méi hunn.',
        'file' => 'De :attribute muss méi wéi oder gläich wéi :value Kilobyte sinn.',
        'numeric' => 'De :attribute muss méi wéi oder gläich wéi :value sinn.',
        'string' => 'De :attribute muss méi wéi oder gläich wéi :value Zeechen hunn.',
    ],
    'image' => 'De :attribute muss en Bild sinn.',
    'in' => 'De ausgewählte :attribute is ungültich.',
    'in_array' => 'De :attribute Feld existéiert net an :other.',
    'integer' => 'De :attribute mutt en Zuel sinn.',
    'ip' => 'De :attribute müss a güldich IP-Adress sain.',
    'ipv4' => 'De :attribute müss a güldich IPv4-Adress sain.',
    'ipv6' => 'De :attribute müss a güldich IPv6-Adress sain.',
    'json' => 'De :attribute müss a güldich JSON-Zeichesatz sain.',
    'lt' => [
        'array' => 'De :attribute müss weniger wia :value Elemente hunn.',
        'file' => 'De :attribute müss weniger wia :value Kilobyte hunn.',
        'numeric' => 'De :attribute müss weniger wia :value sain.',
        'string' => 'De :attribute müss weniger wia :value Zeichen hunn.',
    ],
    'lte' => [
        'array' => 'De :attribute därf net méi wéi :value Elementer hunn.',
        'file' => 'De :attribute müss wéineger oder gläich wéi :value Kilobyte hunn.',
        'numeric' => 'De :attribute müss wéineger oder gläich wéi :value sain.',
        'string' => 'De :attribute müss wéineger oder gläich wéi :value Zeichen hunn.',
    ],
    'mac_address' => 'De :attribute müss a güldich MAC-Adress sain.',
    'max' => [
        'array' => 'De :attribute därf net méi wéi :max Elementer hunn.',
        'file' => 'De :attribute därf net méi wéi :max Kilobyte hunn.',
        'numeric' => 'De :attribute därf net méi wéi :max sain.',
        'string' => 'De :attribute därf net méi wéi :max Zeichen hunn.',
    ],
    'max_digits' => 'De :attribute därf net méi wéi :max Zuel vun Dezimalstellen hunn.',
    'mimes' => 'De :attribute müss en Dateityp hunn vun: :values.',
    'mimetypes' => 'De :attribute müss en Dateityp hunn vun: :values.',
    'min' => [
        'array' => 'De :attribute muss mindestens :min Elementer hunn.',
        'file' => 'De :attribute muss mindestens :min Kilobyte hunn.',
        'numeric' => 'De :attribute müss minstens :min sinn.',
        'string' => 'De :attribute müss minstens :min Zeiche hun.',
    ],
    'min_digits' => 'De :attribute müss minstens :min Zifferen hun.',
    'multiple_of' => 'De :attribute müss en Multipel vu :value sinn.',
    'not_in' => 'De gewielte :attribute ass ongëlteg.',
    'not_regex' => 'De Format vu :attribute ass ongëlteg.',
    'numeric' => 'De :attribute müss eng Zuel sinn.',
    'password' => [
        'letters' => 'De :attribute muss mindestens een Buchstabe enthalen.',
        'mixed' => 'De :attribute muss mindestens een groussen an een klengen Buchstabe enthalen.',
        'numbers' => 'De :attribute muss mindestens een Zuel enthalen.',
        'symbols' => 'De :attribute muss mindestens een Symbol enthalen.',
        'uncompromised' => 'De ginnenen :attribute ass an enger Datenleek opgetrueden. Wiel w.e.g. en aneren :attribute.',
    ],
    'present' => 'Den :attribute Feld muss present sinn.',
    'prohibited' => 'Den :attribute Feld ass verbueden.',
    'prohibited_if' => 'Den :attribute Feld ass verbueden wann :other :value ass.',
    'prohibited_unless' => 'Den :attribute Feld ass verbueden esoufern :other an :values ass.',
    'prohibits' => 'Den :attribute Feld verbitt :other d\'Present sinn ze maachen.',
    'regex' => 'De Format vu :attribute ass ongëlteg.',
    'required' => 'Den :attribute Feld ass erfuerlech.',
    'required_array_keys' => 'Den :attribute Feld muss Entraeger hun fir: :values.',
    'required_if' => 'Den :attribute Feld ass erfuerlech wann :other :value ass.',
    'required_unless' => 'Den :attribute Feld ass erfuerlech esoufern :other an :values ass.',
    'required_with' => 'Den :attribute Feld ass erfuerlech wann :values present ass.',
    'required_with_all' => 'Das :attribute Feld ist erforderlich, wenn :values vorhanden sind.',
    'required_without' => 'Das :attribute Feld ist erforderlich, wenn :values nicht vorhanden ist.',
    'required_without_all' => 'Das :attribute Feld ist erforderlich, wenn keines der :values vorhanden ist.',
    'same' => 'Das :attribute und :other müssen übereinstimmen.',
    'size' => [
        'array' => 'Das :attribute muss :size Elemente enthalten.',
        'file' => 'Das :attribute muss :size Kilobyte groß sein.',
        'numeric' => 'Das :attribute muss :size sein.',
        'string' => 'Die :attribute muss :size Zeichen lang sein.',
    ],
    'starts_with' => 'Die :attribute muss mit einem der folgenden Werte beginnen: :values.',
    'string' => 'Die :attribute muss ein String sein.',
    'timezone' => 'Die :attribute muss eine gültige Zeitzone sein.',
    'unique' => 'Die :attribute wurde bereits verwendet.',
    'uploaded' => 'Das Hochladen der :attribute ist fehlgeschlagen.',
    'url' => 'Die :attribute muss eine gültige URL sein.',
    'uuid' => 'Die :attribute muss eine gültige UUID sein.',

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
            'rule-name' => 'Benutzerdefinierte Nachricht',
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
