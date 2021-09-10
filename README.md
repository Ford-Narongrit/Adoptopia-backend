# Adoptopoia-Backend

> เว็บขายดีไซน์

* API สำหรับ front-end => https://github.com/Ford-Narongrit/Adoptopia-frontend

## version 1.0.0

## Public API
* `GET` `/api/user`
* `GET` `/api/user/{id}`

## Setup
```bash
cp .env.example .env
php artisan key:generate
```
## Migration
```bash
php artisan migrate --seed
```
## Development

```bash
composer install
php artisan serve
```