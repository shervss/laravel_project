# Laravel Project

A Laravel 13 starter project configured with a modern Docker development environment. This project uses PHP 8.5, Livewire v4, MySQL, Redis, Horizon, Reverb, and Nginx to provide a complete local development setup.

## Features

- Laravel 13
- PHP 8.5
- Livewire v4
- MySQL 8
- Redis 7
- Laravel Horizon
- Laravel Reverb
- Nginx
- Docker & Docker Compose
- Vite Asset Bundler

---

## Prerequisites

Before running this project, make sure you have the following installed:

- Docker Desktop
- WSL 2 (Ubuntu recommended)
- Git

For Windows users:

- Enable **WSL Integration** in Docker Desktop.
- Make sure Docker Engine is running.

---

## Clone the Repository

```bash
git clone git@github.com:shervss/laravel_project.git
```

Go to the project directory:

```bash
cd laravel_project
```

---

## Configure Environment

Copy the example environment file:

```bash
cp .env.example .env
```

Update the necessary environment variables if needed.

---

## Build Docker Containers

```bash
docker compose build
```

---

## Start the Development Environment

```bash
docker compose up -d
```

Verify that all services are running:

```bash
docker compose ps
```

Expected services:

- laravel_app
- laravel_nginx
- laravel_mysql
- laravel_redis
- laravel_horizon
- laravel_reverb

---

## Generate Application Key

```bash
docker compose exec app php artisan key:generate
```

---

## Run Database Migrations

```bash
docker compose exec app php artisan migrate
```

---

## Install JavaScript Dependencies

```bash
docker compose exec app npm install
```

Build assets:

```bash
docker compose exec app npm run build
```

---

## Access the Application

Laravel Application

```
http://127.0.0.1
```

Laravel Horizon

```
http://127.0.0.1/horizon
```

---

## Useful Commands

Start containers

```bash
docker compose up -d
```

Stop containers

```bash
docker compose down
```

Restart containers

```bash
docker compose restart
```

View running containers

```bash
docker compose ps
```

View logs

```bash
docker compose logs
```

Laravel Artisan

```bash
docker compose exec app php artisan
```

Run migrations

```bash
docker compose exec app php artisan migrate
```

Clear caches

```bash
docker compose exec app php artisan optimize:clear
```

Redis Ping

```bash
docker compose exec redis redis-cli -a redis ping
```

---

## Technology Stack

- Laravel 13
- PHP 8.5
- Livewire v4
- MySQL 8
- Redis 7
- Laravel Horizon
- Laravel Reverb
- Nginx
- Docker
- Docker Compose
- Vite

---

## Project Structure

```
app/
bootstrap/
config/
database/
docker-compose.yml
Dockerfile
nginx/
public/
resources/
routes/
scripts/
storage/
```

---

## Development Workflow

1. Pull the latest changes.

```bash
git pull
```

2. Start Docker.

```bash
docker compose up -d
```

3. Make your changes.

4. Commit using Conventional Commits.

Example:

```bash
git commit -m "feat: implement user authentication"
```

5. Push your feature branch.

```bash
git push
```

6. Create a Pull Request and merge into `main`.

