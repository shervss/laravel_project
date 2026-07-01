# laravel_project

A Laravel 13 learning project built with Docker, Livewire, Spatie Roles and Permissions, and Spatie Activity Logs.

## Features

- Dockerized Laravel development environment
- Livewire-powered Todo pages
- Spatie Roles and Permissions with teams enabled
- Role and permission enums for cleaner access control
- Permission-protected routes
- Spatie Activity Log integration
- Advanced Todo activity logging with old/new value tracking
- Activity Logs page for viewing recorded model changes
- Temporary local dev login route for testing protected pages

## Tech Stack

- PHP 8.5
- Laravel 13
- Livewire 4
- MySQL 8
- Redis
- Laravel Horizon
- Laravel Reverb
- Docker Compose
- Nginx
- PHP-FPM
- Spatie Laravel Permission
- Spatie Laravel Activitylog

## Quick Start

Start the Docker containers:

```bash
docker compose up -d
```

Run migrations and seeders:

```bash
docker compose exec app php artisan migrate:fresh --seed --force
```

Clear cached files:

```bash
docker compose exec app php artisan optimize:clear
```

Open the application:

```text
http://127.0.0.1
```

Use the temporary local dev login:

```text
http://127.0.0.1/dev-login
```

Then view activity logs:

```text
http://127.0.0.1/activity-logs
```

## Architecture

The project uses Docker Compose to run the Laravel application and supporting services.

```text
Browser
  |
  v
Nginx container
  |
  v
PHP-FPM Laravel app container
  |
  +--> MySQL container
  |
  +--> Redis container
  |
  +--> Horizon worker
  |
  +--> Reverb websocket server
```

Main application areas:

```text
app/Enums                  Role and permission enums
app/Http/Middleware        Permission team context middleware
app/Models                 User and Todo models
config/permission.php      Spatie Permission configuration
config/activitylog.php     Spatie Activitylog configuration
database/migrations        Database schema
database/seeders           User, role, and permission seeders
resources/views            Blade and Livewire views
routes/web.php             Web routes and protected pages
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

Rebuild containers:

```bash
docker compose up -d --build
```

Run migrations and seeders:

```bash
docker compose exec app php artisan migrate:fresh --seed --force
```

Clear Laravel cache:

```bash
docker compose exec app php artisan optimize:clear
```

Reset Spatie permission cache:

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

Check running containers and ports:

```bash
docker compose ps
```

## How It Was Built (Step by Step)

### 1. Laravel Scaffold

The project started from a fresh Laravel application.

```bash
composer create-project laravel/laravel
```

The Laravel app was then prepared for local development using Docker Compose.

### 2. Docker Compose Setup

Docker Compose was configured with the following services:

- `app` for the Laravel PHP-FPM application
- `nginx` for serving the Laravel public directory
- `db` for MySQL 8
- `redis` for Redis
- `horizon` for Laravel Horizon
- `reverb` for Laravel Reverb

The main local app URL is:

```text
http://127.0.0.1
```

### 3. Livewire Setup

Livewire was added and used for the Todo pages.

Current Todo routes include:

```text
/todos
/todos/create
/todos/{todo}
/todos/{todo}/edit
/todos/{todo}/delete
```

### 4. Database, Migrations, and Seeders

Database migrations were created for the application tables, including:

- Users
- Cache
- Jobs
- Students
- Todos
- Spatie permission tables
- Spatie activity log table

Seeders were added for:

- Student data
- Roles and permissions
- Default test user

### 5. Spatie Roles and Permissions

Spatie Laravel Permission was installed and configured.

Teams were enabled in:

```php
config/permission.php
```

```php
'teams' => true,
```

The `User` model was updated to use:

```php
use Spatie\Permission\Traits\HasRoles;
```

Roles added:

```text
super admin
admin
user
```

Permissions added:

```text
view todos
create todos
update todos
delete todos
view activity logs
```

Enums were created for cleaner permission usage:

```text
app/Enums/RoleEnum.php
app/Enums/PermissionEnum.php
```

Example permission check:

```php
$user->can(\App\Enums\PermissionEnum::VIEW_TODOS->value);
```

### 6. Permission-Protected Routes

Spatie permission middleware was registered in:

```text
bootstrap/app.php
```

Todo and Activity Log routes were protected using permission middleware.

Example:

```php
->middleware('permission:'.PermissionEnum::VIEW_ACTIVITY_LOGS->value)
```

### 7. Team Context Middleware

Because Spatie teams are enabled, a middleware was added to set the current permission team context.

File:

```text
app/Http/Middleware/SetPermissionsTeam.php
```

It sets the team context from session data and defaults to team `1`.

### 8. Spatie Activity Log Setup

Spatie Laravel Activitylog was installed and configured.

The activity log migration and config were published:

```text
config/activitylog.php
database/migrations/*_create_activity_log_table.php
```

The `Todo` model was configured to log selected attributes.

Logged Todo attributes:

```text
title
description
completed
```

### 9. Advanced Activity Logging

The `Todo` model tracks old and new values for updates.

Example activity output:

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

This allows the app to display what changed during create, update, and delete actions.

### 10. Activity Logs Page

An Activity Logs page was added at:

```text
/activity-logs
```

This page displays:

- Log description
- Event type
- Subject model
- Old values
- New values

The route is protected by:

```text
view activity logs
```

### 11. Temporary Dev Login

A temporary local dev login route was added for testing protected pages.

```text
/dev-login
```

It logs in the seeded test user:

```text
Email: test@example.com
Role: super admin
Team ID: 1
```

This route is only intended for local development and testing.

## Test User

```text
Email: test@example.com
Password: password
Role: super admin
Team ID: 1
```

## Notes

- Use `http://127.0.0.1` for browser testing.
- `localhost` may show Apache depending on the local machine setup.
- The `/dev-login` route is for local development only.
- Do not commit `.env`.
- Remove accidental local files before committing.
