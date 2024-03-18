# Challenge

This is a Laravel project that uses Laravel Sail for local development environment setup using Docker.

## Requirements

- Docker Desktop installed on your machine.

## Getting Started

1. Clone the repository:

   ```bash
   git clone https://github.com/aksoyih/challange.git <project-directory>
   ```

2. Navigate into the project directory:

   ```bash
   cd <project-directory>
   ```

3. Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

4. Install Composer dependencies:

   ```bash
   ./vendor/bin/sail composer install
   ```

5. Generate application key:

   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

6. Run Docker containers:

   ```bash
   ./vendor/bin/sail up -d
   ```
7. Run migrations:

   ```bash
   ./vendor/bin/sail artisan migrate
   ```
8. Seed the database, needed to create save callback urls and apps into the database:

   ```bash
    ./vendor/bin/sail artisan db:seed
    ```
9. Run the queue worker:

   ```bash
   ./vendor/bin/sail artisan queue:work
   ```


https://engineering.teknasyon.com/supervisor-ile-laravel-horizon-kurulumu-ve-yap%C4%B1land%C4%B1r%C4%B1lmas%C4%B1-a0cfc4c697ab
