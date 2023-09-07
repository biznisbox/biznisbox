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

    'accepted' => 'Määrite :attribute on hyväksyttävä.',
    'accepted_if' => 'Kentän :attribute arvon tulee olla hyväksyttävä, kun :other on :value.',
    'active_url' => 'Määrite :attribute ei ole kelvollinen URL.',
    'after' => 'Kentän :attribute arvon on oltava päivämäärä :date jälkeen.',
    'after_or_equal' => 'Kentän :attribute päiväyksen tulee olla yhtä suuri tai seuraavista: päivämäärä.',
    'alpha' => 'Kentän :attribute tulee sisältää vain kirjaimia.',
    'alpha_dash' => 'Attribuutti saa sisältää vain kirjaimia, numeroita, väliviivoja ja alaviivoja.',
    'alpha_num' => 'Kentän :attribute tulee sisältää vain kirjaimia ja numeroita.',
    'array' => 'Kentän :attribute arvon on oltava taulukko.',
    'before' => 'Kentän :attribute päiväyksen on oltava ennen :date.',
    'before_or_equal' => 'Kentän :attribute päiväyksen on oltava ennen tai yhtä suuri kuin :date.',
    'between' => [
        'array' => 'Kentän :attribute tulee olla välillä :min ja :max kohteita.',
        'file' => 'Kentän :attribute tulee olla :min ja :max kilotavua.',
        'numeric' => 'Kentän :attribute tulee olla välillä :min ja :max.',
        'string' => 'Kentän :attribute arvon tulee olla :min - :max merkkiä pitkä.',
    ],
    'boolean' => 'Kentän :attribute arvon on oltava tosi tai epätosi.',
    'confirmed' => 'Määritteen :attribute vahvistus ei täsmää.',
    'current_password' => 'Salasana on virheellinen.',
    'date' => 'Määrite :attribute ei ole kelvollinen päivämäärä.',
    'date_equals' => 'Kentän :attribute päivämäärän on oltava yhtä suuri kuin :date.',
    'date_format' => 'Kentän :attribute arvo ei vastaa muotoa :format.',
    'declined' => 'Kentän :attribute arvon tulee olla hylätty.',
    'declined_if' => 'Kentän :attribute arvon tulee olla hylätty, kun :other on :value.',
    'different' => 'Määritteen :attribute ja :other on oltava erilainen.',
    'digits' => 'Kentän :attribute arvon on oltava :digits numeroa.',
    'digits_between' => 'Kentän :attribute arvon on oltava :min - :max numeroa.',
    'dimensions' => 'Kentän :attribute kuvan mitat ovat virheelliset.',
    'distinct' => 'Kentän :attribute arvo on kaksoiskappale.',
    'doesnt_end_with' => 'Kentän :attribute arvo ei saa päättyä johonkin seuraavista: :values.',
    'doesnt_start_with' => 'Määrite :attribute ei saa alkaa jollakin seuraavista: :values.',
    'email' => 'Kentän :attribute arvon tulee olla kelvollinen sähköpostiosoite.',
    'ends_with' => 'Kentän :attribute arvon tulee päättyä johonkin seuraavista: :values.',
    'enum' => 'Valittu :attribute on virheellinen.',
    'exists' => 'Valittu :attribute on virheellinen.',
    'file' => 'Kentän :attribute arvon on oltava tiedosto.',
    'filled' => 'Kentän :attribute arvolla on oltava arvo.',
    'gt' => [
        'array' => 'Kentän :attribute arvon tulee olla enemmän kuin :value kohteet.',
        'file' => 'Kentän :attribute arvon on oltava suurempi kuin :value kilotavut.',
        'numeric' => 'Kentän :attribute arvon on oltava suurempi kuin :value.',
        'string' => 'Kentän :attribute arvon on oltava suurempi kuin :value merkkiä.',
    ],
    'gte' => [
        'array' => 'Kentän :attribute tulee olla :value items tai enemmän.',
        'file' => 'Määritteen :attribute on oltava suurempi tai yhtä suuri kuin :value kilotavut.',
        'numeric' => 'Kentän :attribute arvon on oltava suurempi tai yhtä suuri kuin :value.',
        'string' => 'Kentän :attribute arvon on oltava suurempi tai yhtä suuri kuin :value merkkiä.',
    ],
    'image' => 'Kentän :attribute arvon on oltava kuva.',
    'in' => 'Valittu :attribute on virheellinen.',
    'in_array' => 'Attribuutti-kenttää ei ole olemassa :other.',
    'integer' => 'Kentän :attribute arvon on oltava kokonaisluku.',
    'ip' => 'Kentän :attribute arvon on oltava kelvollinen IP-osoite.',
    'ipv4' => 'Kentän :attribute arvon on oltava kelvollinen IPv4-osoite.',
    'ipv6' => 'Kentän :attribute arvon on oltava kelvollinen IPv6-osoite.',
    'json' => 'Kentän :attribute arvon on oltava kelvollinen JSON merkkijono.',
    'lt' => [
        'array' => 'Kentän :attribute arvon on oltava pienempi kuin :value kohteet.',
        'file' => 'Kentän :attribute arvon on oltava pienempi kuin :value kilotavut.',
        'numeric' => 'Kentän :attribute arvon on oltava pienempi kuin :value.',
        'string' => 'Kentän :attribute arvon on oltava pienempi kuin :value merkki.',
    ],
    'lte' => [
        'array' => 'Kentän :attribute arvo saa olla enintään :value kohteita.',
        'file' => 'Määritteen :attribute on oltava pienempi tai yhtä suuri kuin :value kilotavut.',
        'numeric' => 'Kentän :attribute arvon on oltava pienempi tai yhtä suuri kuin :value.',
        'string' => 'Kentän :attribute arvon on oltava pienempi tai yhtä suuri kuin :value merkkiä.',
    ],
    'mac_address' => 'Kentän :attribute arvon on oltava kelvollinen MAC-osoite.',
    'max' => [
        'array' => 'Attribuutilla ei saa olla enempää kuin :max kohteita.',
        'file' => 'Kentän :attribute arvo ei saa olla suurempi kuin :max kilotavua.',
        'numeric' => 'Kentän :attribute arvo ei saa olla suurempi kuin :max.',
        'string' => 'Kentän :attribute arvo ei saa olla suurempi kuin :max merkkiä.',
    ],
    'max_digits' => 'Kentän :attribute arvo saa olla enintään :max numeroa.',
    'mimes' => 'Kentän :attribute arvon on oltava tyyppi: :values.',
    'mimetypes' => 'Kentän :attribute arvon on oltava tyyppi: :values.',
    'min' => [
        'array' => 'Kentän :attribute tulee sisältää vähintään :min kohteita.',
        'file' => 'Kentän :attribute arvon on oltava vähintään :min kilotavua.',
        'numeric' => 'Kentän :attribute arvon on oltava vähintään :min.',
        'string' => 'Kentän :attribute arvon on oltava vähintään :min merkkiä.',
    ],
    'min_digits' => 'Kentän :attribute arvon tulee olla vähintään :min numeroa.',
    'multiple_of' => 'Kentän :attribute arvon on oltava moninkertainen.',
    'not_in' => 'Valittu :attribute on virheellinen.',
    'not_regex' => 'Määritteen :attribute muoto on virheellinen.',
    'numeric' => 'Kentän :attribute arvon on oltava numero.',
    'password' => [
        'letters' => 'Kentän :attribute tulee sisältää vähintään yksi kirjain.',
        'mixed' => 'Kentän :attribute arvon tulee sisältää vähintään yksi iso kirjain ja yksi pieni kirjain.',
        'numbers' => 'Kentän :attribute tulee sisältää vähintään yksi numero.',
        'symbols' => 'Kentän :attribute arvon tulee sisältää vähintään yksi symboli.',
        'uncompromised' => 'Annettu :attribute on ilmestynyt tietovuotossa. Valitse toinen :attribute.',
    ],
    'present' => 'Attribuuttikentän on oltava läsnä.',
    'prohibited' => 'Kenttä :attribute on kielletty.',
    'prohibited_if' => 'Kentän :attribute arvo on kielletty, kun :other on :value.',
    'prohibited_unless' => 'Kenttä :attribute on kielletty, paitsi jos :other on :values.',
    'prohibits' => 'Attribuutti-kenttä estää :other olemasta läsnä.',
    'regex' => 'Määritteen :attribute muoto on virheellinen.',
    'required' => 'Kentän :attribute arvo on pakollinen.',
    'required_array_keys' => 'Attribuuttikentän on sisällettävä merkinnät: :values.',
    'required_if' => 'Kentän :attribute arvo vaaditaan, kun :other on :value.',
    'required_unless' => 'Kentän :attribute arvo on pakollinen, paitsi jos :other on arvoissa :values.',
    'required_with' => 'Määritekenttä :attribute vaaditaan kun arvo :values on läsnä.',
    'required_with_all' => 'Määritekenttä :attribute vaaditaan kun arvot ovat läsnä.',
    'required_without' => 'Määritekenttä :attribute vaaditaan kun arvo :values ei ole läsnä.',
    'required_without_all' => 'Määritekenttä :attribute vaaditaan kun mitään arvoista ei ole.',
    'same' => 'Kentän :attribute ja :other tulee täsmätä.',
    'size' => [
        'array' => 'Kentän :attribute tulee sisältää :size kohteita.',
        'file' => 'Kentän :attribute arvon on oltava kokoa :size kilobittiä.',
        'numeric' => 'Kentän :attribute arvon on oltava :size.',
        'string' => 'Kentän :attribute arvon on oltava kokoa :size merkkiä.',
    ],
    'starts_with' => 'Kentän :attribute tulee alkaa jollakin seuraavista: :values.',
    'string' => 'Kentän :attribute arvon on oltava merkkijono.',
    'timezone' => 'Kentän :attribute arvon on oltava kelvollinen aikavyöhyke.',
    'unique' => 'Kentän :attribute arvo on jo käytössä.',
    'uploaded' => 'Kentän :attribute lataaminen epäonnistui.',
    'url' => 'Kentän :attribute arvon on oltava kelvollinen URL.',
    'uuid' => 'Kentän :attribute arvon on oltava kelvollinen UUID.',

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
            'rule-name' => 'räätälö-viesti',
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
