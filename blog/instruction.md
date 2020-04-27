 cd into your project
```bash
cd blog
```
fresh the cloned project
```bash
php artisan config:claer
php artisan view:clear
php artisan cache:clear
```
Install Composer Dependencies
```bash
composer install
```
Generate an app encryption key
```bash
php artisan key:generate
```
one more time :D
```bash
php artisan cache:clear
```
Create a copy of your .env file
```bash
cp .env.example .env
```
Create an empty database for our application with the name <medicine>
then run this
```bash
php artisan migrate
```
in mongo shel execute this 
```jacascript
db.getCollection("users").insert({
    "name": "Drioueche Zouhair",
    "email": "dre.zouhair@gmail.com",
    "password": "$2y$10$cPT.M.Gyv5eZzCYvQ4/Kb.kfjXbND2z0O67u67BhW8DK//vSxiMzy",
    "updated_at": ISODate("2020-04-27T01:27:40.564+00:00"),
    "created_at": ISODate("2020-04-26T21:58:23.993+00:00"),
    "cin": "pharmacist",
    "phone": "062598143289",
    "profession": "pharmacist",
    "remember_token": "",
    "is_admin": 1
});
```
run this in the terminal
```bash
php artisan serve
```
Login credentiels
    email : dre.zouhair@gmail.com
    password : 12345678
ENJOY ! 
