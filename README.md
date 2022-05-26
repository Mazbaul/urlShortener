
## Description

The project is developed by Laravel 9. Laravel Repository Pattern is used for development. Laravel Passport is used for API authentication. Frontend is developed by Vue3 in CLI mode. The API of GOOGLE SAFE BROWSING is used for url safety check. In development, SOLID design principles are fully followed for coding.Frontend Repo Link(https://github.com/Mazbaul/urlShortenerfrontendvue).

## Installation

- First clone this Repo
- Go to project directory
- Run composer `composer install`
- Copy env file `cp .env.example .env`
- Generate laravel key `php artisan key:generate`
- Configure database in .env file
- Set API key of GOOGLE SAFE BROWSINF API as GOOGLE_APP_API_KEY in .env file
- Run migrate with seeder `php artisan migrate`
- Install passport `php artisan passport:install`
- Project run `php artisan serve --port 8000`
