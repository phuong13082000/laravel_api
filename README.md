# Laravel API

This repository contains the source code for an API built with Laravel, a powerful and flexible PHP framework.

## Introduction

This project is a RESTful API developed using Laravel, providing endpoints to interact with application data. This API is designed to support front-end applications, mobile apps, and third-party services.

## System Requirements

- PHP >= 8.2
- Composer
- MySQL or MariaDB
- Laravel 12

## Installation

### Step 1: Clone the repository

```bash
git clone https://github.com/phuong13082000/laravel_api.git
cd laravel_api
```

### Step 2: Install dependencies

```bash
composer install
```

### Step 3: Set up environment

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Then edit the `.env` file to configure your database connection and other settings.

### Step 4: Generate application key

```bash
php artisan key:generate
```

### Step 5: Run migrations and seeders

```bash
php artisan migrate --seed
```

### Step 6: Start the development server

```bash
php artisan serve
```

The server will run at: `http://localhost:8000`

## API Structure

The API is organized according to RESTful principles with the following routes:

### Authentication

- `POST /api/register` - Register a new user
- `POST /api/login` - Login and retrieve JWT token
- `POST /api/logout` - Logout and invalidate token
- `GET /api/user` - Get current user information
- ...

### Resources

- `GET /api/products` - Get list of products
- `GET /api/products/{slug}` - Get detailed product information
- `POST /api/products` - Create a new product
- `PUT /api/products/{id}` - Update product information
- `DELETE /api/products/{id}` - Delete a product
- ...

## Authentication and Authorization

The API uses JWT (JSON Web Tokens) for user authentication. To use protected endpoints, you need to:

1. Login via `/api/login` to receive a token
2. Add the token to the header of subsequent requests:
   ```
   Authorization: Bearer {your_token}
   ```

## Error Handling

The API returns standard HTTP error codes and JSON messages:

- `200 OK` - Request successful
- `201 Created` - Resource created successfully
- `400 Bad Request` - Invalid request
- `401 Unauthorized` - Authentication failed
- `403 Forbidden` - Insufficient access rights
- `404 Not Found` - Resource not found
- `422 Unprocessable Entity` - Invalid input data
- `500 Internal Server Error` - Server error

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contact

Phuong - [GitHub](https://github.com/phuong13082000)

Project Link: [https://github.com/phuong13082000/laravel_api](https://github.com/phuong13082000/laravel_api)
