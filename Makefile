# Default shell
SHELL := /bin/bash

# Default goal
.DEFAULT_GOAL := never

# Variables
MAKE_PHP_8_3_EXE ?= php8.3
MAKE_COMPOSER_2_EXE ?= /usr/local/bin/composer

MAKE_PHP ?= ${MAKE_PHP_8_3_EXE} -d zend.assertions=1
MAKE_COMPOSER ?= ${MAKE_PHP} ${MAKE_COMPOSER_2_EXE}

# Goals
.PHONY: audit
audit: audit_npm audit_composer

.PHONY: audit_composer
audit_composer: ./vendor/autoload.php ./composer.lock
	${MAKE_COMPOSER} audit
	${MAKE_COMPOSER} check-platform-reqs
	${MAKE_COMPOSER} validate --strict --no-check-all

.PHONY: audit_npm
audit_npm: ./node_modules ./package-lock.json
	npm audit --audit-level info --include prod --include dev --include peer --include optional

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

.PHONY: commit
commit: fix check

.PHONY: coverage
coverage: test ./.phpunit.coverage/html
	${MAKE_PHP} -S 0.0.0.0:8000 -t ./.phpunit.coverage/html

.PHONY: development
development: local

.PHONY: fix
fix: fix_eslint fix_prettier fix_php_cs_fixer

.PHONY: fix_eslint
fix_eslint: ./node_modules/.bin/eslint ./eslint.config.js
	./node_modules/.bin/eslint --fix .

.PHONY: fix_php_cs_fixer
fix_php_cs_fixer: ./vendor/bin/php-cs-fixer ./.php-cs-fixer.php
	${MAKE_PHP} ./vendor/bin/php-cs-fixer fix

.PHONY: fix_prettier
fix_prettier: ./node_modules/.bin/prettier ./prettier.config.js
	./node_modules/.bin/prettier -w .

.PHONY: lint
lint: lint_eslint lint_prettier lint_php_cs_fixer

.PHONY: lint_eslint
lint_eslint: ./node_modules/.bin/eslint ./eslint.config.js
	./node_modules/.bin/eslint .

.PHONY: lint_php_cs_fixer
lint_php_cs_fixer: ./vendor/bin/php-cs-fixer ./.php-cs-fixer.php
	${MAKE_PHP} ./vendor/bin/php-cs-fixer fix --dry-run --diff

.PHONY: lint_prettier
lint_prettier: ./node_modules/.bin/prettier ./prettier.config.js
	./node_modules/.bin/prettier -c .

.PHONY: local
local: ./vendor/autoload.php
	${MAKE_COMPOSER} dump-autoload -o --dev --strict-psr

.PHONY: production
production: staging

.PHONY: staging
staging: local
	${MAKE_COMPOSER} dump-autoload -a --no-dev --strict-psr

.PHONY: stan
stan: stan_phpstan

.PHONY: stan_phpstan
stan_phpstan: ./vendor/bin/phpstan ./phpstan.neon
	${MAKE_PHP} ./vendor/bin/phpstan analyse

.PHONY: test
test: test_phpunit

.PHONY: test_phpunit
test_phpunit: ./vendor/bin/phpunit ./phpunit.xml
	${MAKE_COMPOSER} dump-autoload -o --dev --strict-psr
	${MAKE_PHP} ./vendor/bin/phpunit

.PHONY: testing
testing: local

# Dependencies
 ./node_modules ./node_modules/.bin/eslint ./node_modules/.bin/prettier: ./package-lock.json
	npm install --install-links --include prod --include dev --include peer --include optional
	touch ./package-lock.json
	touch ./node_modules
	touch ./node_modules/.bin/*

./package-lock.json: ./package.json
	rm -rf ./node_modules
	rm -rf ./package-lock.json
	npm update --install-links --include prod --include dev --include peer --include optional
	touch ./package-lock.json

./vendor ./vendor/bin/php-cs-fixer ./vendor/bin/phpstan ./vendor/bin/phpunit ./vendor/autoload.php: ./composer.lock
	${MAKE_COMPOSER} install
	touch ./composer.lock
	touch ./vendor/autoload.php
	touch ./vendor
	touch ./vendor/bin/*

./composer.lock: ./composer.json
	rm -rf ./vendor
	rm -rf ./composer.lock
	${MAKE_COMPOSER} update
	touch ./composer.lock
