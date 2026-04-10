# CarZone API

CarZone is a web application built with the Laravel framework.

## Requirements
- PHP (minimum version required by Laravel)
- Composer
- Node.js & NPM

## Installation

1. Clone the repository or extract the project files.
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install frontend dependencies and build them:
   ```bash
   npm install
   npm run build
   ```
4. Copy the environment file and configure your database settings (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`):
   ```bash
   cp .env.example .env
   ```
5. Generate the application key:
   ```bash
   php artisan key:generate
   ```
6. Run database migrations:
   ```bash
   php artisan migrate
   ```
7. Start the development server:
   ```bash
   php artisan serve
   ```
Your application should now be running locally at `http://localhost:8000`.

## License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
