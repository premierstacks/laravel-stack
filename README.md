# [Laravel Stack](https://github.com/premierstacks/laravel-stack) by [Tomáš Chochola](https://github.com/tomchochola)

The Laravel Stack is a robust, pre-configured foundation for scalable Laravel applications, featuring essential tools for code quality, authentication, validation, and security. With modular configurations and helper utilities, it supports streamlined workflows, ideal for both rapid prototyping and production-ready deployments.

## What is Premierstacks

[GitHub Organization → /premierstacks](https://github.com/premierstacks)

Premierstacks is a premier organization delivering a complete ecosystem of libraries, packages, and templates for full-stack web development. It provides end-to-end solutions for backend systems, APIs, and frontend interfaces built on PHP, Laravel, TypeScript, React, and Material Design 3.

Beyond code, Premierstacks focuses on creating a seamless development experience, offering support tools for planning, architecture, deployment, and long-term project maintenance. Each resource within the ecosystem is crafted with precision, adhering to strict quality standards, and designed to scale effortlessly.

From initial project planning and logical architecture to seamless development workflows and optimized production deployment, Premierstacks delivers tools engineered for excellence across every stage of the software lifecycle.

## Why Premierstacks

Premierstacks exists to solve the recurring challenges of modern software development: inconsistency, poor maintainability, and fragmented tooling. It offers a complete ecosystem of libraries, templates, and supporting tools, designed to streamline workflows, enforce best practices, and ensure long-term reliability.

Every component in Premierstacks is crafted with precision, following strict quality standards. From backend logic to frontend interfaces and infrastructure tooling, the focus remains on delivering scalable, future-proof, and seamless solutions. With Premierstacks, development becomes faster, cleaner, and more consistent—right from the first line of code to final deployment.

## What is Tomchochola

[GitHub Personal → /tomchochola](https://github.com/tomchochola)

The Tomchochola GitHub profile features a range of public and private repositories, including experimental tools, independent projects, and legacy systems. These repositories often represent unique solutions that exist outside the strict quality and structural guidelines of Premierstacks.

Here, you’ll find codebases that may belong to different ecosystems, technologies, or experimental workflows. Some projects serve specific use cases, while others are standalone solutions or serve as proof-of-concept prototypes. This profile is a playground for ideas, tools, and resources that might not fully align with the long-term goals of Premierstacks but still offer value and insight into various aspects of software development.

## About the Creator

Tomáš Chochola is a software architect, technical leader, and creator of the Premierstacks ecosystem. With years of experience in backend and frontend development, cloud infrastructure, and team management, he has established a reputation for delivering scalable, maintainable, and robust software solutions.

His expertise spans backend systems built on PHP and Laravel, frontend interfaces designed with React and Material Design 3, and efficient workflows powered by modern tooling and infrastructure solutions.

### Specializations

**Backend Development:** PHP, Laravel, JSON:API<br />
**Frontend Development:** TypeScript, React, Material Design 3<br />
**Tooling:** ESLint, Prettier, Webpack, PHPStan, PHP CS Fixer, Stylelint<br />

## Support the Creator

**[GitHub Sponsors -> /sponsors/tomchochola](https://github.com/sponsors/tomchochola)**

Premierstacks is now freely available under the Creative Commons BY-ND 4.0 license, offering high-quality tools, libraries, and templates to the developer community. While the ecosystem remains open and accessible, its growth, updates, and ongoing maintenance depend on individual support.

By sponsoring Tomáš Chochola on GitHub Sponsors, you directly contribute to the continued development, improvement, and long-term sustainability of Premierstacks. Every contribution supports the creation of reliable, scalable, and future-proof solutions for developers worldwide.

Your support makes a difference—thank you for being a part of this journey.

## License

**Creative Commons Attribution-NoDerivatives 4.0 International**

**Copyright © 2025, Tomáš Chochola <chocholatom1997@gmail.com>. Some rights reserved.**

This license requires that reusers give credit to the creator. It allows reusers to copy and distribute the material in any medium or format in unadapted form only, even for commercial purposes.

### Creative Commons License for Software?

The Creative Commons BY-ND 4.0 license is perfectly suited to Premierstacks. It offers developers the freedom to integrate the software into their projects while preserving the original author’s vision and ensuring consistency across the ecosystem.

Dynamic linking and object-oriented programming practices, such as inheritance or method overriding, are fully permitted. This enables seamless adaptation of the software in dynamic contexts without violating the license. However, static linking, forks, or modifications that alter the software’s original form are prohibited to maintain its integrity and prevent the creation of fragmented or subpar versions.

By protecting the core quality and unity of Premierstacks, this license ensures that developers can confidently rely on it as a trusted, high-standard solution for their projects.

## Module exports

Here are the available module exports:

```php
use Premierstacks\LaravelStack\Auth\Guards\UnlimitedTokenGuard;
use Premierstacks\LaravelStack\Auth\Http\Controllers\AbstractVerificationController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\AuthenticatableDestroyController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\AuthenticatableShowController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\AuthenticatableUpdateController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\CredentialsUpdateController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\EmailVerificationController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\FreeEmailVerificationController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\LoginController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\LogoutAllDevicesController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\LogoutCurrentDeviceController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\LogoutOtherDevicesController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\MineEmailVerificationController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\OccupiedEmailVerificationController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\PasswordForgotController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\PasswordResetController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\PasswordUpdateController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\RegisterController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\RetrieveAuthenticatableController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\SessionInvalidateController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\SessionRegenerateController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\VerificationCompleteController;
use Premierstacks\LaravelStack\Auth\Http\Controllers\VerificationShowController;
use Premierstacks\LaravelStack\Auth\Http\JsonApi\AuthJsonApiResource;
use Premierstacks\LaravelStack\Auth\Http\JsonApi\AuthenticatableJsonApiResource;
use Premierstacks\LaravelStack\Auth\Http\JsonApi\SessionJsonApiResource;
use Premierstacks\LaravelStack\Auth\Http\JsonApi\UnlimitedTokenJsonApiResource;
use Premierstacks\LaravelStack\Auth\Http\JsonApi\VerificationJsonApiResource;
use Premierstacks\LaravelStack\Auth\Http\ValidationAuthenticatableValidity;
use Premierstacks\LaravelStack\Auth\Http\ValidationVerificationValidity;
use Premierstacks\LaravelStack\Auth\Models\IntAuthenticatable;
use Premierstacks\LaravelStack\Auth\Models\MixedAuthenticatable;
use Premierstacks\LaravelStack\Auth\Models\StringAuthenticatable;
use Premierstacks\LaravelStack\Auth\Models\UnlimitedToken;
use Premierstacks\LaravelStack\Commands\DebugMailCommand;
use Premierstacks\LaravelStack\Commands\MakeEnumCommand;
use Premierstacks\LaravelStack\Commands\ValidityGeneratorCommand;
use Premierstacks\LaravelStack\Config\Conf;
use Premierstacks\LaravelStack\Config\Env;
use Premierstacks\LaravelStack\Configuration\MiddlewareConfiguration;
use Premierstacks\LaravelStack\Configuration\ScheduleConfiguration;
use Premierstacks\LaravelStack\Container\InjectTrait;
use Premierstacks\LaravelStack\Container\Resolve;
use Premierstacks\LaravelStack\Database\Factories\AuthenticatableFactory;
use Premierstacks\LaravelStack\Database\Migrator;
use Premierstacks\LaravelStack\Eloquent\IntModel;
use Premierstacks\LaravelStack\Eloquent\IntModelTrait;
use Premierstacks\LaravelStack\Eloquent\IntPivot;
use Premierstacks\LaravelStack\Eloquent\MixedModel;
use Premierstacks\LaravelStack\Eloquent\MixedModelTrait;
use Premierstacks\LaravelStack\Eloquent\MixedPivot;
use Premierstacks\LaravelStack\Eloquent\StringModel;
use Premierstacks\LaravelStack\Eloquent\StringModelTrait;
use Premierstacks\LaravelStack\Eloquent\StringPivot;
use Premierstacks\LaravelStack\Exceptions\ExceptionHandler;
use Premierstacks\LaravelStack\Exceptions\Thrower;
use Premierstacks\LaravelStack\Fake\ImageFaker;
use Premierstacks\LaravelStack\Http\Controllers\NotFoundController;
use Premierstacks\LaravelStack\Http\Middleware\BindMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\HasLocalePreferenceMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\SetAuthDefaultsMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\SetPreferredLanguageMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\SetRequestFormatMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\SingletonMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\SmartTransactionMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\ThrottleFailExceptMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\ThrottleFailOnlyMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\ThrottlePassMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\TransactionMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\ValidateAcceptHeaderMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\ValidateContentTypeHeaderMiddleware;
use Premierstacks\LaravelStack\Http\Middleware\ValidationFactoryMiddleware;
use Premierstacks\LaravelStack\Http\RequestSignature;
use Premierstacks\LaravelStack\JsonApi\JsonApiResponseFactory;
use Premierstacks\LaravelStack\JsonApi\PaginatorJsonApiMeta;
use Premierstacks\LaravelStack\JsonApi\ThrowableJsonApiError;
use Premierstacks\LaravelStack\JsonApi\ThrowableJsonApiErrors;
use Premierstacks\LaravelStack\JsonApi\ThrowableJsonApiMeta;
use Premierstacks\LaravelStack\JsonApi\ValidationMessageJsonApiError;
use Premierstacks\LaravelStack\JsonApi\ValidationRuleJsonApiError;
use Premierstacks\LaravelStack\Notifications\TestMailNotification;
use Premierstacks\LaravelStack\Notifications\VerificationNotification;
use Premierstacks\LaravelStack\Providers\LaravelStackServiceProvider;
use Premierstacks\LaravelStack\Testing\TestCase;
use Premierstacks\LaravelStack\Testing\TestCaseTrait;
use Premierstacks\LaravelStack\Throttle\Limit;
use Premierstacks\LaravelStack\Throttle\Limiter;
use Premierstacks\LaravelStack\Translation\Trans;
use Premierstacks\LaravelStack\Validation\Rules\BytesBetweenRule;
use Premierstacks\LaravelStack\Validation\Rules\BytesMaxRule;
use Premierstacks\LaravelStack\Validation\Rules\BytesMinRule;
use Premierstacks\LaravelStack\Validation\Rules\BytesSizeRule;
use Premierstacks\LaravelStack\Validation\Rules\CallbackRule;
use Premierstacks\LaravelStack\Validation\Rules\CursorRule;
use Premierstacks\LaravelStack\Validation\Rules\CzBankAccountNumberRule;
use Premierstacks\LaravelStack\Validation\Rules\EnumRule;
use Premierstacks\LaravelStack\Validation\Rules\FloatRule;
use Premierstacks\LaravelStack\Validation\Rules\IcoRule;
use Premierstacks\LaravelStack\Validation\Rules\KeyRule;
use Premierstacks\LaravelStack\Validation\Rules\KeysRule;
use Premierstacks\LaravelStack\Validation\Rules\ListRule;
use Premierstacks\LaravelStack\Validation\Rules\MapRule;
use Premierstacks\LaravelStack\Validation\Rules\PostCodeRule;
use Premierstacks\LaravelStack\Validation\Rules\RecaptchaRule;
use Premierstacks\LaravelStack\Validation\Rules\ValidateRule;
use Premierstacks\LaravelStack\Validation\Rules\ValidationRule;
use Premierstacks\LaravelStack\Validation\Validators\ApiValidator;
use Premierstacks\LaravelStack\Validation\Validators\Validator;
use Premierstacks\LaravelStack\Validation\Validity\BooleanValidity;
use Premierstacks\LaravelStack\Validation\Validity\CarbonLimits;
use Premierstacks\LaravelStack\Validation\Validity\CarbonValidity;
use Premierstacks\LaravelStack\Validation\Validity\FileLimits;
use Premierstacks\LaravelStack\Validation\Validity\FileType;
use Premierstacks\LaravelStack\Validation\Validity\FileValidity;
use Premierstacks\LaravelStack\Validation\Validity\FloatLimits;
use Premierstacks\LaravelStack\Validation\Validity\FloatValidity;
use Premierstacks\LaravelStack\Validation\Validity\InValidity;
use Premierstacks\LaravelStack\Validation\Validity\IntegerLimits;
use Premierstacks\LaravelStack\Validation\Validity\IntegerValidity;
use Premierstacks\LaravelStack\Validation\Validity\ListLimits;
use Premierstacks\LaravelStack\Validation\Validity\ListValidity;
use Premierstacks\LaravelStack\Validation\Validity\MapLimits;
use Premierstacks\LaravelStack\Validation\Validity\MapValidity;
use Premierstacks\LaravelStack\Validation\Validity\MixedValidity;
use Premierstacks\LaravelStack\Validation\Validity\ScalarValidityTrait;
use Premierstacks\LaravelStack\Validation\Validity\SizeValidityTrait;
use Premierstacks\LaravelStack\Validation\Validity\StringLimits;
use Premierstacks\LaravelStack\Validation\Validity\StringValidity;
use Premierstacks\LaravelStack\Validation\Validity\Validity;
use Premierstacks\LaravelStack\Verification\Context;
use Premierstacks\LaravelStack\Verification\ContextInterface;
use Premierstacks\LaravelStack\Verification\Verification;
use Premierstacks\LaravelStack\Verification\VerificationInterface;
use Premierstacks\LaravelStack\Verification\Verificator;
use Premierstacks\LaravelStack\Verification\VerificatorInterface;
```

## Getting Started

**1. Review the documentation and license**

Ensure this package fits your needs and that you agree with the terms.

**2. Install the package**

Setup composer repostory:

```bash
composer config repositories.premierstacks/laravel-stack '{"type": "vcs", "url": "https://github.com/premierstacks/laravel-stack.git", "no-api": true}'
```

Install using composer:

```bash
composer require --dev premierstacks/laravel-stack:@dev
```

## Contact

**📧 Email: <chocholatom1997@gmail.com>**<br />
**👨 GitHub Personal: [https://github.com/tomchochola](https://github.com/tomchochola)**<br />
**🏢 GitHub Organization: [https://github.com/premierstacks](https://github.com/premierstacks)**<br />
**💰 GitHub Sponsors: [https://github.com/sponsors/tomchochola](https://github.com/sponsors/tomchochola)**<br />

## Tree

The following is a breakdown of the folder and file structure within this repository. It provides an overview of how the code is organized and where to find key components.

```bash
.
├── AUTHORS.md
├── composer.json
├── .editorconfig
├── eslint.config.js
├── .gitattributes
├── .gitignore
├── lang
│   ├── cs
│   │   ├── actions.php
│   │   ├── auth.php
│   │   ├── notifications.php
│   │   ├── pagination.php
│   │   ├── passwords.php
│   │   ├── statuses.php
│   │   ├── validation_full.php
│   │   ├── validation_generic.php
│   │   ├── validation.php
│   │   └── validation_simple.php
│   ├── cs.json
│   ├── en
│   │   ├── actions.php
│   │   ├── auth.php
│   │   ├── notifications.php
│   │   ├── pagination.php
│   │   ├── passwords.php
│   │   ├── statuses.php
│   │   ├── validation_full.php
│   │   ├── validation_generic.php
│   │   ├── validation.php
│   │   └── validation_simple.php
│   ├── en.json
│   ├── sk
│   │   ├── actions.php
│   │   ├── auth.php
│   │   ├── notifications.php
│   │   ├── pagination.php
│   │   ├── passwords.php
│   │   ├── statuses.php
│   │   ├── validation_full.php
│   │   ├── validation_generic.php
│   │   ├── validation.php
│   │   └── validation_simple.php
│   └── sk.json
├── LICENSE
├── Makefile
├── package.json
├── .php-cs-fixer.php
├── phpstan.neon
├── phpunit.xml
├── prettier.config.js
├── .prettierignore
├── README.md
├── resources
│   ├── assets
│   │   └── marbles
│   │       ├── 1.jpg
│   │       ├── 2.jpg
│   │       ├── 3.jpg
│   │       ├── 4.jpg
│   │       ├── 5.jpg
│   │       └── 6.jpg
│   └── views
│       ├── error_minimal.blade.php
│       └── swagger.blade.php
└── src
    ├── Auth
    │   ├── Guards
    │   │   └── UnlimitedTokenGuard.php
    │   ├── Http
    │   │   ├── Controllers
    │   │   │   ├── AbstractVerificationController.php
    │   │   │   ├── AuthenticatableDestroyController.php
    │   │   │   ├── AuthenticatableShowController.php
    │   │   │   ├── AuthenticatableUpdateController.php
    │   │   │   ├── CredentialsUpdateController.php
    │   │   │   ├── EmailVerificationController.php
    │   │   │   ├── FreeEmailVerificationController.php
    │   │   │   ├── LoginController.php
    │   │   │   ├── LogoutAllDevicesController.php
    │   │   │   ├── LogoutCurrentDeviceController.php
    │   │   │   ├── LogoutOtherDevicesController.php
    │   │   │   ├── MineEmailVerificationController.php
    │   │   │   ├── OccupiedEmailVerificationController.php
    │   │   │   ├── PasswordForgotController.php
    │   │   │   ├── PasswordResetController.php
    │   │   │   ├── PasswordUpdateController.php
    │   │   │   ├── RegisterController.php
    │   │   │   ├── RetrieveAuthenticatableController.php
    │   │   │   ├── SessionInvalidateController.php
    │   │   │   ├── SessionRegenerateController.php
    │   │   │   ├── VerificationCompleteController.php
    │   │   │   └── VerificationShowController.php
    │   │   ├── JsonApi
    │   │   │   ├── AuthenticatableJsonApiResource.php
    │   │   │   ├── AuthJsonApiResource.php
    │   │   │   ├── SessionJsonApiResource.php
    │   │   │   ├── UnlimitedTokenJsonApiResource.php
    │   │   │   └── VerificationJsonApiResource.php
    │   │   └── Validation
    │   │       ├── AuthenticatableValidity.php
    │   │       └── VerificationValidity.php
    │   └── Models
    │       ├── IntAuthenticatable.php
    │       ├── MixedAuthenticatable.php
    │       ├── StringAuthenticatable.php
    │       └── UnlimitedToken.php
    ├── Commands
    │   ├── DebugMailCommand.php
    │   ├── MakeEnumCommand.php
    │   ├── ScoutSyncCommand.php
    │   ├── stubs
    │   │   ├── enum.stub
    │   │   └── validity.stub
    │   └── ValidityGeneratorCommand.php
    ├── Config
    │   ├── Conf.php
    │   └── Env.php
    ├── Configuration
    │   ├── MiddlewareConfiguration.php
    │   └── ScheduleConfiguration.php
    ├── Container
    │   ├── InjectTrait.php
    │   └── Resolve.php
    ├── Database
    │   ├── Factories
    │   │   └── AuthenticatableFactory.php
    │   └── Migrator.php
    ├── Eloquent
    │   ├── IntModel.php
    │   ├── IntModelTrait.php
    │   ├── IntPivot.php
    │   ├── MixedModel.php
    │   ├── MixedModelTrait.php
    │   ├── MixedPivot.php
    │   ├── StringModel.php
    │   ├── StringModelTrait.php
    │   └── StringPivot.php
    ├── Enums
    │   ├── CzBankCodeEnum.php
    │   ├── CzPostCodeEnum.php
    │   └── DayEnum.php
    ├── Exceptions
    │   ├── ExceptionHandler.php
    │   └── Thrower.php
    ├── Fake
    │   └── ImageFaker.php
    ├── Geo
    │   ├── Casts
    │   │   └── PointCast.php
    │   ├── Enums
    │   │   ├── Iso3166Char2.php
    │   │   └── Iso3166Char3.php
    │   ├── Mysql
    │   │   └── MysqlGeo.php
    │   ├── Objects
    │   │   ├── Bbox.php
    │   │   ├── Geom.php
    │   │   ├── MultiPolygon.php
    │   │   ├── Point.php
    │   │   └── Polygon.php
    │   ├── Rules
    │   │   ├── BboxRule.php
    │   │   └── PointRule.php
    │   └── Validity
    │       └── GeoValidity.php
    ├── Http
    │   ├── Controllers
    │   │   └── NotFoundController.php
    │   ├── Middleware
    │   │   ├── BindMiddleware.php
    │   │   ├── HasLocalePreferenceMiddleware.php
    │   │   ├── SetAuthDefaultsMiddleware.php
    │   │   ├── SetPreferredLanguageMiddleware.php
    │   │   ├── SetRequestFormatMiddleware.php
    │   │   ├── SingletonMiddleware.php
    │   │   ├── SmartTransactionMiddleware.php
    │   │   ├── ThrottleFailExceptMiddleware.php
    │   │   ├── ThrottleFailOnlyMiddleware.php
    │   │   ├── ThrottlePassMiddleware.php
    │   │   ├── TransactionMiddleware.php
    │   │   ├── ValidateAcceptHeaderMiddleware.php
    │   │   ├── ValidateContentTypeHeaderMiddleware.php
    │   │   └── ValidationFactoryMiddleware.php
    │   └── RequestSignature.php
    ├── JsonApi
    │   ├── JsonApiResponseFactory.php
    │   ├── PaginatorJsonApiMeta.php
    │   ├── ThrowableJsonApiError.php
    │   ├── ThrowableJsonApiErrors.php
    │   ├── ThrowableJsonApiMeta.php
    │   ├── ValidationMessageJsonApiError.php
    │   └── ValidationRuleJsonApiError.php
    ├── Notifications
    │   ├── TestMailNotification.php
    │   └── VerificationNotification.php
    ├── Providers
    │   └── LaravelStackServiceProvider.php
    ├── Scout
    │   └── ScoutFulltext.php
    ├── Testing
    │   ├── TestCase.php
    │   └── TestCaseTrait.php
    ├── Throttle
    │   ├── Limiter.php
    │   └── Limit.php
    ├── Translation
    │   └── Trans.php
    ├── Validation
    │   ├── Rules
    │   │   ├── BytesBetweenRule.php
    │   │   ├── BytesMaxRule.php
    │   │   ├── BytesMinRule.php
    │   │   ├── BytesSizeRule.php
    │   │   ├── CallbackRule.php
    │   │   ├── CursorRule.php
    │   │   ├── CzBankAccountNumberRule.php
    │   │   ├── EnumRule.php
    │   │   ├── FloatRule.php
    │   │   ├── IcoRule.php
    │   │   ├── KeyRule.php
    │   │   ├── KeysRule.php
    │   │   ├── ListRule.php
    │   │   ├── MapRule.php
    │   │   ├── PostCodeRule.php
    │   │   ├── RecaptchaRule.php
    │   │   ├── ValidateRule.php
    │   │   └── ValidationRule.php
    │   ├── Validators
    │   │   ├── ApiValidator.php
    │   │   └── Validator.php
    │   └── Validity
    │       ├── BooleanValidity.php
    │       ├── CarbonLimits.php
    │       ├── CarbonValidity.php
    │       ├── FileLimits.php
    │       ├── FileType.php
    │       ├── FileValidity.php
    │       ├── FloatLimits.php
    │       ├── FloatValidity.php
    │       ├── IntegerLimits.php
    │       ├── IntegerValidity.php
    │       ├── InValidity.php
    │       ├── ListLimits.php
    │       ├── ListValidity.php
    │       ├── MapLimits.php
    │       ├── MapValidity.php
    │       ├── MixedValidity.php
    │       ├── ScalarValidityTrait.php
    │       ├── SizeValidityTrait.php
    │       ├── StringLimits.php
    │       ├── StringValidity.php
    │       └── Validity.php
    └── Verification
        ├── ContextInterface.php
        ├── Context.php
        ├── VerificationInterface.php
        ├── Verification.php
        ├── VerificatorInterface.php
        └── Verificator.php

50 directories, 210 files
```
