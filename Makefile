# Default shell
SHELL := /bin/bash

# Default goal
.DEFAULT_GOAL := never

# Variables
MAKE_PHP_8_4_EXE ?= php8.4
MAKE_COMPOSER_2_EXE ?= /usr/local/bin/composer
MAKE_NPM_EXE ?= npm
MAKE_NODE_EXE ?= node

MAKE_PHP ?= ${MAKE_PHP_8_4_EXE}
MAKE_COMPOSER ?= ${MAKE_PHP} ${MAKE_COMPOSER_2_EXE}
MAKE_NPM ?= ${MAKE_NPM_EXE}
MAKE_NODE ?= ${MAKE_NODE_EXE}

# Goals
.PHONY: audit
audit: audit_npm audit_composer

.PHONY: audit_composer
audit_composer: ./vendor/autoload.php ./composer.lock
	${MAKE_COMPOSER} run composer:audit
	${MAKE_COMPOSER} run composer:platform
	${MAKE_COMPOSER} run composer:validate

.PHONY: audit_npm
audit_npm: ./node_modules ./package-lock.json
	${MAKE_NPM} run npm:audit

.PHONY: check
check: lint stan audit

.PHONY: clean
clean:
	rm -rf ./.php-cs-fixer.cache
	rm -rf ./.phpunit.cache
	rm -rf ./.phpunit.coverage
	rm -rf ./.phpunit.result.cache
	rm -rf ./composer.lock
	rm -rf ./node_modules
	rm -rf ./package-lock.json
	rm -rf ./vendor

.PHONY: coverage
coverage: test ./.phpunit.coverage/html
	${MAKE_COMPOSER} test:coverage

.PHONY: fix
fix: fix_eslint fix_prettier fix_php_cs_fixer

.PHONY: fix_eslint
fix_eslint: ./node_modules/.bin/eslint ./eslint.config.js
	${MAKE_NPM} run fix:eslint

.PHONY: fix_php_cs_fixer
fix_php_cs_fixer: ./vendor/bin/php-cs-fixer ./.php-cs-fixer.php
	${MAKE_COMPOSER} run fix:php-cs-fixer

.PHONY: fix_prettier
fix_prettier: ./node_modules/.bin/prettier ./prettier.config.js
	${MAKE_NPM} run fix:prettier

.PHONY: lint
lint: lint_eslint lint_prettier lint_php_cs_fixer

.PHONY: lint_eslint
lint_eslint: ./node_modules/.bin/eslint ./eslint.config.js
	${MAKE_NPM} run lint:eslint

.PHONY: lint_php_cs_fixer
lint_php_cs_fixer: ./vendor/bin/php-cs-fixer ./.php-cs-fixer.php
	${MAKE_COMPOSER} run lint:php-cs-fixer

.PHONY: lint_prettier
lint_prettier: ./node_modules/.bin/prettier ./prettier.config.js
	${MAKE_NPM} run lint:prettier

.PHONY: local
local: ./vendor/autoload.php
	${MAKE_COMPOSER} run dump:development

.PHONY: stan
stan: stan_phpstan

.PHONY: stan_phpstan
stan_phpstan: ./vendor/bin/phpstan ./phpstan.neon
	${MAKE_COMPOSER} run stan:phpstan

.PHONY: test
test: test_phpunit

.PHONY: test_phpunit
test_phpunit: ./vendor/bin/phpunit ./phpunit.xml
	${MAKE_COMPOSER} run dump:development
	${MAKE_COMPOSER} run test:phpunit

# Dependencies
./node_modules ./node_modules/.bin/eslint ./node_modules/.bin/prettier: ./package-lock.json
	${MAKE_NPM} run npm:install
	touch ./package-lock.json
	touch ./node_modules
	touch ./node_modules/.bin/*

./package-lock.json: ./package.json
	rm -rf ./node_modules
	rm -rf ./package-lock.json
	${MAKE_NPM} run npm:update
	touch ./package-lock.json

./vendor ./vendor/bin/php-cs-fixer ./vendor/bin/phpstan ./vendor/bin/phpunit ./vendor/autoload.php: ./composer.lock
	${MAKE_COMPOSER} run composer:install
	touch ./composer.lock
	touch ./vendor
	touch ./vendor/bin/*
	touch ./vendor/autoload.php

./composer.lock: ./composer.json
	rm -rf ./vendor
	rm -rf ./composer.lock
	${MAKE_COMPOSER} run composer:update
	touch ./composer.lock
