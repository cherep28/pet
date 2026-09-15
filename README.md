# News API

Educational Laravel 13 REST API for news. PHP 8.3+ (developed on PHP 8.4), SQLite.

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan db:seed
php artisan serve
```

The seeder adds 25 news records on every run. No frontend build is required for the API.
The example environment uses file sessions/cache and a synchronous queue.
Authentication is not implemented; this is a local learning project.

## Endpoints

| Method | URL | Action |
| --- | --- | --- |
| GET | /api/news | List, pagination and title search |
| GET | /api/news/{id} | Read by ID |
| GET | /api/news/slug/{slug} | Read by slug |
| POST | /api/news | Create |
| PATCH | /api/news/{id} | Partial update |
| DELETE | /api/news/{id} | Delete |

Send `Accept: application/json` and `Content-Type: application/json`.
List example: `/api/news?search=Laravel&per_page=10&page=1`.
Slugs are generated on the server from titles.

## Checks and documentation

```bash
php artisan route:list --path=api/news
php artisan test
```

Automatic API documentation (Scramble): `/docs/api`.
Manual OpenAPI files in `app/OpenApi` are still an exercise in progress.
The remaining example tests do not constitute full News API coverage.

## Git

`.env`, SQLite files and backups, dependencies, logs and generated documentation
are excluded. Keep `composer.lock` and `.env.example` in the repository.
Install dependencies and run migrations after cloning; never publish your local database.

The repository is initialized locally. Before the first commit:

```bash
git status
git add .
git diff --cached --stat
git commit -m "Initial news API"
```

Add your own remote repository URL before pushing.
