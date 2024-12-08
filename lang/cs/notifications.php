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
            'subject' => 'Potvrzení akce ve vašem účtu',
            'line_1_title' => 'Obsah:',
            'line_1' => 'Tento e-mail byl odeslán jako součást procesu zabezpečení vašeho účtu. Aby bylo možné pokračovat ve vámi požadované akci, je nutné potvrdit její platnost.',
            'line_2_title' => 'Co se děje:',
            'line_2' => 'Potvrzujete akci - :action',
            'line_3_title' => 'Kontrolní symboly:',
            'line_4' => 'Klikněte na tlačítko níže a postupujte podle pokynů na stránce. Tlačítko vás přesměruje na stránku, kde můžete akci bezpečně potvrdit.',
            'line_expiration_title' => 'Upozornění:',
            'line_expiration' => 'Platnost odkazu je časově omezená. Pokud akci nepotvrdíte včas, bude nutné zahájit proces znovu.',
            'line_not_you_title' => 'Nejste to vy?',
            'line_not_you' => 'Pokud jste tuto akci nežádali, jednoduše tento e-mail ignorujte. V případě pochybností nás prosím ihned kontaktujte.',
            'button' => 'Potvrdit akci',
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
