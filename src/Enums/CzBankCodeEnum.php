<?php

/**
 * @author Tomáš Chochola <chocholatom1997@gmail.com>
 * @copyright © 2025 Tomáš Chochola <chocholatom1997@gmail.com>
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomchochola} GitHub Personal
 * @see {@link https://github.com/premierstacks} GitHub Organization
 * @see {@link https://github.com/sponsors/tomchochola} GitHub Sponsors
 */

declare(strict_types=1);

namespace Premierstacks\LaravelStack\Enums;

enum CzBankCodeEnum: string
{
    case cz0100 = '0100';

    case cz0300 = '0300';

    case cz0600 = '0600';

    case cz0710 = '0710';

    case cz0800 = '0800';

    case cz2010 = '2010';

    case cz2020 = '2020';

    case cz2060 = '2060';

    case cz2070 = '2070';

    case cz2100 = '2100';

    case cz2200 = '2200';

    case cz2220 = '2220';

    case cz2250 = '2250';

    case cz2260 = '2260';

    case cz2275 = '2275';

    case cz2600 = '2600';

    case cz2700 = '2700';

    case cz3030 = '3030';

    case cz3050 = '3050';

    case cz3060 = '3060';

    case cz3500 = '3500';

    case cz4000 = '4000';

    case cz4300 = '4300';

    case cz5500 = '5500';

    case cz5800 = '5800';

    case cz6000 = '6000';

    case cz6100 = '6100';

    case cz6200 = '6200';

    case cz6210 = '6210';

    case cz6300 = '6300';

    case cz6700 = '6700';

    case cz6800 = '6800';

    case cz7910 = '7910';

    case cz7950 = '7950';

    case cz7960 = '7960';

    case cz7970 = '7970';

    case cz7990 = '7990';

    case cz8030 = '8030';

    case cz8040 = '8040';

    case cz8060 = '8060';

    case cz8090 = '8090';

    case cz8150 = '8150';

    case cz8190 = '8190';

    case cz8198 = '8198';

    case cz8199 = '8199';

    case cz8200 = '8200';

    case cz8220 = '8220';

    case cz8230 = '8230';

    case cz8240 = '8240';

    case cz8250 = '8250';

    case cz8255 = '8255';

    case cz8265 = '8265';

    case cz8270 = '8270';

    case cz8280 = '8280';

    case cz8293 = '8293';

    case cz8299 = '8299';

    case cz8500 = '8500';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return \array_column(self::cases(), 'value');
    }
}
