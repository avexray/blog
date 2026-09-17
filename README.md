### BLOG

Installation instructions:

1. Run container: `docker-compose up`
2. Install dependencies: `composer install`
3. Fill `.env` file with DB credentials
4. Connect to container: `docker exec -it blog-php-fpm bash`
5. Give access rights: `chown -R www-data:www-data /application/runtime/ /application/public/`
6. Seed DB: `php -f seeder/seeder.php`
7. Compile frontend: `php -f frontend/compiler.php`