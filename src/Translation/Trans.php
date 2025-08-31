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

namespace Premierstacks\LaravelStack\Translation;

use Illuminate\Translation\Translator;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\PhpStack\Debug\Errorf;
use Premierstacks\PhpStack\Mixed\Assert;

class Trans
{
    use InjectTrait;

    public function __construct(public Translator $translator) {}

    /**
     * @param array<string, string> $replace
     *
     * @return array<array-key, mixed>
     */
    public function array(string $key, array $replace = [], string|null $locale = null, bool $fallback = true): array
    {
        return Assert::array($this->get($key, $replace, $locale, $fallback));
    }

    /**
     * @param array<string, string> $replace
     *
     * @return array<array-key, mixed>|string
     */
    public function get(string $key, array $replace = [], string|null $locale = null, bool $fallback = true): array|string
    {
        if (!$this->translator->has($key, $locale, $fallback)) {
            throw new \OutOfRangeException(Errorf::invalidTargetKey($key, $this->translator));
        }

        return $this->translator->get($key, $replace, $locale, $fallback);
    }

    public function has(string $key, string|null $locale = null, bool $fallback = true): bool
    {
        return $this->translator->has($key, $locale, $fallback);
    }

    /**
     * @param array<string, string> $replace
     */
    public function string(string $key, array $replace = [], string|null $locale = null, bool $fallback = true): string
    {
        return Assert::string($this->get($key, $replace, $locale, $fallback));
    }
}
