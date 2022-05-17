## Installation

- First clone this Repo
- Go to project directory
- Run composer `composer install`
- Copy env file `cp .env.example .env`
- Generate laravel key `php artisan key:generate`
- Configure database in .env file
- Set API key of GOOGLE SAFE BROWSINF API as GOOGLE_APP_API_KEY in .env file
- Run migrate with seeder `php artisan migrate:fresh --seed`
- Install passport `php artisan passport:install`
- Project run `php artisan serve --port 8000`
