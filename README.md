# Laravel 9

# Microservice_book_product_laravel
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Project - Cometa Chat 
## Micriservice - Book and product service
## Applied technologies:
### swagger:
https://swagger.io/     
https://github.com/DarkaOnLine/L5-Swagger/wiki/Installation-&-Configuration
### jwt-auth 
https://jwt-auth.readthedocs.io/en/develop/

## How to install:
- clone this project
- install vendor laravel

composer install
```
- make env
```bash
cp .env.example .env
```
- generate key
```bash
php artisan key:generate
```
- run migrations
```bash
php artisan migrate --seed
```
- install vendor javascript
```bash
npm install
```
- build manifest
```bash
npm run build
```
## Run project:
# Setup - Docker is required

```
composer install
vendor/bin/sail up -d
```

## Stubs Crud Simplify

To create a fast crud with tests and open-api documentation with stubs customized:
`php artisan make:model -c -f -m --api -R --test Product`

Or

- start server
```bash
php artisan server
```

- check connection <br>
http://localhost:8000
## NOTE

- Default Password user : vldmr1@gmail.com<br>
- - Default Password user : mvlju977@gmail.com<br>
```php
password: 1234567890
```

# Setup - Docker is required

```
composer install
vendor/bin/sail up -d
```

## Stubs Crud Simplify

To create a fast crud with tests and open-api documentation with stubs customized:
`php artisan make:model -c -f -m --api -R --test Product`
# identityservice_swagger_jwt_laravel_2
# microservice-book-jwt-swagger-laravel
