# Brand Represent

A modern admin dashboard built with Laravel 12, featuring comprehensive product and order management capabilities.

## Features

-   **Modern Dashboard** - Clean, responsive admin interface with Bootstrap 5
-   **Product Management** - Complete CRUD operations for products with image upload
-   **Order Management** - Full order processing workflow with status tracking
-   **Image Upload System** - Drag & drop image upload with preview and management
-   **Advanced Filtering** - Search and filter products and orders
-   **Bulk Operations** - Batch actions for managing multiple items
-   **Responsive Design** - Mobile-friendly interface that works on all devices

## Technology Stack

-   **Backend**: Laravel 12
-   **Frontend**: Blade Templates, Bootstrap 5, Font Awesome
-   **Database**: SQLite (configurable)
-   **Image Storage**: Laravel Storage with public disk
-   **Styling**: Custom CSS with modern design principles

## Installation

1. Clone the repository
2. Install dependencies: `composer install`
3. Copy environment file: `cp .env.example .env`
4. Generate application key: `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Seed the database: `php artisan db:seed`
7. Create storage link: `php artisan storage:link`
8. Start the development server: `php artisan serve`

## Usage

-   **Dashboard**: View overview statistics and recent orders
-   **Products**: Manage product catalog with images and details
-   **Orders**: Process customer orders and track their status
-   **Image Management**: Upload and manage product images with drag & drop

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
