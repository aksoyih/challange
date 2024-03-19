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


## API Reference

### Register a device

```http
  POST /device/register
```

| Parameter          | Type      | Description                                                              | Example                          |
|:-------------------|:----------|:-------------------------------------------------------------------------|:---------------------------------|
| `device_uid`       | `string`  | **Required**. Device identifier                                          | wzeppKXtgLPfiJBmCgsaGssZuatWcwul |
| `operating_system` | `string`  | **Required**. Device operating system, must be either _android_ or _ios_ | android                          |
| `app_id`           | `integer` | **Required**. A valid app id                                             | 1                                |
| `language`         | `string`  | **Required**. ISO 639-1 compatible language code                         | tr                               |

Example response:
```json
{
    "status": "register OK",
    "device": {
        "device_uid": "wzeppKXtgLPfiJBmCgsaGssZuatWcwul",
        "operating_system": "ios",
        "language": "tr",
        "client_token": "JGiFgyozyrQtvmrqHtlhsRBmin57BqGxwfWR8dL2k6XvGY3IJHwVY5GYMJxVaLijNv3zKj7zen8QRVTMFmZO5LG2Vj3IjZejwJayzuz6Fd1QW5KV9xeWmH4gMIRToGfeKNt1w6CHYoz9JN4nuQ6TBAkSMgTtdW0ncTRJRvduct4lkAoOPMunFDVT5Aa0gQ6mtjKm7DBFh9JWxlUAPwlkc6aSp8pj8JEckLmp6FnAlmlNjB3IHP6zPsRIqr0TTBs",
        "created_at": "2024-03-19T09:05:21.000000Z",
        "app": {
            "id": 1,
            "name": "App X",
            "slug": "app_x"
        }
    }
}
```

### Purchase a subscription

```http
  POST /subscription/purchase
```

| Parameter      | Type      | Description                                      | Example                          |
|:---------------|:----------|:-------------------------------------------------|:---------------------------------|
| `client_token` | `string`  | **Required**. Device identifier                  | wzeppKXtgLPfiJBmCgsaGssZuatWcwul |
| `receipt`      | `string`  | **Required**. Device operating system            | android                          |

Example response:
```json
{
    "message": "Purchase authorized",
    "subscription": {
        "receipt": "1230912303",
        "expire_date": "2024-04-19 04:06:23",
        "created_at": "2024-03-19T09:06:23.000000Z",
        "app": {
            "id": 1,
            "name": "App X",
            "slug": "app_x"
        },
        "device": {
            "created_at": "2024-03-19T09:05:21.000000Z",
            "device_uid": "wzeppKXtgLPfiJBmCgsaGssZuatWcwul",
            "client_token": "JGiFgyozyrQtvmrqHtlhsRBmin57BqGxwfWR8dL2k6XvGY3IJHwVY5GYMJxVaLijNv3zKj7zen8QRVTMFmZO5LG2Vj3IjZejwJayzuz6Fd1QW5KV9xeWmH4gMIRToGfeKNt1w6CHYoz9JN4nuQ6TBAkSMgTtdW0ncTRJRvduct4lkAoOPMunFDVT5Aa0gQ6mtjKm7DBFh9JWxlUAPwlkc6aSp8pj8JEckLmp6FnAlmlNjB3IHP6zPsRIqr0TTBs",
            "operating_system": "ios",
            "language": "tr"
        }
    }
}
```

### Check a subscription status

```http
  POST /subscription/check
```

| Parameter      | Type     | Description                | Example                                                                                                                                                                                                                                                         |
|:---------------|:---------|:---------------------------|:----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `client_token` | `string` | **Required**. Clinet token | JGiFgyozyrQtvmrqHtlhsRBmin57BqGxwfWR8dL2k6XvGY3IJHwVY5GYMJxVaLijNv3zKj7zen8QRVTMFmZO5LG2Vj3IjZejwJayzuz6Fd1QW5KV9xeWmH4gMIRToGfeKNt1w6CHYoz9JN4nuQ6TBAkSMgTtdW0ncTRJRvduct4lkAoOPMunFDVT5Aa0gQ6mtjKm7DBFh9JWxlUAPwlkc6aSp8pj8JEckLmp6FnAlmlNjB3IHP6zPsRIqr0TTBs |

Example response:
```json
{
    "message": "Subscription active",
    "subscription": {
        "created_at": "2024-03-19T09:06:23.000000Z",
        "receipt": 1230912303,
        "status": "active",
        "expire_date": "2024-04-19T09:15:19.000000Z"
    }
}
```
