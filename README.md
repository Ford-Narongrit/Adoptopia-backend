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