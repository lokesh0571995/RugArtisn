<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.


## Quick Start Project Api setup

i have worked on this project "laravel/framework": "^9.19", version and php version "php": "^8.0.2", 

1. First Take a pull your local system 
2. composer install
3. install a authentacation for passport => composer require laravel/passport
4. create databse and set .env file
5. Run php artisan migrate command for migration all table in database
6. Run php artisan passport:install command
7. Run seeder php artisan db:seed --class=UserSeeder command for Admin dummy data store
8. Run php artisn serve command and run project in local server
9. Set local url in your postman 
10. Create User Register and login user.
11. Set Header data like content-type, authorization and accept parameter and pass login user token perform add user transaction data store in database (create/update/get list)
12. And admin login token add get users transaction data list and delete user transaction based on transaction id and other delete specific user all transaction using user id.
<br>
 Admin Login :
    <br>
    email : admin@gmail.com
    password : 12345678
  
13. This type local url set api path
    
    A. Auth Api Path
    <strong>http://127.0.0.1:8000/api/register</strong>
    <strong>http://127.0.0.1:8000/api/login</strong>
    <strong>http://127.0.0.1:8000/api/logout</strong>

    B. User Api Path
    <strong>http://127.0.0.1:8000/api/user/store</strong>
    <strong>http://127.0.0.1:8000/api/user/update/{transaction_id}</strong>
    <strong>http://127.0.0.1:8000/api/user/list?user_id=2</strong>

    C. Admin Api Path

    <strong>http://127.0.0.1:8000/api/admin/all-transaction-list</strong>
    <strong>http://127.0.0.1:8000/api/admin/delete?transaction_id=6</strong>
    <strong>http://127.0.0.1:8000/api/admin/user-all-transaction-delete?user_id=2</strong>
