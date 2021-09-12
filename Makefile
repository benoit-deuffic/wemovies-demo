.PHONY : up composer-symfony-create-project up-all
SUPPORTED_COMMANDS := composer-require composer-update ebdeploy ebcreate ebterminate phpcs phpcbf symfony-create-app
SUPPORTS_MAKE_ARGS := $(findstring $(firstword $(MAKECMDGOALS)), $(SUPPORTED_COMMANDS))
ifneq "$(SUPPORTS_MAKE_ARGS)" ""
  COMMAND_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  $(eval $(COMMAND_ARGS):;@:)
endif

prune:
	docker system prune -a -f

build:
	docker-compose up --build -d

up:
	docker-compose up -d

down:
	 docker-compose down

start:
	docker-compose start

stop:
	docker-compose stop

restart:
	docker-compose restart

logs:
	docker-compose logs

push:
	docker-compose push

build-app:
	docker-compose build nginx php

rebuild: stop clean build

phpcs:
	./scripts/make-phpcs.sh $(COMMAND_ARGS); exit 0;

phpcbf:
	./scripts/make-phpcbf.sh  $(COMMAND_ARGS); exit 0;

composer-require:
	docker-compose exec php composer require --prefer-dist --prefer-stable $(COMMAND_ARGS)

composer-update:
	docker-compose exec php composer update ${COMMAND_ARGS}

composer-install:
	docker-compose exec php composer install

# for boot a blank project uncomment and run
#composer-symfony-create-project:
#	docker-compose exec php composer create-project symfony/skeleton app && sudo chown -R 82:docker-www-data app/vendor app/var

install-all:
	up
	composer-install