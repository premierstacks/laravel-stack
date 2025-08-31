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

namespace Premierstacks\LaravelStack\Validation\Rules;

use Illuminate\Validation\Validator;
use Premierstacks\LaravelStack\Container\Resolve;
use Premierstacks\PhpStack\Encoding\Json;
use Premierstacks\PhpStack\Mixed\Assert;

class RecaptchaRule extends ValidationRule
{
    public function __construct(protected string $secret)
    {
        parent::__construct();
    }

    #[\Override]
    public function passes(string $attribute, mixed $value, Validator $validator, \Closure $fail): array|bool|null
    {
        $response = Assert::array(Json::decode(
            Resolve::httpClientFactory()->createPendingRequest()->acceptJson()->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $this->secret,
                'response' => $value,
            ])->throw()->body(),
            true,
        ));

        return !(!isset($response['success']) || $response['success'] !== true);
    }
}
