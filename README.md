# BackendPresentationMaker
A backend API for an online presentation maker service to speedup making presentations.


### Framework: PHP/Laravel
To run composer: 

    php composer.phar require spatie/laravel-permission    

To run the containers:

    docker-compose -f docker-compose-dev.yaml up -d

To re-build and run the container images:

    docker-compose -f docker-compose-dev.yaml up -d --build

To load a dump (e.g. from the path `./dumps/dump.sql`):

    docker exec -i presentation-postgres-service bash -c '/usr/local/bin/psql -U $POSTGRES_USER $POSTGRES_DB' < ./dumps/dump.sql

To create a dump:

    docker exec -i presentation-postgres-service bash -c '/usr/local/bin/pg_dump --inserts -U $POSTGRES_USER $POSTGRES_DB' > ./dumps/`/bin/date +'%Y%m%d%H%M%S'`_dump.sql

To run composer:

    docker exec -it presentation-apache-php-service bash

To Enter docker-php-apache-container, install composer dependencies and migrate the database:

    docker exec -it presentation-apache-php-service bash
    composer install
    php artisan migrate

To create a new user/password from command line:

    php artisan tinker
    User::factory()->create(['email'=>'peiman.kurehpaz@gmail.com','name'=>'Peyman','password'=>bcrypt('123456')]);


To Link the storage:

    php artisan storage:link

To re produce the api documentations:

    php artisan scribe:generate

To Make a new Policy:

    php artisan make:policy CategoryPolicy --model=Category

To Make a migration file:

    php artisan make:migration create_flights_table

To show the status of the latest migration:

    php artisan migrate:status

To seed data with migrations:

    php artisan migrate:refresh --seed

To make a new database model with migration file, controller and json resource:

    php artisan make:model ModelName -mcr

To create a factory for a database model object:

    php artisan make:factory ModelFactory

To create a php feature test for testing:

    php artisan make:test FeatureNameTest

To show available routes:

    php artisan route:list

To create Resource controller for a model with request:

    php artisan make:controller ModelController --model=ModelName --resource --requests --api

To create JsonResource Collection:

    php artisan make:resource User --collection

To generate a factory for a model:

    php artisan make:ory PostFactory

To automatically generate random content for db:

    php artisan db:seed --class=PermissionSeeder
    php artisan db:seed --class=RoleSeeder

To generate a fake instance of a model in a database using factory and tinker:

    php artisan tinker
    User::factory()->count(5)->create()
    App\Models\Project::factory()->count(5)->create()

To run all test cases:

    vendor/bin/phpunit
    vendor/bin/phpunit --filter TestName

To start the queue process behind the scenes:

    php artisan queue:work &

To start the queue process on screen:

    php artisan queue:work
