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

    'accepted' => 'עליך לקבל את :attribute.',
    'accepted_if' => 'עליך לקבל את :attribute כאשר :other הוא :value.',
    'active_url' => ':attribute אינו כתובת URL תקינה.',
    'after' => 'עליך להזין תאריך אחר מ-:date בשדה :attribute.',
    'after_or_equal' => 'עליך להזין תאריך אחרי או שווה ל-:date בשדה :attribute.',
    'alpha' => 'עליך להזין רק אותיות בשדה :attribute.',
    'alpha_dash' => 'עליך להזין רק אותיות, מספרים, מקפים וקווים תחתונים בשדה :attribute.',
    'alpha_num' => 'עליך להזין רק אותיות ומספרים בשדה :attribute.',
    'array' => 'עליך להזין מערך בשדה :attribute.',
    'before' => 'עליך להזין תאריך לפני :date בשדה :attribute.',
    'before_or_equal' => 'עליך להזין תאריך לפני או שווה ל-:date בשדה :attribute.',
    'between' => [
        'array' => 'עליך להזין בין :min ל-:max פריטים בשדה :attribute.',
        'file' => 'עליך להזין בין :min ל-:max קילובייטים בשדה :attribute.',
        'numeric' => 'עליך להזין בין :min ל-:max בשדה :attribute.',
        'string' => 'עליך להזין בין :min ל-:max תווים בשדה :attribute.',
    ],
    'boolean' => 'עליך להזין ערך אמת או שקר בשדה :attribute.',
    'confirmed' => 'אימות :attribute אינו תואם.',
    'current_password' => 'הסיסמה אינה נכונה.',
    'date' => ':attribute אינו תאריך תקין.',
    'date_equals' => 'עליך להזין תאריך שווה ל-:date בשדה :attribute.',
    'date_format' => ':attribute אינו תואם את הפורמט :format.',
    'declined' => 'עליך לדחות את :attribute.',
    'declined_if' => 'עליך לדחות את :attribute כאשר :other הוא :value.',
    'different' => 'עליך להזין ערכים שונים עבור :attribute ו-:other.',
    'digits' => 'השדה :attribute חייב להיות :digits ספרות.',
    'digits_between' => 'השדה :attribute חייב להיות בין :min ל-:max ספרות.',
    'dimensions' => 'השדה :attribute מכיל מימדים שגויים.',
    'distinct' => 'השדה :attribute מכיל ערך כפול.',
    'doesnt_end_with' => 'השדה :attribute לא יכול להסתיים באחד מהערכים הבאים: :values.',
    'doesnt_start_with' => 'השדה :attribute לא יכול להתחיל באחד מהערכים הבאים: :values.',
    'email' => 'השדה :attribute חייב להיות כתובת דוא"ל תקפה.',
    'ends_with' => 'השדה :attribute חייב להסתיים באחד מהערכים הבאים: :values.',
    'enum' => 'הערך שנבחר עבור :attribute אינו תקף.',
    'exists' => 'הערך שנבחר עבור :attribute אינו תקף.',
    'file' => 'השדה :attribute חייב להיות קובץ.',
    'filled' => 'השדה :attribute חייב להכיל ערך.',
    'gt' => [
        'array' => 'השדה :attribute חייב להכיל יותר מ-:value פריטים.',
        'file' => 'השדה :attribute חייב להיות גדול מ-:value קילובייטים.',
        'numeric' => 'השדה :attribute חייב להיות גדול מ-:value.',
        'string' => 'השדה :attribute חייב להיות גדול מ-:value תווים.',
    ],
    'gte' => [
        'array' => 'השדה :attribute חייב להכיל :value פריטים או יותר.',
        'file' => 'השדה :attribute חייב להיות גדול או שווה ל-:value קילובייטים.',
        'numeric' => 'השדה :attribute חייב להיות גדול או שווה ל-:value.',
        'string' => 'השדה :attribute חייב להיות גדול או שווה ל-:value תווים.',
    ],
    'image' => 'השדה :attribute חייב להיות תמונה.',
    'in' => 'הערך שנבחר עבור :attribute אינו תקף.',
    'in_array' => 'השדה :attribute לא קיים ב-:other.',
    'integer' => 'השדה :attribute חייב להיות מספר שלם.',
    'ip' => 'ה-:attribute חייב להיות כתובת IP תקינה.',
    'ipv4' => 'ה-:attribute חייב להיות כתובת IPv4 תקינה.',
    'ipv6' => 'ה-:attribute חייב להיות כתובת IPv6 תקינה.',
    'json' => 'ה-:attribute חייב להיות מחרוזת JSON תקינה.',
    'lt' => [
        'array' => 'ה-:attribute חייב להכיל פחות מ-:value פריטים.',
        'file' => 'ה-:attribute חייב להיות קטן מ-:value קילובייטים.',
        'numeric' => 'ה-:attribute חייב להיות קטן מ-:value.',
        'string' => 'ה-:attribute חייב להיות קטן מ-:value תווים.',
    ],
    'lte' => [
        'array' => 'ה-:attribute לא יכול להכיל יותר מ-:value פריטים.',
        'file' => 'ה-:attribute חייב להיות קטן או שווה ל-:value קילובייטים.',
        'numeric' => 'ה-:attribute חייב להיות קטן או שווה ל-:value.',
        'string' => 'ה-:attribute חייב להיות קטן או שווה ל-:value תווים.',
    ],
    'mac_address' => 'ה-:attribute חייב להיות כתובת MAC תקינה.',
    'max' => [
        'array' => 'ה-:attribute לא יכול להכיל יותר מ-:max פריטים.',
        'file' => 'ה-:attribute לא יכול להיות גדול מ-:max קילובייטים.',
        'numeric' => 'ה-:attribute לא יכול להיות גדול מ-:max.',
        'string' => 'ה-:attribute לא יכול להיות גדול מ-:max תווים.',
    ],
    'max_digits' => 'ה-:attribute לא יכול להכיל יותר מ-:max ספרות.',
    'mimes' => 'ה-:attribute חייב להיות קובץ מסוג: :values.',
    'mimetypes' => 'ה-:attribute חייב להיות קובץ מסוג: :values.',
    'min' => [
        'array' => 'ה-:attribute חייב להכיל לפחות :min פריטים.',
        'file' => 'ה-:attribute חייב להיות לפחות :min קילובייטים.',
        'numeric' => 'ה-:attribute חייב להיות לפחות :min.',
        'string' => 'ה:attribute חייב להכיל לפחות :min תווים.',
    ],
    'min_digits' => 'ה:attribute חייב להכיל לפחות :min ספרות.',
    'multiple_of' => 'ה:attribute חייב להיות מרובע של :value.',
    'not_in' => 'ה:attribute שנבחר אינו תקף.',
    'not_regex' => 'הפורמט של :attribute אינו תקף.',
    'numeric' => 'ה:attribute חייב להיות מספר.',
    'password' => [
        'letters' => 'ה:attribute חייב להכיל לפחות אות אחת.',
        'mixed' => 'ה:attribute חייב להכיל לפחות אות גדולה אחת ואות קטנה אחת.',
        'numbers' => 'ה:attribute חייב להכיל לפחות מספר אחד.',
        'symbols' => 'ה:attribute חייב להכיל לפחות סמל אחד.',
        'uncompromised' => 'ה:attribute שניתן הופיע בפרצת נתונים. אנא בחר :attribute אחר.',
    ],
    'present' => 'שדה ה:attribute חייב להיות קיים.',
    'prohibited' => 'שדה ה:attribute אסור.',
    'prohibited_if' => 'שדה ה:attribute אסור כאשר :other הוא :value.',
    'prohibited_unless' => 'שדה ה:attribute אסור אלא אם :other נמצא בתוך :values.',
    'prohibits' => 'שדה ה:attribute אסור להופיע כאשר :other קיים.',
    'regex' => 'הפורמט של :attribute אינו תקף.',
    'required' => 'שדה ה:attribute נדרש.',
    'required_array_keys' => 'שדה ה:attribute חייב להכיל ערכים עבור: :values.',
    'required_if' => 'שדה ה:attribute נדרש כאשר :other הוא :value.',
    'required_unless' => 'שדה ה:attribute נדרש אלא אם :other נמצא בתוך :values.',
    'required_with' => 'שדה ה:attribute נדרש כאשר :values קיימים.',
    'required_with_all' => 'שדה ה:attribute נדרש כאשר :values קיימים.',
    'required_without' => 'שדה :attribute נדרש כאשר :values אינו קיים.',
    'required_without_all' => 'שדה :attribute נדרש כאשר אף אחד מתוך :values אינם קיימים.',
    'same' => 'שדה :attribute ו:other חייבים להתאים.',
    'size' => [
        'array' => 'שדה :attribute חייב להכיל :size פריטים.',
        'file' => 'שדה :attribute חייב להיות :size קילובייטים.',
        'numeric' => 'שדה :attribute חייב להיות :size.',
        'string' => 'על ה-:attribute להיות :size תווים.',
    ],
    'starts_with' => 'על ה-:attribute להתחיל באחד מהערכים הבאים: :values.',
    'string' => 'על ה-:attribute להיות מחרוזת.',
    'timezone' => 'על ה-:attribute להיות אזור זמן תקף.',
    'unique' => 'ה-:attribute כבר נלקח.',
    'uploaded' => 'העלאת ה-:attribute נכשלה.',
    'url' => 'על ה-:attribute להיות כתובת URL תקפה.',
    'uuid' => 'על ה-:attribute להיות UUID תקף.',

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
            'rule-name' => 'הודעה מותאמת אישית',
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
