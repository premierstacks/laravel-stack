# [Laravel Stack](https://github.com/premierstacks/laravel-stack) by [Tomáš Chochola](https://github.com/tomchochola)

✨ _**Clone and Win!**_

The Laravel Stack is a robust, pre-configured foundation for scalable Laravel applications, featuring essential tools for code quality, authentication, validation, and security. With modular configurations and helper utilities, it supports streamlined workflows, ideal for both rapid prototyping and production-ready deployments.

## What is Laravel Stack?

The Laravel Stack serves as a high-performance toolkit specifically designed for Laravel developers who aim to maintain top-notch code quality and system integrity across their projects. It includes built-in configurations for authentication controllers, JSON API resources, and a rich set of validation rules, all of which are crafted to make robust application development accessible and efficient. By leveraging Laravel's powerful features alongside Premierstacks’ refined configurations, this stack makes it simple to enforce consistent standards and scalable practices.

In addition to providing a comprehensive structure, the Laravel Stack offers a collection of pre-built controllers, middleware, and validation utilities that cover common scenarios, from handling complex data validation to managing user authentication flows. The stack's modular architecture allows developers to seamlessly integrate and customize each component, making it versatile for various project scopes and complexities.

With a focus on security, performance, and maintainability, the Laravel Stack is crafted to help you tackle any Laravel project confidently. Whether you’re building a new application from scratch or optimizing an existing one, this stack serves as a foundational solution for efficient, high-quality Laravel development.

## What is Tomchochola

[https://github.com/tomchochola](https://github.com/tomchochola)

This is my personal GitHub profile, where you’ll find public documentation and sample repositories for proprietary packages and templates from Premierstacks. These public repositories are designed to give you an overview of the best practices and high-quality code I follow in all my projects.

## What is Premierstacks

[https://github.com/premierstacks](https://github.com/premierstacks)

Premierstacks is a collection of exclusive, proprietary stacks and templates for PHP, JavaScript, TypeScript, React, and Laravel. It was created to address the common pain points developers face with many open-source projects—quality, consistency, and maintainability. With Premierstacks, you get high-quality tools built with strict attention to detail, designed to help you build and maintain better projects, faster.

## Why Premierstacks?

I created Premierstacks because I wasn’t satisfied with the quality of many open-source projects. Maintaining high-quality code and ensuring long-term reliability is challenging when you’re not earning from the product. When you pay for something, it means the creator truly cares about its success and is committed to delivering the best possible outcome.

Like Apple’s approach with their closed ecosystem, I believe that true excellence can only be achieved when every detail is under your control. That’s why Premierstacks is proprietary software—it's not just about providing solutions; it’s about ensuring those solutions meet the highest standards.

### Why You Should Choose Premierstacks

**🚀 Unmatched Quality**

Our solutions adhere to the highest standards, ensuring clean and maintainable code.

**⚙️ No Setup Hassles**

Pre-configured environments let you start coding immediately—no more complex setups.

**📦 Reuse Across Projects**

Each library and template is built to be reusable, reducing long-term maintenance.

**🔒 Exclusive Resources**

Premierstacks offers tools you won’t find in typical open-source collections.

**🛠️ Always Up-to-Date**

Receive continuous updates and new features, keeping your projects current.

**💪 Expert Creators**

Developed by experienced professionals dedicated to quality and excellence.

## License

**© 2024–Present Tomáš Chochola <chocholatom1997@gmail.com>. All rights reserved.**

This software is proprietary and licensed under specific terms set by its owner.<br />
Any form of access, use, or distribution requires a valid and active license.<br />
For full licensing terms, refer to the LICENSE.md file accompanying this software.<br />

**Purchase a license here: [Github Sponsors](https://github.com/sponsors/tomchochola)**

**See full terms here: [/LICENSE.md](/LICENSE.md)**

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
use Premierstacks\LaravelStack\Container\Resolver;
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

**2. Obtain a license**

**Purchase a license here: [Github Sponsors](https://github.com/sponsors/tomchochola)**

**3. Install the package**

Setup composer repostory:

```bash
composer config repositories.premierstacks/laravel-stack git https://github.com/premierstacks/laravel-stack.git
```

Install using composer:

```bash
composer require --dev premierstacks/laravel-stack:@dev
```

**4. Use the package**

Start using the package in your project.

## About the Creator

I'm Tomáš Chochola, a software developer dedicated to creating exclusive, enterprise-grade software solutions. I specialize in building packages and templates for PHP, JavaScript, and TypeScript, tailored to streamline development workflows, enforce best practices, and save you time.

My mission is to develop reusable solutions that enhance code quality, boost productivity, and ensure that projects remain maintainable and scalable over the long term.

### Specializations

**Backend Development:** Expert in PHP and Laravel<br />
**Frontend Development:** Mastery in TypeScript, React, and JavaScript<br />
**DevOps:** Proficient in managing Ubuntu and AWS environments<br />
**Security:** Focused on implementing best practices and enforcing code standards<br />
**Tooling:** Extensive experience with ESLint, Prettier, PHP CS Fixer, Stylelint, and PHPStan<br />
**Reusable Solutions:** Creating templates and configuration stacks for optimized development<br />
**Development Environments:** Fluent in Windows 11 and Ubuntu (WSL2)<br />

## Contact

**📧 Email: <chocholatom1997@gmail.com>**<br />
**💻 Website: [https://premierstacks.com](https://premierstacks.com)**<br />
**👨 GitHub Personal: [https://github.com/tomchochola](https://github.com/tomchochola)**<br />
**🏢 GitHub Organization: [https://github.com/premierstacks](https://github.com/premierstacks)**<br />
**💰 GitHub Sponsors: [https://github.com/sponsors/tomchochola](https://github.com/sponsors/tomchochola)**<br />

## Tree

The following is a breakdown of the folder and file structure within this repository. It provides an overview of how the code is organized and where to find key components.

```bash
.
├── .editorconfig
├── .gitattributes
├── .gitignore
├── .php-cs-fixer.php
├── .prettierignore
├── AUTHORS.md
├── LICENSE.md
├── Makefile
├── README.md
├── composer.json
├── eslint.config.js
├── lang
│   ├── cs
│   │   ├── actions.php
│   │   ├── auth.php
│   │   ├── notifications.php
│   │   ├── pagination.php
│   │   ├── passwords.php
│   │   ├── statuses.php
│   │   ├── validation.php
│   │   ├── validation_full.php
│   │   ├── validation_generic.php
│   │   └── validation_simple.php
│   ├── cs.json
│   ├── en
│   │   ├── actions.php
│   │   ├── auth.php
│   │   ├── notifications.php
│   │   ├── pagination.php
│   │   ├── passwords.php
│   │   ├── statuses.php
│   │   ├── validation.php
│   │   ├── validation_full.php
│   │   ├── validation_generic.php
│   │   └── validation_simple.php
│   ├── en.json
│   ├── sk
│   │   ├── actions.php
│   │   ├── auth.php
│   │   ├── notifications.php
│   │   ├── pagination.php
│   │   ├── passwords.php
│   │   ├── statuses.php
│   │   ├── validation.php
│   │   ├── validation_full.php
│   │   ├── validation_generic.php
│   │   └── validation_simple.php
│   └── sk.json
├── package.json
├── phpstan.neon
├── phpunit.xml
├── prettier.config.js
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
    │   │   │   ├── AuthJsonApiResource.php
    │   │   │   ├── AuthenticatableJsonApiResource.php
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
    │   ├── ValidityGeneratorCommand.php
    │   └── stubs
    │       ├── enum.stub
    │       └── validity.stub
    ├── Config
    │   ├── Conf.php
    │   └── Env.php
    ├── Configuration
    │   ├── MiddlewareConfiguration.php
    │   └── ScheduleConfiguration.php
    ├── Container
    │   ├── InjectTrait.php
    │   └── Resolver.php
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
    ├── Exceptions
    │   ├── ExceptionHandler.php
    │   └── Thrower.php
    ├── Fake
    │   └── ImageFaker.php
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
    ├── Testing
    │   ├── TestCase.php
    │   └── TestCaseTrait.php
    ├── Throttle
    │   ├── Limit.php
    │   └── Limiter.php
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
    │       ├── InValidity.php
    │       ├── IntegerLimits.php
    │       ├── IntegerValidity.php
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
        ├── Context.php
        ├── ContextInterface.php
        ├── Verification.php
        ├── VerificationInterface.php
        ├── Verificator.php
        └── VerificatorInterface.php

40 directories, 193 files
```
