SHELL := /bin/bash
DOCKER_PHP=docker exec swapi-swapi.test-1

install:
	docker-compose up -d
	$(DOCKER_PHP) composer install
	./vendor/bin/sail up -d
	./vendor/bin/sail artisan migrate
.PHONY: install
