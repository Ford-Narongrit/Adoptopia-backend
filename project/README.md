# Adoptopia (Backend)

## version 1.2.0

# เกี่ยวกับ project

Adoptopia เป็นเว็บไซต์สำหรับผู้ที่ชื่นชอบหรือสนใจในอดอปและต้องการพื้นที่ในการแลกเปลี่ยนอดอป (OTA), ซื้อ-ขายอดอป (SP) และแจกอดอป (DTA)
    อดอป คือ สิ่งที่มีการออกแบบ โดยจะเป็นคน, สัตว์, สิ่งของ หรืออะไรก็ได้ที่ผู้สร้างมีการสร้างสรรค์ออกแบบขึ้นมา
    OTA ย่อมาจาก Offer to Adop คือ การแลกเปลี่ยนอดอป โดยเจ้าของโพสต์จะตั้งโพสต์เพื่อแสดงอดอปที่ต้องการจะแลกเปลี่ยน ซึ่งผู้ที่สนใจต้องเสนออดอปที่จะนำมาแลกเปลี่ยน และหากเจ้าของโพสต์ชื่นชอบอดอปตัวใดของผู้เสนอ ก็จะนำมาแลกเปลี่ยนอดอปกัน
    DTA ย่อมาจาก Draw to Adop คือ การแจกอดอป โดยผู้ที่แจกหรือเจ้าของโพสต์จะตั้งโพสต์เพื่อแสดงอดอปที่จะแจก ซึ่งผู้ที่สนใจอดอปตัวนั้นจะต้องวาดภาพเพื่อเสนอ และหากเจ้าของโพสต์ชื่นชอบภาพวาดของผู้เสนอคนใด ก็จะยกอดอปให้
    SP ย่อมาจาก Set Price หรือ For Sale คือ การขายอดอป

## ผู้จัดทำ

-   อารียา สังข์ทอง 6210400752
-   ชยางกูร ฤทธิเดช 6210402381
-   ณรงค์ฤทธ์ ธรรมปาโล 6210402402
-   สิรวิชญ์ วงษ์ศุทธิภากร 6210406700

#

### Project-Adoptopia (frontend) => https://github.com/Ford-Narongrit/Adoptopia-frontend

### Project-Adoptopia (Backend) => https://github.com/Ford-Narongrit/Adoptopia-backend

# Run Test project
```bash
php artisan test
```
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
