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

    'accepted' => 'Το :attribute πρέπει να γίνει αποδεκτό.',
    'accepted_if' => 'Το :attribute πρέπει να γίνει αποδεκτό όταν :other είναι :value.',
    'active_url' => 'Το χαρακτηριστικό: δεν είναι έγκυρο URL.',
    'after' => 'To :attribute πρέπει να είναι μια ημερομηνία μετά τις :date.',
    'after_or_equal' => 'Το χαρακτηριστικό: πρέπει να είναι μια ημερομηνία μετά ή ίσο με: ημερομηνία.',
    'alpha' => 'Το :attribute πρέπει να περιέχει μόνο γράμματα.',
    'alpha_dash' => 'Το χαρακτηριστικό: πρέπει να περιέχει μόνο γράμματα, αριθμούς, παύλες και κάτω παύλες.',
    'alpha_num' => 'Το χαρακτηριστικό: πρέπει να περιέχει μόνο γράμματα και αριθμούς.',
    'array' => 'To :attribute πρέπει να είναι ένας πίνακας.',
    'before' => 'Η ιδιότητα: πρέπει να είναι μια ημερομηνία πριν από :date.',
    'before_or_equal' => 'Το χαρακτηριστικό: πρέπει να είναι μια ημερομηνία πριν ή ίσο με: ημερομηνία.',
    'between' => [
        'array' => 'Το χαρακτηριστικό: πρέπει να έχει μεταξύ :min και :max αντικείμενα.',
        'file' => 'Το :attribute πρέπει να είναι μεταξύ :min και :max kilobytes.',
        'numeric' => 'Το :attribute πρέπει να είναι μεταξύ :min και :max.',
        'string' => 'Το χαρακτηριστικό: πρέπει να είναι μεταξύ :min και :max χαρακτήρες.',
    ],
    'boolean' => 'Το πεδίο ιδιοτήτων: πρέπει να είναι αληθές ή ψευδές.',
    'confirmed' => 'Η επιβεβαίωση του χαρακτηριστικού δεν ταιριάζει.',
    'current_password' => 'Ο κωδικός πρόσβασης είναι εσφαλμένος.',
    'date' => 'Το χαρακτηριστικό: δεν είναι έγκυρη ημερομηνία.',
    'date_equals' => 'To :attribute πρέπει να είναι μια ημερομηνία ίση με :date.',
    'date_format' => 'Το :attribute δεν ταιριάζει με τη μορφή: format.',
    'declined' => 'Το χαρακτηριστικό: πρέπει να απορριφθεί.',
    'declined_if' => 'To :attribute πρέπει να απορριφθεί όταν :other είναι :value.',
    'different' => 'Το :attribute και :other πρέπει να είναι διαφορετικά.',
    'digits' => 'Το :attribute πρέπει να είναι: ψηφία ψηφία.',
    'digits_between' => 'Το :attribute πρέπει να είναι μεταξύ :min και :max ψηφία.',
    'dimensions' => 'Το χαρακτηριστικό: έχει μη έγκυρες διαστάσεις εικόνας.',
    'distinct' => 'Το πεδίο ιδιοτήτων: έχει διπλότυπη τιμή.',
    'doesnt_end_with' => 'Το :attribute δεν μπορεί να τελειώσει με ένα από τα ακόλουθα: :values.',
    'doesnt_start_with' => 'Το :attribute δεν μπορεί να ξεκινήσει με ένα από τα εξής: :values.',
    'email' => 'Το χαρακτηριστικό: πρέπει να είναι μια έγκυρη διεύθυνση email.',
    'ends_with' => 'Το :attribute πρέπει να τελειώνει με ένα από τα εξής: :values.',
    'enum' => 'Το επιλεγμένο :attribute δεν είναι έγκυρο.',
    'exists' => 'Το επιλεγμένο :attribute δεν είναι έγκυρο.',
    'file' => 'Το :attribute πρέπει να είναι αρχείο.',
    'filled' => 'Το πεδίο ιδιοτήτων: πρέπει να έχει τιμή.',
    'gt' => [
        'array' => 'To :attribute πρέπει να έχει περισσότερα από :value αντικείμενα.',
        'file' => 'Το :attribute πρέπει να είναι μεγαλύτερο από :value kilobytes.',
        'numeric' => 'Το :attribute πρέπει να είναι μεγαλύτερο από :value.',
        'string' => 'To :attribute πρέπει να είναι μεγαλύτερο από :value χαρακτήρες.',
    ],
    'gte' => [
        'array' => 'To :attribute πρέπει να έχει :value στοιχεία ή περισσότερα.',
        'file' => 'Το :attribute πρέπει να είναι μεγαλύτερο ή ίσο με :value kilobytes.',
        'numeric' => 'Το :attribute πρέπει να είναι μεγαλύτερο ή ίσο με :value.',
        'string' => 'Το :attribute πρέπει να είναι μεγαλύτερο ή ίσο με :value χαρακτήρες.',
    ],
    'image' => 'To :attribute πρέπει να είναι μια εικόνα.',
    'in' => 'Το επιλεγμένο :attribute δεν είναι έγκυρο.',
    'in_array' => 'Το πεδίο ιδιοτήτων: δεν υπάρχει σε: άλλο.',
    'integer' => 'To :attribute πρέπει να είναι ακέραιος αριθμός.',
    'ip' => 'Το χαρακτηριστικό: πρέπει να είναι μια έγκυρη διεύθυνση IP.',
    'ipv4' => 'Το χαρακτηριστικό: πρέπει να είναι μια έγκυρη διεύθυνση IPv4.',
    'ipv6' => 'Το χαρακτηριστικό: πρέπει να είναι μια έγκυρη διεύθυνση IPv6.',
    'json' => 'Το χαρακτηριστικό: πρέπει να είναι μια έγκυρη συμβολοσειρά JSON.',
    'lt' => [
        'array' => 'To :attribute πρέπει να έχει λιγότερα από :value αντικείμενα.',
        'file' => 'Το :attribute πρέπει να είναι μικρότερο από :value kilobytes.',
        'numeric' => 'Το :attribute πρέπει να είναι μικρότερο από :value.',
        'string' => 'Το χαρακτηριστικό: πρέπει να είναι λιγότερο από :value χαρακτήρες.',
    ],
    'lte' => [
        'array' => 'To :attribute δεν πρέπει να έχει περισσότερα από :value αντικείμενα.',
        'file' => 'Το :attribute πρέπει να είναι μικρότερο ή ίσο με :value kilobytes.',
        'numeric' => 'Το :attribute πρέπει να είναι μικρότερο ή ίσο με :value.',
        'string' => 'To :attribute πρέπει να είναι μικρότερο ή ίσο με :value characters.',
    ],
    'mac_address' => 'Το χαρακτηριστικό: πρέπει να είναι μια έγκυρη διεύθυνση MAC.',
    'max' => [
        'array' => 'To :attribute δεν πρέπει να έχει περισσότερα από :max αντικείμενα.',
        'file' => 'Το :attribute δεν πρέπει να είναι μεγαλύτερο από: max kilobytes.',
        'numeric' => 'Το :attribute δεν πρέπει να είναι μεγαλύτερο από :max.',
        'string' => 'To :attribute δεν πρέπει να είναι μεγαλύτερο από :max χαρακτήρες.',
    ],
    'max_digits' => 'Το :attribute δεν πρέπει να έχει περισσότερα από :max ψηφία.',
    'mimes' => 'Το :attribute πρέπει να είναι αρχείο τύπου: :values.',
    'mimetypes' => 'Το :attribute πρέπει να είναι αρχείο τύπου: :values.',
    'min' => [
        'array' => 'To :attribute πρέπει να έχει τουλάχιστον :min αντικείμενα.',
        'file' => 'To :attribute πρέπει να είναι τουλάχιστον :min kilobytes.',
        'numeric' => 'To :attribute πρέπει να είναι τουλάχιστον :min.',
        'string' => 'To :attribute πρέπει να είναι τουλάχιστον :min χαρακτήρες.',
    ],
    'min_digits' => 'To :attribute πρέπει να έχει τουλάχιστον :min ψηφία.',
    'multiple_of' => 'To :attribute πρέπει να είναι πολλαπλάσιο από :value.',
    'not_in' => 'Το επιλεγμένο :attribute δεν είναι έγκυρο.',
    'not_regex' => 'Η μορφή :attribute δεν είναι έγκυρη.',
    'numeric' => 'To :attribute πρέπει να είναι αριθμός.',
    'password' => [
        'letters' => 'To :attribute πρέπει να περιέχει τουλάχιστον ένα γράμμα.',
        'mixed' => 'Το χαρακτηριστικό: πρέπει να περιέχει τουλάχιστον ένα κεφαλαίο και ένα πεζό γράμμα.',
        'numbers' => 'To :attribute πρέπει να περιέχει τουλάχιστον έναν αριθμό.',
        'symbols' => 'To :attribute πρέπει να περιέχει τουλάχιστον ένα σύμβολο.',
        'uncompromised' => 'Το δοσμένο :attribute εμφανίστηκε σε μια διαρροή δεδομένων. Παρακαλώ επιλέξτε ένα διαφορετικό: χαρακτηριστικό.',
    ],
    'present' => 'Το πεδίο ιδιοτήτων: πρέπει να είναι παρόν.',
    'prohibited' => 'Το πεδίο :attribute απαγορεύεται.',
    'prohibited_if' => 'Το πεδίο ιδιοτήτων: απαγορεύεται όταν :other είναι :value.',
    'prohibited_unless' => 'Το πεδίο ιδιοτήτων: απαγορεύεται εκτός αν :other είναι σε :values.',
    'prohibits' => 'Το πεδίο ιδιοτήτων: απαγορεύει την παρουσία :other .',
    'regex' => 'Η μορφή :attribute δεν είναι έγκυρη.',
    'required' => 'Το πεδίο ιδιοτήτων: απαιτείται.',
    'required_array_keys' => 'Το πεδίο :attribute πρέπει να περιέχει καταχωρήσεις για: :values.',
    'required_if' => 'Το πεδίο ιδιοτήτων: απαιτείται όταν :other είναι :value.',
    'required_unless' => 'Το πεδίο ιδιοτήτων: απαιτείται εκτός εάν: το άλλο είναι σε :values.',
    'required_with' => 'Το πεδίο :attribute είναι απαραίτητο όταν :values είναι παρούσες.',
    'required_with_all' => 'Το πεδίο ιδιοτήτων: απαιτείται όταν: είναι παρούσες τιμές.',
    'required_without' => 'Το πεδίο ιδιοτήτων: απαιτείται όταν :values δεν είναι παρούσες.',
    'required_without_all' => 'Το πεδίο ιδιοτήτων: απαιτείται όταν δεν υπάρχει καμία από :values.',
    'same' => 'Το :attribute και :other πρέπει να ταιριάζουν.',
    'size' => [
        'array' => 'To :attribute πρέπει να περιέχει :size αντικείμενα.',
        'file' => 'Το :attribute πρέπει να είναι :size kilobytes.',
        'numeric' => 'Το :attribute πρέπει να είναι :size.',
        'string' => 'Το χαρακτηριστικό: πρέπει να είναι: χαρακτήρες μεγέθους.',
    ],
    'starts_with' => 'Το :attribute πρέπει να ξεκινά με ένα από τα εξής: :values.',
    'string' => 'Το :attribute πρέπει να είναι συμβολοσειρά.',
    'timezone' => 'Το χαρακτηριστικό: πρέπει να είναι μια έγκυρη ζώνη ώρας.',
    'unique' => 'Το χαρακτηριστικό: έχει ήδη ληφθεί.',
    'uploaded' => 'Το :attribute απέτυχε να μεταφορτωθεί.',
    'url' => 'To :attribute πρέπει να είναι μια έγκυρη διεύθυνση URL.',
    'uuid' => 'Το χαρακτηριστικό: πρέπει να είναι ένα έγκυρο UUID.',

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
            'rule-name' => 'προσαρμοσμένο μήνυμα',
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
