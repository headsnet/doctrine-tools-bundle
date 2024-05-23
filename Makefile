.PHONY: help
.DEFAULT_GOAL := help

PHP = php
PHPUNIT = ${PHP} vendor/bin/phpunit

cs: ## Run ECS Coding Standards analysis
	@${PHP} vendor/bin/ecs check

cs-fix: ## Fix ECS Coding Standards
	@${PHP} vendor/bin/ecs check --fix

static: ## Run PHPStan static analysis
	@${PHP} vendor/bin/phpstan analyse

test: ## Run PHPUnit tests
	@${PHPUNIT}

test-coverage: ## Run PHPUnit tests with code coverage
	@${PHPUNIT} --coverage-html=var/coverage

########################################################################################################################
# https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
help:
	@echo "\nMakefile is used to run various utilities related to this project\n"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
########################################################################################################################
