# Adoptopia (Backend)

## version 1.1.0

# เกี่ยวกับ project

>

## ผู้จัดทำ

-   อารียา สังข์ทอง 6210400752
-   นายชยางกูร ฤทธิเดช 6210402381
-   นายณรงค์ฤทธ์ ธรรมปาโล 6210402402
-   สิรวิชญ์ วงษ์ศุทธิภากร 6210406700

#

### Project-Adoptopia (frontend) => https://github.com/Ford-Narongrit/Adoptopia-frontend

### Project-Adoptopia (Backend) => https://github.com/Ford-Narongrit/Adoptopia-backend

# Project setup in Local

```bash
composer install
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

## create JWT

```bash
php artisan jwt:secret
```

## Run Development

```bash
php artisan serve
```
