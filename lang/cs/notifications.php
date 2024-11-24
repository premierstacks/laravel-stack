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

use Premierstacks\LaravelStack\Notifications\VerificationNotification;

return [
    VerificationNotification::class => [
        'token' => [
            'subject' => 'Požadavek na autorizaci akce',
            'line_1' => 'Tento email byl odeslán jako součást bezpečnostního procesu ověření pro pokračování ve vyžadované akci ve Vašem účtu.',
            'line_2' => 'Pro zobrazení detailů a potvrzení této akce, prosím, klikněte na níže uvedené tlačítko.',
            'line_3' => 'Chystáte se autorizovat akci: :action',
            'line_4' => 'Párovací kód: :pair',
            'line_expiration' => 'Upozorňujeme, že platnost tohoto odkazu brzy vyprší.',
            'line_not_you' => 'Pokud jste tuto akci neiniciovali, ignorujte tento email nebo nás informujte o této skutečnosti.',
            'button' => 'Zobrazit požadavek',
        ],
        'code' => [
            'subject' => 'Požadavek na manuální autorizaci akce',
            'line_1' => 'Tento email byl odeslán jako součást bezpečnostního procesu pro manuální autorizaci akce ve Vašem účtu.',
            'line_2' => 'Níže naleznete kód, který je třeba zadat do aplikace pro dokončení procesu autorizace.',
            'line_3' => 'Chystáte se autorizovat akci: :action',
            'line_4' => 'Párovací kód: :pair',
            'line_expiration' => 'Upozorňujeme, že platnost tohoto kódu brzy vyprší.',
            'line_not_you' => 'Pokud jste tuto akci neiniciovali, ignorujte tento email nebo nás informujte o této skutečnosti.',
            'button' => 'Zobrazit autorizační kód',
        ],
    ],
];
