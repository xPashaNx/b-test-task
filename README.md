# Test Task

## Installation
### Prepare build
    cp .env.example .env && cp api/.env.example api/.env

### Start containers
    make init
    make up
    
    // use docker
    docker-compose build
    docker-compose up -d

### Composer шnstallation
    make api-composer-install

    // use docker
    docker-compose run --rm api-php-fpm composer install

### Migrate
    make api-migrations-migrate

    // use docker
    docker-compose run --rm api-php-fpm php bin/console doctrine:migrations:migrate --no-interaction

### Loading fixtures
    make api-fixture-load

    // use docker
    docker-compose run --rm api-php-fpm php bin/console doctrine:fixtures:load

# Database schema
![Screenshot_20230129_172956.png](..%2F..%2F%D0%98%D0%B7%D0%BE%D0%B1%D1%80%D0%B0%D0%B6%D0%B5%D0%BD%D0%B8%D1%8F%2FScreenshot_20230129_172956.png)

# Testing
[testRequest.http](api%2FtestRequest.http) for API testing