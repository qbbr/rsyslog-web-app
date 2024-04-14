.DEFAULT_GOAL = black@hole

UID           = $(shell id -u)
USER          = $(shell id -un)

COMPOSER      = composer
CONSOLE       = bin/console
PHPUNIT       = bin/phpunit
PHPCSFIXER    = vendor/bin/php-cs-fixer
PHPSTAN       = vendor/bin/phpstan

##
# build containers
##
_build:
	docker compose \
	    $(args) \
	    build \
	        --no-cache \
	        --build-arg UID=$(UID) \
	        --build-arg USER=$(USER)
.PHONY: _build

build@dev:
	make _build
.PHONY: build@dev

build@prod:
	make args='-f docker-compose.yml -f docker-compose.prod.yml' _build
.PHONY: build@prod

##
# install depends
##
_install:
	make check
	make install-frontend
.PHONY: _install

install@dev:
	make _install
	make composer-install@dev
	make install-db
	make load-fixtures@dev
	make composer-clear-cache
.PHONY: install@dev

install@prod:
	make _install
	make composer-install@prod
	make composer-clear-cache
.PHONY: install@prod

install@test:
	make install-db@test
	make load-fixtures@test
.PHONY: install@test

install-frontend:
	make cmd='./bin/install-frontend' exec-app
.PHONY: install-frontend

install-db:
	make cmd='$(CONSOLE) d:d:c --if-not-exists && $(CONSOLE) d:s:u --force' exec-app
.PHONY: install-db

install-db@test:
	# `--if-not-exists` does not supports on sqlite
	make cmd='$(CONSOLE) -e test d:d:c && $(CONSOLE) -e test d:s:u --force' exec-app
.PHONY: install-db@test

##
# composer
##
composer-install@dev:
	make cmd='$(COMPOSER) install' exec-app
.PHONY: composer-install@dev

composer-install@prod:
	make cmd='$(COMPOSER) install --no-dev --optimize-autoloader' exec-app
.PHONY: composer-install@prod

composer-clear-cache:
	make cmd='$(COMPOSER) clear-cache' exec-app
.PHONY: composer-clear-cache

##
# app
##
_load-fixtures:
	make cmd='$(CONSOLE) $(env_arg) doctrine:fixtures:load -n' exec-app
.PHONY: _load-fixtures

load-fixtures@dev:
	make _load-fixtures
.PHONY: load-fixtures@test

load-fixtures@test:
	make env_arg='-e test' _load-fixtures
.PHONY: load-fixtures@test

cache-clear:
	make cmd='$(CONSOLE) c:c' exec-app
	make cmd='$(CONSOLE) c:w' exec-app
.PHONY: cache-clear

test:
	make cmd='$(PHPUNIT) --testdox' exec-app
.PHONY: test

##
# docker
##
up:
	docker compose up -d --remove-orphans
.PHONY: up

down:
	docker compose down -v
.PHONY: down

ps:
	docker compose ps -a
.PHONY: ps

logs:
	docker compose logs -f
.PHONY: logs

# make cmd='composer info' exec-app
exec-app:
	docker compose exec app sh -c "$(cmd)"
.PHONY: exec-app

shell-app:
	docker compose exec app bash
.PHONY: shell-app

shell-nginx:
	docker compose exec nginx sh
.PHONY: shell-nginx

shell-db:
	docker compose exec db sh
.PHONY: shell-db

##
# lint
##
check: ### Check that platform requirements and validate composer.* files
	make cmd="$(COMPOSER) check-platform-reqs" exec-app
	make cmd="$(COMPOSER) validate" exec-app
.PHONY: check

cs:
	make cmd='$(PHPCSFIXER) fix --dry-run --diff' exec-app
.PHONY: cs

cs-fix:
	make cmd='$(PHPCSFIXER) fix' exec-app
.PHONY: cs-fix

phpstan:
	make cmd='$(PHPSTAN) analyse src tests' exec-app
.PHONY: phpstan
