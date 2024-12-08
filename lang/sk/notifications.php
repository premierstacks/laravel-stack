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
            'subject' => 'Potvrdenie akcie vo vašom účte',
            'line_1_title' => 'Obsah:',
            'line_1' => 'Tento e-mail bol odoslaný ako súčasť procesu zabezpečenia vášho účtu. Aby bolo možné pokračovať v požadovanej akcii, je potrebné potvrdiť jej platnosť.',
            'line_2_title' => 'Čo sa deje:',
            'line_2' => 'Potvrdzujete akciu - :action',
            'line_4_title' => 'Ako postupovať:',
            'line_4' => 'Kliknite na tlačidlo nižšie a postupujte podľa pokynov na stránke. Tlačidlo vás presmeruje na stránku, kde môžete akciu bezpečne potvrdiť.',
            'line_expiration_title' => 'Upozornenie:',
            'line_expiration' => 'Platnosť odkazu je časovo obmedzená. Ak akciu nepotvrdíte včas, bude potrebné proces začať odznova.',
            'line_not_you_title' => 'Nie ste to vy?',
            'line_not_you' => 'Ak ste túto akciu nepožadovali, jednoducho tento e-mail ignorujte. V prípade pochybností nás prosím okamžite kontaktujte.',
            'button' => 'Potvrdiť akciu',
        ],
        'code' => [
            'subject' => 'Požiadavka na manuálne autorizáciu akcie',
            'line_1' => 'Tento email bol odoslaný ako súčasť bezpečnostného procesu pre manuálnu autorizáciu akcie vo Vašom účte.',
            'line_2' => 'Nižšie nájdete kód, ktorý je treba zadať do aplikácie pre dokončenie procesu autorizácie.',
            'line_3' => 'Chystáte sa autorizovať akciu: :action',
            'line_4' => 'Párovací kód: :pair',
            'line_expiration' => 'Upozorňujeme, že platnosť tohto kódu čoskoro vyprší.',
            'line_not_you' => 'Ak ste túto akciu neiniciovali, ignorujte tento email alebo nás informujte.',
            'button' => 'Zobraziť autorizačný kód',
        ],
    ],
];
