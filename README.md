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
8. Optional: Seed the database:

   ```bash
    ./vendor/bin/sail artisan db:seed
    ```
9. Visit the application in your browser: [http://localhost](http://localhost)
