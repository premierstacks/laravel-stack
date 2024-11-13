<?php

/**
 * @author Tomáš Chochola <chocholatom1997@gmail.com>
 * @copyright © 2024–Present Tomáš Chochola <chocholatom1997@gmail.com>. All rights reserved.
 *
 * @license
 *
 * This software is proprietary and licensed under specific terms set by its owner.
 * Any form of access, use, or distribution requires a valid and active license.
 * For full licensing terms, refer to the LICENSE.md file accompanying this software.
 *
 * @see {@link https://premierstacks.com} Website
 * @see {@link https://github.com/tomchochola} GitHub Personal
 * @see {@link https://github.com/premierstacks} GitHub Organization
 * @see {@link https://github.com/sponsors/tomchochola} GitHub Sponsors
 */

declare(strict_types=1);

namespace Premierstacks\LaravelStack\Validation\Rules;

use Illuminate\Validation\Validator;

class PostCodeRule extends ValidationRule
{
    /**
     * @var array<string, ?string>
     */
    public static array $patterns = [
        'AC' => '/^(?:ASCN 1ZZ)$/i',
        'AD' => '/^(?:AD[1-7]0\d)$/i',
        'AE' => null,
        'AF' => '/^(?:\d{4})$/i',
        'AG' => null,
        'AI' => '/^(?:(?:AI-)?2640)$/i',
        'AL' => '/^(?:\d{4})$/i',
        'AM' => '/^(?:(?:37)?\d{4})$/i',
        'AO' => null,
        'AQ' => null,
        'AR' => '/^(?:((?:[A-HJ-NP-Z])?\d{4})([A-Z]{3})?)$/i',
        'AS' => '/^(?:(96799)(?:[ \-](\d{4}))?)$/i',
        'AT' => '/^(?:\d{4})$/i',
        'AU' => '/^(?:\d{4})$/i',
        'AW' => null,
        'AX' => '/^(?:22\d{3})$/i',
        'AZ' => '/^(?:\d{4})$/i',
        'BA' => '/^(?:\d{5})$/i',
        'BB' => '/^(?:BB\d{5})$/i',
        'BD' => '/^(?:\d{4})$/i',
        'BE' => '/^(?:\d{4})$/i',
        'BF' => null,
        'BG' => '/^(?:\d{4})$/i',
        'BH' => '/^(?:(?:\d|1[0-2])\d{2})$/i',
        'BI' => null,
        'BJ' => null,
        'BL' => '/^(?:9[78][01]\d{2})$/i',
        'BM' => '/^(?:[A-Z]{2} ?[A-Z0-9]{2})$/i',
        'BN' => '/^(?:[A-Z]{2} ?\d{4})$/i',
        'BO' => null,
        'BQ' => null,
        'BR' => '/^(?:\d{5}-?\d{3})$/i',
        'BS' => null,
        'BT' => '/^(?:\d{5})$/i',
        'BV' => null,
        'BW' => null,
        'BY' => '/^(?:\d{6})$/i',
        'BZ' => null,
        'CA' => '/^(?:[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJ-NPRSTV-Z] ?\d[ABCEGHJ-NPRSTV-Z]\d)$/i',
        'CC' => '/^(?:6799)$/i',
        'CD' => null,
        'CF' => null,
        'CG' => null,
        'CH' => '/^(?:\d{4})$/i',
        'CI' => null,
        'CK' => null,
        'CL' => '/^(?:\d{7})$/i',
        'CM' => null,
        'CN' => '/^(?:\d{6})$/i',
        'CO' => '/^(?:\d{6})$/i',
        'CR' => '/^(?:\d{4,5}|\d{3}-\d{4})$/i',
        'CU' => '/^(?:\d{5})$/i',
        'CV' => '/^(?:\d{4})$/i',
        'CW' => null,
        'CX' => '/^(?:6798)$/i',
        'CY' => '/^(?:\d{4})$/i',
        'CZ' => '/^(?:\d{3} ?\d{2})$/i',
        'DE' => '/^(?:\d{5})$/i',
        'DJ' => null,
        'DK' => '/^(?:\d{4})$/i',
        'DM' => null,
        'DO' => '/^(?:\d{5})$/i',
        'DZ' => '/^(?:\d{5})$/i',
        'EC' => '/^(?:\d{6})$/i',
        'EE' => '/^(?:\d{5})$/i',
        'EG' => '/^(?:\d{5})$/i',
        'EH' => '/^(?:\d{5})$/i',
        'ER' => null,
        'ES' => '/^(?:\d{5})$/i',
        'ET' => '/^(?:\d{4})$/i',
        'FI' => '/^(?:\d{5})$/i',
        'FJ' => null,
        'FK' => '/^(?:FIQQ 1ZZ)$/i',
        'FM' => '/^(?:(9694[1-4])(?:[ \-](\d{4}))?)$/i',
        'FO' => '/^(?:\d{3})$/i',
        'FR' => '/^(?:\d{2} ?\d{3})$/i',
        'GA' => null,
        'GB' => '/^(?:GIR ?0AA|(?:(?:AB|AL|B|BA|BB|BD|BF|BH|BL|BN|BR|BS|BT|BX|CA|CB|CF|CH|CM|CO|CR|CT|CV|CW|DA|DD|DE|DG|DH|DL|DN|DT|DY|E|EC|EH|EN|EX|FK|FY|G|GL|GY|GU|HA|HD|HG|HP|HR|HS|HU|HX|IG|IM|IP|IV|JE|KA|KT|KW|KY|L|LA|LD|LE|LL|LN|LS|LU|M|ME|MK|ML|N|NE|NG|NN|NP|NR|NW|OL|OX|PA|PE|PH|PL|PO|PR|RG|RH|RM|S|SA|SE|SG|SK|SL|SM|SN|SO|SP|SR|SS|ST|SW|SY|TA|TD|TF|TN|TQ|TR|TS|TW|UB|W|WA|WC|WD|WF|WN|WR|WS|WV|YO|ZE)(?:\d[\dA-Z]? ?\d[ABD-HJLN-UW-Z]{2}))|BFPO ?\d{1,4})$/i',
        'GD' => null,
        'GE' => '/^(?:\d{4})$/i',
        'GF' => '/^(?:9[78]3\d{2})$/i',
        'GG' => '/^(?:GY\d[\dA-Z]? ?\d[ABD-HJLN-UW-Z]{2})$/i',
        'GH' => null,
        'GI' => '/^(?:GX11 1AA)$/i',
        'GL' => '/^(?:39\d{2})$/i',
        'GM' => null,
        'GN' => '/^(?:\d{3})$/i',
        'GP' => '/^(?:9[78][01]\d{2})$/i',
        'GQ' => null,
        'GR' => '/^(?:\d{3} ?\d{2})$/i',
        'GS' => '/^(?:SIQQ 1ZZ)$/i',
        'GT' => '/^(?:\d{5})$/i',
        'GU' => '/^(?:(969(?:[12]\d|3[12]))(?:[ \-](\d{4}))?)$/i',
        'GW' => '/^(?:\d{4})$/i',
        'GY' => null,
        'HK' => null,
        'HM' => '/^(?:\d{4})$/i',
        'HN' => '/^(?:\d{5})$/i',
        'HR' => '/^(?:\d{5})$/i',
        'HT' => '/^(?:\d{4})$/i',
        'HU' => '/^(?:\d{4})$/i',
        'ID' => '/^(?:\d{5})$/i',
        'IE' => '/^(?:[\dA-Z]{3} ?[\dA-Z]{4})$/i',
        'IL' => '/^(?:\d{5}(?:\d{2})?)$/i',
        'IM' => '/^(?:IM\d[\dA-Z]? ?\d[ABD-HJLN-UW-Z]{2})$/i',
        'IN' => '/^(?:\d{6})$/i',
        'IO' => '/^(?:BBND 1ZZ)$/i',
        'IQ' => '/^(?:\d{5})$/i',
        'IR' => '/^(?:\d{5}-?\d{5})$/i',
        'IS' => '/^(?:\d{3})$/i',
        'IT' => '/^(?:\d{5})$/i',
        'JE' => '/^(?:JE\d[\dA-Z]? ?\d[ABD-HJLN-UW-Z]{2})$/i',
        'JM' => null,
        'JO' => '/^(?:\d{5})$/i',
        'JP' => '/^(?:\d{3}-?\d{4})$/i',
        'KE' => '/^(?:\d{5})$/i',
        'KG' => '/^(?:\d{6})$/i',
        'KH' => '/^(?:\d{5,6})$/i',
        'KI' => null,
        'KM' => null,
        'KN' => null,
        'KP' => null,
        'KR' => '/^(?:\d{5})$/i',
        'KW' => '/^(?:\d{5})$/i',
        'KY' => '/^(?:KY\d-\d{4})$/i',
        'KZ' => '/^(?:\d{6})$/i',
        'LA' => '/^(?:\d{5})$/i',
        'LB' => '/^(?:(?:\d{4})(?: ?(?:\d{4}))?)$/i',
        'LC' => null,
        'LI' => '/^(?:948[5-9]|949[0-8])$/i',
        'LK' => '/^(?:\d{5})$/i',
        'LR' => '/^(?:\d{4})$/i',
        'LS' => '/^(?:\d{3})$/i',
        'LT' => '/^(?:\d{5})$/i',
        'LU' => '/^(?:\d{4})$/i',
        'LV' => '/^(?:LV-\d{4})$/i',
        'LY' => null,
        'MA' => '/^(?:\d{5})$/i',
        'MC' => '/^(?:980\d{2})$/i',
        'MD' => '/^(?:\d{4})$/i',
        'ME' => '/^(?:8\d{4})$/i',
        'MF' => '/^(?:9[78][01]\d{2})$/i',
        'MG' => '/^(?:\d{3})$/i',
        'MH' => '/^(?:(969[67]\d)(?:[ \-](\d{4}))?)$/i',
        'MK' => '/^(?:\d{4})$/i',
        'ML' => null,
        'MM' => '/^(?:\d{5})$/i',
        'MN' => '/^(?:\d{5})$/i',
        'MO' => null,
        'MP' => '/^(?:(9695[012])(?:[ \-](\d{4}))?)$/i',
        'MQ' => '/^(?:9[78]2\d{2})$/i',
        'MR' => null,
        'MS' => null,
        'MT' => '/^(?:[A-Z]{3} ?\d{2,4})$/i',
        'MU' => '/^(?:\d{3}(?:\d{2}|[A-Z]{2}\d{3}))$/i',
        'MV' => '/^(?:\d{5})$/i',
        'MW' => null,
        'MX' => '/^(?:\d{5})$/i',
        'MY' => '/^(?:\d{5})$/i',
        'MZ' => '/^(?:\d{4})$/i',
        'NA' => '/^(?:\d{5})$/i',
        'NC' => '/^(?:988\d{2})$/i',
        'NE' => '/^(?:\d{4})$/i',
        'NF' => '/^(?:2899)$/i',
        'NG' => '/^(?:\d{6})$/i',
        'NI' => '/^(?:\d{5})$/i',
        'NL' => '/^(?:\d{4} ?[A-Z]{2})$/i',
        'NO' => '/^(?:\d{4})$/i',
        'NP' => '/^(?:\d{5})$/i',
        'NR' => null,
        'NU' => null,
        'NZ' => '/^(?:\d{4})$/i',
        'OM' => '/^(?:(?:PC )?\d{3})$/i',
        'PA' => null,
        'PE' => '/^(?:(?:LIMA \d{1,2}|CALLAO 0?\d)|[0-2]\d{4})$/i',
        'PF' => '/^(?:987\d{2})$/i',
        'PG' => '/^(?:\d{3})$/i',
        'PH' => '/^(?:\d{4})$/i',
        'PK' => '/^(?:\d{5})$/i',
        'PL' => '/^(?:\d{2}-\d{3})$/i',
        'PM' => '/^(?:9[78]5\d{2})$/i',
        'PN' => '/^(?:PCRN 1ZZ)$/i',
        'PR' => '/^(?:(00[679]\d{2})(?:[ \-](\d{4}))?)$/i',
        'PS' => null,
        'PT' => '/^(?:\d{4}-\d{3})$/i',
        'PW' => '/^(?:(969(?:39|40))(?:[ \-](\d{4}))?)$/i',
        'PY' => '/^(?:\d{4})$/i',
        'QA' => null,
        'RE' => '/^(?:9[78]4\d{2})$/i',
        'RO' => '/^(?:\d{6})$/i',
        'RS' => '/^(?:\d{5,6})$/i',
        'RU' => '/^(?:\d{6})$/i',
        'RW' => null,
        'SA' => '/^(?:\d{5})$/i',
        'SB' => null,
        'SC' => null,
        'SD' => '/^(?:\d{5})$/i',
        'SE' => '/^(?:\d{3} ?\d{2})$/i',
        'SG' => '/^(?:\d{6})$/i',
        'SH' => '/^(?:(?:ASCN|STHL) 1ZZ)$/i',
        'SI' => '/^(?:\d{4})$/i',
        'SJ' => '/^(?:\d{4})$/i',
        'SK' => '/^(?:\d{3} ?\d{2})$/i',
        'SL' => null,
        'SM' => '/^(?:4789\d)$/i',
        'SN' => '/^(?:\d{5})$/i',
        'SO' => '/^(?:[A-Z]{2} ?\d{5})$/i',
        'SR' => null,
        'SS' => null,
        'ST' => null,
        'SV' => '/^(?:CP [1-3][1-7][0-2]\d)$/i',
        'SX' => null,
        'SY' => null,
        'SZ' => '/^(?:[HLMS]\d{3})$/i',
        'TA' => '/^(?:TDCU 1ZZ)$/i',
        'TC' => '/^(?:TKCA 1ZZ)$/i',
        'TD' => null,
        'TF' => null,
        'TG' => null,
        'TH' => '/^(?:\d{5})$/i',
        'TJ' => '/^(?:\d{6})$/i',
        'TK' => null,
        'TL' => null,
        'TM' => '/^(?:\d{6})$/i',
        'TN' => '/^(?:\d{4})$/i',
        'TO' => null,
        'TR' => '/^(?:\d{5})$/i',
        'TT' => null,
        'TV' => null,
        'TW' => '/^(?:\d{3}(?:\d{2,3})?)$/i',
        'TZ' => '/^(?:\d{4,5})$/i',
        'UA' => '/^(?:\d{5})$/i',
        'UG' => null,
        'UM' => '/^(?:96898)$/i',
        'US' => '/^(?:(\d{5})(?:[ \-](\d{4}))?)$/i',
        'UY' => '/^(?:\d{5})$/i',
        'UZ' => '/^(?:\d{6})$/i',
        'VA' => '/^(?:00120)$/i',
        'VC' => '/^(?:VC\d{4})$/i',
        'VE' => '/^(?:\d{4})$/i',
        'VG' => '/^(?:VG\d{4})$/i',
        'VI' => '/^(?:(008(?:(?:[0-4]\d)|(?:5[01])))(?:[ \-](\d{4}))?)$/i',
        'VN' => '/^(?:\d{5}\d?)$/i',
        'VU' => null,
        'WF' => '/^(?:986\d{2})$/i',
        'WS' => null,
        'XK' => '/^(?:[1-7]\d{4})$/i',
        'YE' => null,
        'YT' => '/^(?:976\d{2})$/i',
        'ZA' => '/^(?:\d{4})$/i',
        'ZM' => '/^(?:\d{5})$/i',
        'ZW' => null,
    ];

    public function __construct(protected string $countryCode)
    {
        parent::__construct();

        $this->countryCode = \mb_strtoupper($this->countryCode);
    }

    #[\Override]
    public function fail(string $attribute, mixed $value, Validator $validator, \Closure $fail): void
    {
        $validator->addFailure($attribute, 'Regex');
    }

    #[\Override]
    public function passes(string $attribute, mixed $value, Validator $validator, \Closure $fail): array|bool|null
    {
        if (!\is_string($value)) {
            return false;
        }

        if ($this->countryCode === '') {
            return true;
        }

        $pattern = static::$patterns[$this->countryCode] ?? null;

        if ($pattern === null) {
            return true;
        }

        return !(\preg_match($pattern, $value) !== 1);
    }
}
