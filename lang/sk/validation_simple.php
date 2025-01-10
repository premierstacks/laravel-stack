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
    'accepted' => 'Pole :attribute musí byť akceptované.',
    'accepted_if' => 'Pole :attribute musí spĺňať určité podmienky, aby bolo akceptované.',
    'active_url' => 'Pole :attribute musí byť platnou URL adresou.',
    'after' => 'Pole :attribute musí byť dátum po určitom dátume.',
    'after_or_equal' => 'Pole :attribute musí byť dátum po určitom dátume alebo sa mu musí rovnať.',
    'alpha' => 'Pole :attribute musí obsahovať iba písmená.',
    'alpha_dash' => 'Pole :attribute musí obsahovať len písmená, číslice, pomlčky a podčiarkovníky.',
    'alpha_num' => 'Pole :attribute musí obsahovať len písmená a čísla.',
    'array' => 'Pole :attribute musí byť pole.',
    'ascii' => 'Pole :attribute musí obsahovať len jednobajtové alfanumerické znaky a symboly.',
    'before' => 'Pole :attribute musí byť dátum pred konkrétnym dátumom.',
    'before_or_equal' => 'Pole :attribute musí byť dátum pred konkrétnym dátumom alebo sa mu musí rovnať.',
    'between' => [
        'array' => 'Pole :attribute musí mať určitý rozsah položiek.',
        'file' => 'Pole :attribute musí byť v určitom rozsahu veľkosti.',
        'numeric' => 'Pole :attribute musí byť v určitom rozsahu.',
        'string' => 'Pole :attribute musí mať určitý rozsah znakov.',
    ],
    'boolean' => 'Pole :attribute musí byť true alebo false.',
    'can' => 'Pole :attribute obsahuje nepovolenú hodnotu.',
    'confirmed' => 'Potvrdenie :attribute poľa sa nezhoduje.',
    'current_password' => 'Heslo je nesprávne.',
    'date' => 'Pole :attribute musí byť platný dátum.',
    'date_equals' => 'Pole :attribute sa musí zhodovať s konkrétnym dátumom.',
    'date_format' => 'Pole :attribute musí zodpovedať určitému formátu.',
    'decimal' => 'Pole :attribute musí mať určitý počet desatinných miest.',
    'declined' => 'Pole :attribute musí byť odmietnuté.',
    'declined_if' => 'Pole :attribute musí byť za určitých podmienok odmietnuté.',
    'different' => 'Pole :attribute sa musí líšiť od iného poľa.',
    'digits' => 'Pole :attribute musí mať určitý počet číslic.',
    'digits_between' => 'Pole :attribute musí mať číslice v určitom rozsahu.',
    'dimensions' => 'Pole :attribute má neplatné rozmery obrázka.',
    'distinct' => 'Pole :attribute má duplicitnú hodnotu.',
    'doesnt_end_with' => 'Pole :attribute nesmie končiť určitými hodnotami.',
    'doesnt_start_with' => 'Pole :attribute nesmie začínať konkrétnymi hodnotami.',
    'email' => 'Pole :attribute musí byť platná e-mailová adresa.',
    'ends_with' => 'Pole :attribute musí končiť konkrétnymi hodnotami.',
    'enum' => 'Pole :attribute musí byť jednou z povolených hodnôt.',
    'exists' => 'Vybraný :attribute je neplatný.',
    'file' => 'Pole :attribute musí byť súbor.',
    'filled' => 'Pole :attribute musí mať hodnotu.',
    'gt' => [
        'array' => 'Pole :attribute musí mať viac ako určitý počet položiek.',
        'file' => 'Pole :attribute musí byť väčšie ako určitá veľkosť.',
        'numeric' => 'Pole :attribute musí byť väčšie ako určitá hodnota.',
        'string' => 'Pole :attribute musí mať viac ako určitý počet znakov.',
    ],
    'gte' => [
        'array' => 'Pole :attribute musí mať určitý alebo väčší počet položiek.',
        'file' => 'Pole :attribute musí mať aspoň určitú veľkosť.',
        'numeric' => 'Pole :attribute musí mať aspoň určitú hodnotu.',
        'string' => 'Pole :attribute musí mať aspoň určitý počet znakov.',
    ],
    'image' => 'Pole :attribute musí byť obrázok.',
    'in' => 'Vybraný :attribute je neplatný.',
    'in_array' => 'Pole :attribute sa musí nachádzať v inom poli.',
    'integer' => 'Pole :attribute musí byť celé číslo.',
    'ip' => 'Pole :attribute musí byť platná IP adresa.',
    'ipv4' => 'Pole :attribute musí byť platná IPv4 adresa.',
    'ipv6' => 'Pole :attribute musí byť platná IPv6 adresa.',
    'json' => 'Pole :attribute musí byť platný reťazec JSON.',
    'lowercase' => 'Pole :attribute musí byť napísané malými písmenami.',
    'lt' => [
        'array' => 'Pole :attribute musí mať menej ako určitý počet položiek.',
        'file' => 'Pole :attribute musí byť menšie ako určitá veľkosť.',
        'numeric' => 'Pole :attribute musí byť menšie ako určitá hodnota.',
        'string' => 'Pole :attribute musí mať menej ako určitý počet znakov.',
    ],
    'lte' => [
        'array' => 'Pole :attribute nesmie mať viac ako určitý počet položiek.',
        'file' => 'Pole :attribute musí mať najviac určitú veľkosť.',
        'numeric' => 'Pole :attribute nesmie mať viac ako určitú hodnotu.',
        'string' => 'Pole :attribute nesmie mať viac ako určitý počet znakov.',
    ],
    'mac_address' => 'Pole :attribute musí byť platná MAC adresa.',
    'max' => [
        'array' => 'Pole :attribute nesmie mať viac ako určitý počet položiek.',
        'file' => 'Pole :attribute nesmie byť väčšie ako určitá veľkosť.',
        'numeric' => 'Pole :attribute nesmie byť väčšie ako určitá hodnota.',
        'string' => 'Pole :attribute nesmie byť dlhšie ako určitý počet znakov.',
    ],
    'max_digits' => 'Pole :attribute nesmie mať viac ako určitý počet číslic.',
    'mimes' => 'Pole :attribute musí byť určitý typ súboru.',
    'mimetypes' => 'Pole :attribute musí byť určitý typ súboru.',
    'min' => [
        'array' => 'Pole :attribute musí mať aspoň určitý počet položiek.',
        'file' => 'Pole :attribute musí mať aspoň určitú veľkosť.',
        'numeric' => 'Pole :attribute musí mať aspoň určitú hodnotu.',
        'string' => 'Pole :attribute musí mať aspoň určitý počet znakov.',
    ],
    'min_digits' => 'Pole :attribute musí mať aspoň určitý počet číslic.',
    'missing' => 'Pole :attribute musí chýbať.',
    'missing_if' => 'Pole :attribute musí za určitých podmienok chýbať.',
    'missing_unless' => 'Pole :attribute musí chýbať, ak nie sú splnené určité podmienky.',
    'missing_with' => 'Pole :attribute musí chýbať, ak sú prítomné určité polia.',
    'missing_with_all' => 'Pole :attribute musí chýbať, ak sú prítomné určité polia.',
    'multiple_of' => 'Pole :attribute musí byť násobkom určitej hodnoty.',
    'not_in' => 'Vybraný :attribute je neplatný.',
    'not_regex' => 'Formát poľa :attribute je neplatný.',
    'numeric' => 'Pole :attribute musí byť číslo.',
    'password' => [
        'letters' => 'Pole :attribute musí obsahovať aspoň jedno písmeno.',
        'mixed' => 'Pole :attribute musí obsahovať aspoň jedno veľké a jedno malé písmeno.',
        'numbers' => 'Pole :attribute musí obsahovať aspoň jedno číslo.',
        'symbols' => 'Pole :attribute musí obsahovať aspoň jeden symbol.',
        'uncompromised' => 'Daný :attribute sa objavil v úniku údajov. Prosím, vyberte iný :attribute.',
    ],
    'present' => 'Pole :attribute musí byť prítomné.',
    'prohibited' => 'Pole :attribute nesmie byť prítomné.',
    'prohibited_if' => 'Pole :attribute nesmie byť za určitých podmienok prítomné.',
    'prohibited_unless' => 'Pole :attribute nesmie byť prítomné, ak nie sú splnené určité podmienky.',
    'prohibits' => 'Pole :attribute nesmie byť prítomné za určitých podmienok.',
    'regex' => 'Formát poľa :attribute je neplatný.',
    'required' => 'Pole :attribute je povinné.',
    'required_array_keys' => 'Pole :attribute musí obsahovať položky pre určité hodnoty.',
    'required_if' => 'Pole :attribute je za určitých podmienok povinné.',
    'required_if_accepted' => 'Pole :attribute je povinné pri splnení určitých podmienok.',
    'required_unless' => 'Pole :attribute je povinné, ak nie sú splnené určité podmienky.',
    'required_with' => 'Pole :attribute je povinné, ak sú prítomné určité polia.',
    'required_with_all' => 'Pole :attribute je povinné, ak sú prítomné určité polia.',
    'required_without' => 'Pole :attribute je povinné, ak nie sú prítomné určité polia.',
    'required_without_all' => 'Pole :attribute je povinné, ak nie je prítomné žiadne z určitých polí.',
    'same' => 'Pole :attribute sa musí zhodovať s iným poľom.',
    'size' => [
        'array' => 'Pole :attribute musí mať určitý počet položiek.',
        'file' => 'Pole :attribute musí mať určitú veľkosť.',
        'numeric' => 'Pole :attribute musí mať určitú hodnotu.',
        'string' => 'Pole :attribute musí mať určitý počet znakov.',
    ],
    'starts_with' => 'Pole :attribute musí začínať určitými hodnotami.',
    'string' => 'Pole :attribute musí byť reťazec.',
    'timezone' => 'Pole :attribute musí byť platné časové pásmo.',
    'unique' => 'Pole :attribute musí byť jedinečné.',
    'uploaded' => 'Pole :attribute sa nepodarilo nahrať.',
    'uppercase' => 'Pole :attribute musí byť písané veľkými písmenami.',
    'url' => 'Pole :attribute musí byť platná adresa URL.',
    'ulid' => 'Pole :attribute musí byť platné ULID.',
    'uuid' => 'Pole :attribute musí byť platné UUID.',

    'list' => 'Pole :attribute musí byť zoznam.',
    'map' => 'Pole :attribute musí byť mapa.',
    'prohibited_with' => 'Pole :attribute nesmie byť prítomné za určitých podmienok.',
    'prohibited_with_all' => 'Pole :attribute nesmie byť prítomné za určitých podmienok.',
    'prohibited_without' => 'Pole :attribute nesmie byť prítomné za určitých podmienok.',
    'prohibited_without_all' => 'Pole :attribute nesmie byť prítomné za určitých podmienok.',
    'throttled' => 'Pred opätovným pokusom počkajte.',
    'invalid' => 'Vybraný :attribute je neplatný.',
];
