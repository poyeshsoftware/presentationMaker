Copy .env.example to .env and set your database credentials

    cp .env.example .env

Run composer:

    php composer.phar require spatie/laravel-permission

Run the containers:

    docker-compose -f docker-compose-dev.yaml up -d

Migrate data with migrations:

    php artisan migrate:refresh

Seed roles and permissions generate random content for db:

    php artisan db:seed --class=PermissionSeeder
    php artisan db:seed --class=RoleSeeder

Create a new user/password from command line:

    php artisan tinker
    User::factory()->create(['email'=>'peiman.kurehpaz@gmail.com','name'=>'Peyman','password'=>bcrypt('123456'), 'role' => 9]);

Re-create the api documentations:

    php artisan scribe:generate

Run the project:

    php artisan serve

Access Documentation:

    http://localhost:8000/docs


