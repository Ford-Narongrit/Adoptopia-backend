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
go to folder [project](https://github.com/Ford-Narongrit/Adoptopia-backend/tree/main/project)

# Project setup with Docker
1. สร้าง folder สำหรับ Database Mysql => `mkdir mysql`
2. สั่งสร้าง image และ container ตามลำดับ => ``docker-compose build && docker-compose up -d``
3. เช็คว่า container run ทุกตัวหรือไม่ => ``docker ps``
4.  ```bash
    cd ./src
    cp .env.example .env
    docker-compose exec php composer update
    docker-compose exec php php artisan key:generate
    docker-compose exec php php artisan JWT:secret
    ```
5. ลองเข้าไปที่ http://localhost:8088 เพื่อดูผลลัพธ์

## Migrate 

1. เข้าไปแก้ไข .env ให้ DB_HOST=mysql เพื่อเชื่อมกับ container mysql
2. นำค่าของ environment ของ mysql มาใส่ลงใน .env (DB_DATABASE, DB_DATABASE, DB_PASSWORD)
3. `docker-compose exec php php artisan storage:link`
4. สั่ง ``docker-compose exec php php artisan migrate --seed`` เพื่อ migrate ตารางใน Mysql container
5. ลองเรียก API 