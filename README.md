# E-Commerce Application

A RESTful API e-commerce application built with **Laravel 12** and **Vite**.

## 🎯 Overview

This project provides a complete API for managing users, products. Designed for web frontends, mobile apps, and API consumers.

## 🛠 Tech Stack

-   **PHP** ^8.2 | **Laravel** ^12.0 | **MySQL** | **Node.js** | **Vite** ^7.0 | **Tailwind CSS** | **PHPUnit**

## 📦 Prerequisites

-   PHP >= 8.2 with `pdo`, `pdo_mysql`, `mbstring`, `json`, `curl`, `tokenizer`, `xml`
-   Composer >= 2.0
-   Node.js >= 18.x
-   MySQL or MariaDB
-   Git

## 🚀 Quick Start

### 1. Clone & Install

```bash
git clone <repository-url>
cd ecommerce_application
composer install
npm install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration

Edit `.env` and set database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=ecommerce_app
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Run Migrations & Seed

```bash
php artisan migrate
php artisan db:seed
npm run build
```

### 5. Start Development

```bash
composer run dev
```

Starts: Laravel server (http://localhost:8000), Queue listener, Logs, and Vite

**Or individually:**

```bash
php artisan serve              # Terminal 1
npm run dev                    # Terminal 2
php artisan queue:listen       # Terminal 3
php artisan pail               # Terminal 4
```

## 📁 Project Structure

```
app/Http/Controllers/Api       # API controllers
app/Models/                    # Eloquent models
config/                        # Configuration files
database/migrations/           # Database migrations
database/seeders/              # Database seeders
public/                        # Entry point
resources/js|css|views/        # Frontend assets
routes/api_v1.php              # API route
routes/api.php                 # API route
storage/logs/                  # Application logs
tests/                         # Unit & feature tests
```

## 🧪 Testing

```bash
php artisan test                           # Run all tests
php artisan test --coverage                # With coverage
php artisan test tests/Feature/Example.php # Specific test
```

## 🔧 Useful Commands

```bash
php artisan make:controller ProductController  # Create controller
php artisan make:model Product -m              # Create model with migration
php artisan make:migration create_table_name   # Create migration
php artisan tinker                             # Interactive PHP shell
./vendor/bin/pint                              # Format code
```

## ⚠️ Troubleshooting

| Issue                     | Solution                          |
| ------------------------- | --------------------------------- |
| "Class not found"         | `composer dump-autoload`          |
| "No application key set"  | `php artisan key:generate`        |
| "Table doesn't exist"     | `php artisan migrate`             |
| Database connection error | Check `.env` database credentials |
| Port 8000 in use          | `php artisan serve --port=8001`   |

## 🔐 Security

-   Never commit `.env` file
-   Use token-based authentication for APIs
-   Always use `Hash::make()` for passwords
-   Use Eloquent ORM to prevent SQL injection

## 🤝 Contributing

1. Create feature branch: `git checkout -b feature/name`
2. Commit changes: `git commit -m 'Add feature'`
3. Push: `git push origin feature/name`
4. Open Pull Request

Follow PSR-12 coding standards and write tests for new features.

## 📚 API Documentation

### Products

| Method | Endpoint              | Description            |
| ------ | --------------------- | ---------------------- |
| GET    | `/products`           | List all products      |
| POST   | `/products`           | Create a product       |
| GET    | `/products/{product}` | Get product details    |
| PUT    | `/products/{product}` | Replace entire product |
| PATCH  | `/products/{product}` | Partial update product |
| DELETE | `/products/{product}` | Delete product         |

### Users

| Method | Endpoint        | Description      |
| ------ | --------------- | ---------------- |
| GET    | `/users`        | List all users   |
| GET    | `/users/{user}` | Get user details |

### User Products

| Method | Endpoint                           | Description                   |
| ------ | ---------------------------------- | ----------------------------- |
| GET    | `/users/{user}/products`           | List user's products          |
| POST   | `/users/{user}/products`           | Add product to user           |
| GET    | `/users/{user}/products/{product}` | Get user's product            |
| PUT    | `/users/{user}/products/{product}` | Replace user's product        |
| PATCH  | `/users/{user}/products/{product}` | Partial update user's product |
| DELETE | `/users/{user}/products/{product}` | Remove product from user      |

Base URL: `http://localhost:8000/api/v1`
User Login URL: `http://localhost:8000/api/login`
User Registration URL: `http://localhost:8000/api/register`
User Logout URL: `http://localhost:8000/api/logout`

## 📄 License

MIT License - see LICENSE file for details.

## 🎓 Resources

-   [Laravel Docs](https://laravel.com/docs)
-   [Vite Guide](https://vitejs.dev/guide/)
-   [RESTful API Design](https://restfulapi.net/)
