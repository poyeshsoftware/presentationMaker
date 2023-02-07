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

OR

<code>
docker run --rm --interactive --tty \
--volume $PWD:/app \
--volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp \
composer 
</code>

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

    php artisan make:model Project -mcr
    php artisan make:model Slide -mcr
    php artisan make:model Reference -mcr
    php artisan make:model Button -mcr
    php artisan make:model Scroll -mcr
    php artisan make:model Menu -mcr
    php artisan make:model MenuItem -mcr
    php artisan make:model TrackingCode -mcr
    php artisan make:model Document -mcr
    php artisan make:model SubscriptionPlan -mcr
    php artisan make:model Image -mcr
    php artisan make:model ImageDimension -mcr

To create a factory for a database model object:

    php artisan make:factory ModelFactory

To create a php feature test for testing:

    php artisan make:test FeatureNameTest

To show available routes:

    php artisan route:list

To create Resource controller for a model with request:

    php artisan make:controller SuperCategoryController --model=SuperCategory --resource --requests --api

To create JsonResource Collection:

    php artisan make:resource User --collection

To generate a factory for a model:

    php artisan make:ory PostFactory

To automatically generate random content for db:

    php artisan db:seed --class=RandomContentSeeder
    php artisan db:seed --class=ExampleContentSeeder
    php artisan db:seed --class=PermissionSeeder
    php artisan db:seed --class=RoleSeeder

To generate a fake instance of a model in a database using factory and tinker:

    php artisan tinker
    User::factory()->count(5)->create()
    App\Models\Project::factory()->count(5)->create()
    App\Models\Document::factory()->count(5)->create()
    App\Models\Image::factory()->count(5)->create()
    App\Models\Slide::factory()->count(5)->create()
    App\Models\Reference::factory()->count(5)->create()

To run all test cases:

    vendor/bin/phpunit
    vendor/bin/phpunit --filter SuperCategoriesApiTest
    vendor/bin/phpunit --filter WorkoutsApiTest
    vendor/bin/phpunit --filter TrainersApiTest
    vendor/bin/phpunit --filter SearchWorkoutsApiTest
    vendor/bin/phpunit --filter FilterWorkoutsApiTest
    vendor/bin/phpunit --filter WorkoutsApiTranslation
    vendor/bin/phpunit --filter TrainersApiTranslationTest

To start the queue process behind the scenes:

    php artisan queue:work &

To start the queue process on screen:

    php artisan queue:work

To generate SSH key:

    ssh-keygen -t rsa -b 4096 -C "api.presentationworkouts.de@exoscale"

To install Docker on Ubuntu:

    sudo apt-get update
    sudo apt-get install ca-certificates curl gnupg lsb-release
    sudo mkdir -p /etc/apt/keyrings
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
    sudo apt-get update
    sudo apt-get install docker-ce docker-ce-cli containerd.io docker-compose-plugin

To install Docker Compose on Ubuntu with x64 architecture:

    sudo curl -L "https://github.com/docker/compose/releases/download/v2.12.0/docker-compose-linux-x86_64" -o /usr/local/bin/docker-compose
    sudo chmod +x /usr/local/bin/docker-compose
