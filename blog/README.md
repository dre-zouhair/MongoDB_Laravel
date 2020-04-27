## starting the project
    In case your Laravel version does NOT autoload the packages, add the service provider to `config/app.php`:
    
    ```php
    Jenssegers\Mongodb\MongodbServiceProvider::class,
    ```
    php artisan config:claer
    php artisan view:clear
    php artisan cache:clear
    create a database with the name <medicine>
    php artisan migrate
    in mongo shel execute this 
    php artisan serve
