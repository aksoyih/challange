# Challenge

This is a Laravel project that uses Laravel Sail for local development environment setup using Docker.

## What did I do?
- I created all sections stated in the documentation. This app contains: API, Worker, Callback and a simple reporting method.
- The API reference is given in this README file, a Postman collection is also provided ("challenge.postman_collection.json")
- Worker is created using Laravel's built in task scheduling with Redis and configured to run every hour. It dispatches a new job for each of the subscriptions that satisfy the requirements. The job checks the subscription by querying mock api (Google or Apple based on device os) and either updates expire date or change its status to expired. Based on the respective event, a callback job is also dispatched. Laravel Horizion can be used to monitor the Redis queue.
- Callback is created as a job that handles 3 events: started, renewed and canceled. The job creates a HTTP POST request to the callback endpoint saved in the DB. If the endpoint does not return with 200 or 201, the job is released back into the queue to be dispatched after 60 seconds. It retries for 3 times before giving up and fail.

## Requirements

- Docker Desktop installed on your machine.

## Getting Started
It is important to seed the database since it saves apps and callback endpoints to the DB.

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
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
   ```
   
5. Run Sail

   ```bash
    ./vendor/bin/sail up -d
   ```
   
6. Generate application key:

   ```bash
   ./vendor/bin/sail artisan key:generate
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
Public route to register a device. It creates a new device record in the database and returns a client token to be used in the following requests.

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
Protected route to purchase a subscription. It authorizes the purchase and creates a new subscription record in the database. Should be authenticated with Client-Token header.

```http
  POST /subscription/purchase
```

| Parameter      | Type      | Description                                      | Example                          |
|:---------------|:----------|:-------------------------------------------------|:---------------------------------|
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
Protected route to check a subscription status. Should be authenticated with Client-Token header.

```http
  POST /subscription/check
```

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
