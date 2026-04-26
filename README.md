# PHP API + React SPA Boilerplate

This repository is a lightweight starter for building a React single-page app backed by a custom PHP JSON API.

- Backend: PHP 8 (session-based auth, `/api/*` routes)
- Frontend: React + Vite + Tailwind (served at `/` via `public/spa.php`)
- Local runtime: Docker Compose (base + dev overlay)

## Architecture at a glance

- API entry: `public/index.php`
- SPA shell: `public/spa.php`
- API controllers: `app/controllers/Api/`
- Frontend source: `frontend/`
- Compose base stack: `docker-compose.yaml`
- Compose dev overlay: `docker-compose.dev.yaml`

## Prerequisites

- Docker + Docker Compose plugin
- GNU Make
- A local `.env` file (copy from `.env.example`)

## Quick start (recommended)

1) Create local environment file

```bash
cp .env.example .env
```

2) Start the dev stack

```bash
make dev-up
```

3) Install PHP dependencies inside the container

```bash
make composer-install
```

4) Run database migrations

```bash
make migrate
```

5) Seed initial admin user (interactive email/password prompt)

```bash
make seed-admin
```

6) Open the app

- App: `http://localhost:8080`
- Vite dev server: `http://localhost:5173`
- Test app: `http://localhost:8081`

## Make aliases

Run `make help` to see all commands. Most-used commands:

- `make dev-up` start base + dev overlay stack
- `make dev-down` stop dev stack
- `make dev-ps` show dev service status
- `make dev-logs` tail logs
- `make dev-build` rebuild images
- `make composer-install` run Composer install in `php`
- `make migrate` run migrations (`up`)
- `make migrate-down` rollback latest migration batch
- `make migrate-fresh` drop all tables and rerun migrations
- `make seed-admin` create initial admin account interactively
- `make test` run full PHPUnit suite
- `make test-feature` run feature tests
- `make test-unit` run unit tests
- `make test-integration` run integration tests

Base-stack only commands are also available (`make up`, `make down`, `make ps`, etc.) if you need a production-like stack without dev services.

## Docker compose model

- `docker-compose.yaml`: base services (`db`, `php`, `nginx`)
- `docker-compose.dev.yaml`: dev services/overrides (`node`, `php_test`, `nginx_test`, bind mounts)

Equivalent command to bring up the dev stack manually:

```bash
docker compose -f docker-compose.yaml -f docker-compose.dev.yaml up --build
```

## Environment variables

Start from `.env.example`. Key app/database values include:

- `APP_ENV`, `APP_DEBUG`, `APP_URL`, `APP_NAME`, `APP_DESC`
- `DB_DRIVER`, `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`
- `VITE_DEV_SERVER`

Optional Docker-related overrides in `.env.example`:

- `APP_PORT`, `DB_PORT_HOST`, `TEST_APP_PORT`, `VITE_PORT`, `MARIADB_ROOT_PASSWORD`

## Verification checklist

After setup, these should work:

```bash
curl -s http://localhost:8080/api/health/index
curl -s http://localhost:8080/api/auth/me
curl -s http://localhost:8080/api/posts
```

Expected behavior:

- health endpoint returns `{ "ok": true, ... }`
- `auth/me` returns `{ "user": null }` when logged out
- posts endpoint returns a posts payload

## Troubleshooting

- If PHP dependencies are missing: run `make composer-install`
- If schema is out of sync: run `make migrate` (or `make migrate-fresh` in local dev)
- If frontend assets are stale: restart node/nginx and hard-refresh browser
- If containers fail unexpectedly, check `make dev-logs` and `make dev-ps`

## Common daily workflow

Start your day:

```bash
make dev-up
make composer-install
make migrate
```

While developing:

```bash
make test
```

Or run narrower suites when needed:

```bash
make test-unit
make test-feature
```

When you are done:

```bash
make dev-down
```

## Safety note

`make danger-prune` and `make dev-danger-prune` run:

```bash
sudo docker system prune -a --volumes
```

This is destructive and removes stopped containers, images, networks, and volumes.
