# Adoptopoia-Backend

> เว็บขายดีไซน์

-   API สำหรับ front-end => https://github.com/Ford-Narongrit/Adoptopia-frontend

## version 1.0.0

## Public API

- `GET` `/api/user`
- `GET` `/api/user/{id}`

## Auth API
- `POST` `/api/auth/login`
- `POST` `/api/auth/me`

ข้อมูลที่ต้องส่งมา
```JSON
body {
    "validate": "",
    "password": ""
}
```

## Setup

```bash
cp .env.example .env
php artisan key:generate
```

## Migration

```bash
php artisan migrate --seed
```

## Storage Symbolic Link

```bash
php artisan storage:link
```

## Development

```bash
composer install
php artisan serve
```
