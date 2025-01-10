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

use Premierstacks\PhpCsFixerStack\ConfigFactory;
use Premierstacks\PhpCsFixerStack\Configs\Premierstacks;
use Premierstacks\PhpCsFixerStack\FinderFactory;

return ConfigFactory::make(FinderFactory::make()->in(__DIR__), Premierstacks::rules());
