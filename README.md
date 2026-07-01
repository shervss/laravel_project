# laravel_project

A Laravel 13 learning project built with Docker, Livewire, Spatie Roles and Permissions, and Spatie Activity Logs.

## Tech Stack

- PHP 8.5
- Laravel 13
- Livewire 4
- MySQL 8
- Redis
- Laravel Horizon
- Laravel Reverb
- Docker Compose
- Spatie Laravel Permission
- Spatie Laravel Activitylog

## Features

- Dockerized Laravel development environment
- Livewire Todo pages
- Spatie Roles and Permissions with teams enabled
- Role and permission enums
- Protected routes using permission middleware
- Spatie Activity Log setup
- Advanced Todo activity logging with old/new attribute tracking
- Activity Logs page
- Temporary local dev login route for testing protected pages

## Requirements

- WSL
- Docker Desktop
- Git
- Composer
- Node.js and npm

## Installation

Clone the repository:

```bash
git clone <repository-url>
cd mangulabnan_cliqueha
```

Copy the environment file:

```bash
cp .env.example .env
```

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

Start Docker containers:

```bash
docker compose up -d --build
```

Generate the Laravel app key:

```bash
docker compose exec app php artisan key:generate
```

Run migrations and seeders:

```bash
docker compose exec app php artisan migrate:fresh --seed --force
```

Clear cached files:

```bash
docker compose exec app php artisan optimize:clear
```

## Application URLs

Use this URL for the Laravel app:

```text
http://127.0.0.1
```

Important local ports:

```text
Laravel/Nginx: http://127.0.0.1
MySQL: 127.0.0.1:3307
Redis: 127.0.0.1:6379
Reverb: 127.0.0.1:8080
```

Note: If `localhost` shows an Apache default page, use `127.0.0.1` instead.

## Test User

The seeder creates a test user:

```text
Email: test@example.com
Password: password
Role: super admin
Team ID: 1
```

## Dev Login

A temporary local dev login route is available for testing protected pages:

```text
http://127.0.0.1/dev-login
```

This route logs in `test@example.com`, sets the Spatie team context to `1`, and redirects to the Activity Logs page.

## Main Routes

```text
/                       Welcome page
/todos                  Todo index
/todos/create           Create Todo page
/todos/{todo}           View Todo page
/todos/{todo}/edit      Edit Todo page
/todos/{todo}/delete    Delete Todo page
/activity-logs          Activity Logs page
/dev-login              Temporary local test login
```

## Spatie Roles and Permissions

The project uses Spatie Laravel Permission with teams enabled.

Roles:

```text
super admin
admin
user
```

Permissions:

```text
view todos
create todos
update todos
delete todos
view activity logs
```

Permission checks use enums:

```php
$user->can(\App\Enums\PermissionEnum::VIEW_TODOS->value);
```

When using teams, set the team context:

```php
setPermissionsTeamId(1);
```

## Spatie Activity Logs

The `Todo` model logs selected attributes:

```text
title
description
completed
```

Activity logs track:

- Created events
- Updated events
- Deleted events
- Old and new attribute values

Example Tinker check:

```bash
docker compose exec app php artisan tinker
```

```php
$todo = \App\Models\Todo::create([
    'title' => 'Original name',
    'description' => 'Lorem',
    'completed' => false,
]);

$todo->update([
    'title' => 'Updated name',
    'completed' => true,
]);

$activity = \Spatie\Activitylog\Models\Activity::where('event', 'updated')->latest()->first();

$activity->attribute_changes->toArray();
```

Expected result:

```php
[
    'old' => [
        'title' => 'Original name',
        'completed' => false,
    ],
    'attributes' => [
        'title' => 'Updated name',
        'completed' => true,
    ],
]
```

## Useful Commands

Start containers:

```bash
docker compose up -d
```

Stop containers:

```bash
docker compose down
```

Run migrations and seeders:

```bash
docker compose exec app php artisan migrate:fresh --seed --force
```

Clear cache:

```bash
docker compose exec app php artisan optimize:clear
```

Reset permission cache:

```bash
docker compose exec app php artisan permission:cache-reset
```

Open Tinker:

```bash
docker compose exec app php artisan tinker
```

View routes:

```bash
docker compose exec app php artisan route:list
```

Run tests:

```bash
docker compose exec app php artisan test
```

## Git Workflow

Branch naming standard:

```text
feature/SM-description
bugfix/SM-description
hotfix/SM-description
```

Example branch:

```bash
git checkout -b feature/SM-spatie-roles-permissions-activity-logs
```

Commit naming standard:

```text
feat: new feature
fix: bug fix
chore: config or maintenance
docs: documentation only
refactor: code change without feature or bug fix
test: adding or fixing tests
```

Example commit:

```bash
git commit -m "feat: add spatie roles permissions and activity logs"
```

Push branch:

```bash
git push -u origin feature/SM-spatie-roles-permissions-activity-logs
```

## Notes

- Use `127.0.0.1` for browser testing.
- `localhost` may point to Apache depending on the local machine setup.
- The `/dev-login` route is only for local development/testing.
- Do not commit `.env`.
- Remove accidental local files before committing.
