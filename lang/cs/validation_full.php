<?php

/**
 * @author Tomáš Chochola <chocholatom1997@gmail.com>
 * @copyright © 2025, Tomáš Chochola <chocholatom1997@gmail.com>. Some rights reserved.
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomchochola} GitHub Personal
 * @see {@link https://github.com/premierstacks} GitHub Organization
 * @see {@link https://github.com/sponsors/tomchochola} GitHub Sponsors
 */

declare(strict_types=1);

return [
    'accepted' => 'Pole :attribute musí být akceptováno.',
    'accepted_if' => 'Pole :attribute musí být akceptováno, když :other je :value.',
    'active_url' => 'Pole :attribute musí být platná adresa URL.',
    'after' => 'Pole :attribute musí být datum po :date.',
    'after_or_equal' => 'Pole :attribute musí být datum následující po :date nebo se mu rovnat.',
    'alpha' => 'Pole :attribute musí obsahovat pouze písmena.',
    'alpha_dash' => 'Pole :attribute musí obsahovat pouze písmena, číslice, pomlčky a podtržítka.',
    'alpha_num' => 'Pole :attribute musí obsahovat pouze písmena a číslice.',
    'array' => 'Pole :attribute musí být pole.',
    'ascii' => 'Pole :attribute musí obsahovat pouze jednobajtové alfanumerické znaky a symboly.',
    'before' => 'Pole :attribute musí být datum před :date.',
    'before_or_equal' => 'Pole :attribute musí být datum před nebo rovno :date.',
    'between' => [
        'array' => 'Pole :attribute musí mít položky mezi :min a :max.',
        'file' => 'Pole :attribute musí mít velikost mezi :min a :max kilobajty.',
        'numeric' => 'Pole :attribute musí mít hodnotu mezi :min a :max.',
        'string' => 'Pole :attribute musí být mezi :min a :max znaků.',
    ],
    'boolean' => 'Pole :attribute musí být true nebo false.',
    'can' => 'Pole :attribute obsahuje nepovolenou hodnotu.',
    'confirmed' => 'Potvrzení pole :attribute neodpovídá.',
    'current_password' => 'Heslo je nesprávné.',
    'date' => 'Pole :attribute musí být platné datum.',
    'date_equals' => 'Pole :attribute musí být datum rovné :date.',
    'date_format' => 'Pole :attribute musí odpovídat formátu :format.',
    'decimal' => 'Pole :attribute musí mít :desetinná místa.',
    'declined' => 'Pole :attribute musí být odmítnuto.',
    'declined_if' => 'Pole :attribute musí být odmítnuto, když :other je :value.',
    'different' => 'Pole :attribute a :other se musí lišit.',
    'digits' => 'Pole :attribute musí být :digits číslice.',
    'digits_between' => 'Pole :attribute musí být mezi :min a :max číslicemi.',
    'dimensions' => 'Pole :attribute má neplatné rozměry obrázku.',
    'distinct' => 'Pole :attribute má duplicitní hodnotu.',
    'doesnt_end_with' => 'Pole :attribute nesmí končit jedním z následujících údajů: :values',
    'doesnt_start_with' => 'Pole :attribute nesmí začínat jednou z následujících hodnot: :values.',
    'email' => 'Pole :attribute musí být platná e-mailová adresa.',
    'ends_with' => 'Pole :attribute musí končit jedním z následujících údajů: :values.',
    'enum' => 'Vybraný :attribute je neplatný.',
    'exists' => 'Vybraný :attribute je neplatný.',
    'file' => 'Pole :attribute musí být soubor.',
    'filled' => 'Pole :attribute musí mít hodnotu.',
    'gt' => [
        'array' => 'Pole :attribute musí mít více než :value položek.',
        'file' => 'Pole :attribute musí mít více než :value kilobajtů.',
        'numeric' => 'Pole :attribute musí být větší než :value.',
        'string' => 'Pole :attribute musí být větší než :value znaků.',
    ],
    'gte' => [
        'array' => 'Pole :attribute musí mít :value položek nebo více.',
        'file' => 'Pole :attribute musí být větší nebo rovno :value kilobajtů.',
        'numeric' => 'Pole :attribute musí být větší nebo rovno :value.',
        'string' => 'Pole :attribute musí být větší nebo rovno :value znaků.',
    ],
    'image' => 'Pole :attribute musí být obrázek.',
    'in' => 'Vybraný :attribute je neplatný.',
    'in_array' => 'Pole :attribute musí existovat v :other.',
    'integer' => 'Pole :attribute musí být celé číslo.',
    'ip' => 'Pole :attribute musí být platná IP adresa.',
    'ipv4' => 'Pole :attribute musí být platná IPv4 adresa.',
    'ipv6' => 'Pole :attribute musí být platná IPv6 adresa.',
    'json' => 'Pole :attribute musí být platný řetězec JSON.',
    'lowercase' => 'Pole :attribute musí být napsáno malými písmeny.',
    'lt' => [
        'array' => 'Pole :attribute musí mít méně než :value položek.',
        'file' => 'Pole :attribute musí mít méně než :value kilobajtů.',
        'numeric' => 'Pole :attribute musí být menší než :value.',
        'string' => 'Pole :attribute musí mít méně než :value znaků.',
    ],
    'lte' => [
        'array' => 'Pole :attribute nesmí mít více než :value položek.',
        'file' => 'Pole :attribute musí být menší nebo rovno :value kilobajtů.',
        'numeric' => 'Pole :attribute musí být menší nebo rovno :value.',
        'string' => 'Pole :attribute musí být menší nebo rovno :value znaků.',
    ],
    'mac_address' => 'Pole :attribute musí být platná MAC adresa.',
    'max' => [
        'array' => 'Pole :attribute nesmí mít více než :max položek.',
        'file' => 'Pole :attribute nesmí mít více než :max kilobajtů.',
        'numeric' => 'Pole :attribute nesmí být větší než :max.',
        'string' => 'Pole :attribute nesmí být větší než :max znaků.',
    ],
    'max_digits' => 'Pole :attribute nesmí mít více než :max číslic.',
    'mimes' => 'Pole :attribute musí být soubor typu: :values.',
    'mimetypes' => 'Pole :attribute musí být soubor typu: :values.',
    'min' => [
        'array' => 'Pole :attribute musí mít alespoň :min položek.',
        'file' => 'Pole :attribute musí mít alespoň :min kilobajtů.',
        'numeric' => 'Pole :attribute musí mít alespoň :min.',
        'string' => 'Pole :attribute musí mít alespoň :min znaků.',
    ],
    'min_digits' => 'Pole :attribute musí mít alespoň :min číslic.',
    'missing' => 'V poli :attribute musí chybět.',
    'missing_if' => 'Pole :attribute musí chybět, když :other je :value.',
    'missing_unless' => 'Pole :attribute musí chybět, pokud :other není :value.',
    'missing_with' => 'Pole :attribute musí chybět, pokud je :values.',
    'missing_with_all' => 'Pole :attribute musí chybět, když je přítomno :values.',
    'multiple_of' => 'Pole :attribute musí být násobkem :value.',
    'not_in' => 'Vybraný :attribute je neplatný.',
    'not_regex' => 'Formát pole :attribute je neplatný.',
    'numeric' => 'Pole :attribute musí být číslo.',
    'password' => [
        'letters' => 'Pole :attribute musí obsahovat alespoň jedno písmeno.',
        'mixed' => 'Pole :attribute musí obsahovat alespoň jedno velké a jedno malé písmeno.',
        'numbers' => 'Pole :attribute musí obsahovat alespoň jedno číslo.',
        'symbols' => 'Pole :attribute musí obsahovat alespoň jeden symbol.',
        'uncompromised' => 'Daný :attribute se objevil v úniku dat. Zvolte prosím jiný :attribute.',
    ],
    'present' => 'Pole :attribute musí být přítomno.',
    'prohibited' => 'Pole :attribute je zakázáno.',
    'prohibited_if' => 'Pole :attribute je zakázáno, když :other je :value.',
    'prohibited_unless' => 'Pole :attribute je zakázáno, pokud :other není v :values.',
    'prohibits' => 'Pole :attribute zakazuje přítomnost :other.',
    'regex' => 'Formát pole :attribute je neplatný.',
    'required' => 'Pole :attribute je povinné.',
    'required_array_keys' => 'Pole :attribute musí obsahovat položky pro: :values.',
    'required_if' => 'Pole :attribute je povinné, když :other je :value.',
    'required_if_accepted' => 'Pole :attribute je povinné, když :other je akceptováno.',
    'required_unless' => 'Pole :attribute je povinné, pokud :other není v :values.',
    'required_with' => 'Pole :attribute je povinné, pokud je přítomno :values.',
    'required_with_all' => 'Pole :attribute je povinné, pokud je přítomno :values.',
    'required_without' => 'Pole :attribute je povinné, když není přítomno :values.',
    'required_without_all' => 'Pole :attribute je povinné, pokud není přítomna žádná z :values.',
    'same' => 'Pole :attribute se musí shodovat s :other.',
    'size' => [
        'array' => 'Pole :attribute musí obsahovat položky :size.',
        'file' => 'Pole :attribute musí mít velikost :size kilobajtů.',
        'numeric' => 'Pole :attribute musí být :size.',
        'string' => 'Pole :attribute musí mít velikost :size znaků.',
    ],
    'starts_with' => 'Pole :attribute musí začínat jedním z následujících znaků: :values.',
    'string' => 'Pole :attribute musí být řetězec.',
    'timezone' => 'Pole :attribute musí být platné časové pásmo.',
    'unique' => 'Pole :attribute již bylo obsazeno.',
    'uploaded' => 'Pole :attribute se nepodařilo nahrát.',
    'uppercase' => 'V poli :attribute musí být velká písmena.',
    'url' => 'Pole :attribute musí být platná adresa URL.',
    'ulid' => 'Pole :attribute musí být platné ULID.',
    'uuid' => 'Pole :attribute musí být platné UUID.',

    'list' => 'Pole :attribute musí být seznam.',
    'map' => 'Pole :attribute musí být mapa.',
    'prohibited_with' => 'Pole :attribute je zakázáno, pokud je přítomno pole :values.',
    'prohibited_with_all' => 'Pole :attribute je zakázáno, když je přítomno pole :values.',
    'prohibited_without' => 'Pole :attribute je zakázáno, když není přítomno :values.',
    'prohibited_without_all' => 'Pole :attribute je zakázáno, pokud není přítomna žádná z :values.',
    'throttled' => 'Počkejte prosím, než se pokusíte o opakování.',
    'invalid' => 'Vybraný :attribute je neplatný.',
];
