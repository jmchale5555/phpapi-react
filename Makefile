COMPOSE_BASE = docker compose -f docker-compose.yaml
COMPOSE_DEV = docker compose -f docker-compose.yaml -f docker-compose.dev.yaml

.PHONY: help up down build logs ps restart dev-up dev-down dev-build dev-logs dev-ps dev-restart shell-php shell-node composer-install seed-admin migrate migrate-down migrate-fresh test test-feature test-unit test-integration danger-prune dev-danger-prune

help:
	@printf "Base stack commands:\n"
	@printf "  make up            Start base stack (db/php/nginx)\n"
	@printf "  make down          Stop base stack\n"
	@printf "  make build         Build base stack images\n"
	@printf "  make logs          Tail base stack logs\n"
	@printf "  make ps            Show base stack services\n"
	@printf "\nDev stack commands:\n"
	@printf "  make dev-up        Start base + dev overlay\n"
	@printf "  make dev-down      Stop base + dev overlay\n"
	@printf "  make dev-build     Build base + dev overlay images\n"
	@printf "  make dev-logs      Tail base + dev overlay logs\n"
	@printf "  make dev-ps        Show base + dev overlay services\n"
	@printf "\nApp commands (dev stack):\n"
	@printf "  make shell-php     Open shell in php container\n"
	@printf "  make shell-node    Open shell in node container\n"
	@printf "  make composer-install Install PHP dependencies in dev php container\n"
	@printf "  make seed-admin    Prompt and create initial admin user\n"
	@printf "  make migrate       Run migrations up\n"
	@printf "  make migrate-down  Roll back last migration batch\n"
	@printf "  make migrate-fresh Drop and recreate database schema\n"
	@printf "  make test          Run full phpunit suite\n"
	@printf "  make test-feature  Run feature test suite\n"
	@printf "  make test-unit     Run unit test suite\n"
	@printf "  make test-integration Run integration test suite\n"
	@printf "\nDanger zone:\n"
	@printf "  make danger-prune  Run sudo docker system prune -a --volumes\n"
	@printf "  make dev-danger-prune Run sudo docker system prune -a --volumes\n"

up:
	$(COMPOSE_BASE) up -d --build

down:
	$(COMPOSE_BASE) down

build:
	$(COMPOSE_BASE) build

logs:
	$(COMPOSE_BASE) logs -f

ps:
	$(COMPOSE_BASE) ps

restart:
	$(COMPOSE_BASE) restart

dev-up:
	$(COMPOSE_DEV) up --build

dev-down:
	$(COMPOSE_DEV) down

dev-build:
	$(COMPOSE_DEV) build

dev-logs:
	$(COMPOSE_DEV) logs -f

dev-ps:
	$(COMPOSE_DEV) ps

dev-restart:
	$(COMPOSE_DEV) restart

shell-php:
	$(COMPOSE_DEV) exec php sh

shell-node:
	$(COMPOSE_DEV) exec node sh

composer-install:
	$(COMPOSE_DEV) exec -T php composer install

seed-admin:
	$(COMPOSE_DEV) exec php php cli/seed_admin.php

migrate:
	$(COMPOSE_DEV) exec -T php php cli/migrate.php up

migrate-down:
	$(COMPOSE_DEV) exec -T php php cli/migrate.php down

migrate-fresh:
	$(COMPOSE_DEV) exec -T php php cli/migrate.php fresh

test:
	$(COMPOSE_DEV) exec -T php vendor/bin/phpunit

test-feature:
	$(COMPOSE_DEV) exec -T php vendor/bin/phpunit --testsuite Feature

test-unit:
	$(COMPOSE_DEV) exec -T php vendor/bin/phpunit --testsuite Unit

test-integration:
	$(COMPOSE_DEV) exec -T php vendor/bin/phpunit --testsuite Integration

danger-prune:
	sudo docker system prune -a --volumes

dev-danger-prune:
	sudo docker system prune -a --volumes
