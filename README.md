# app-nacion
Pre-Requisitos para la instalacion
Php >= 7.3
Composer 2.0
Instalar MariaDB, Postgresql o cualquier otro motor de base de datos relacional.


Quitar la extension del env.example, de manera que quede solo .env
Editar los valores 

DB_USERNAME=user
DB_PASSWORD=secret

colocando el usuario y password de la base de datos

Ubicarse en el directorio donde se clono el repositorio y ejecutar por consola  los siguientes comandos respetando el orden: 
composer install
php artisan migrate
php artisan db:seed
php artisan serve //En este punto ya la aplicacion se encuentra corriendo

A efectos de documentacion, se instalo el plugin de swagger mediante el cual una vez iniciada la aplicacion se puede consultar en http://localhost:8000/api/documentation


