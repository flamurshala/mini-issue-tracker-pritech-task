# Mini Issue Tracker

A Laravel-based Mini Issue Tracker built for the PRITECH Laravel Technical Task.

The application allows users to manage projects, issues, tags, comments, issue assignments, and basic project ownership authorization.

## Features

* Project CRUD
* Issue CRUD
* Issue filters by status, priority, and tag
* AJAX issue search by title and description
* Tags list and create
* AJAX attach/detach tags to issues
* AJAX comments with pagination
* AJAX assign/remove users from issues
* Project ownership authorization
* Factories and seeders for demo data
* Eager loading to avoid N+1 queries
* Responsive Blade UI

## Requirements

* PHP 8.4 or higher
* Composer
* MySQL
* Laravel-compatible local server, for example Laragon, XAMPP, or Valet

## Installation

Clone the project and enter the project folder:

```bash
cd mini-issue-tracker
```

Install PHP dependencies:

```bash
composer install
```

Create the environment file.

For Windows:

```bash
copy .env.example .env
```

For macOS/Linux:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

## Database Setup

Update the database settings in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_issue_tracker_pritech
DB_USERNAME=root
DB_PASSWORD=
```

Create the MySQL database:

```sql
CREATE DATABASE mini_issue_tracker_pritech CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Run migrations and seed demo data:

```bash
php artisan migrate:fresh --seed
```

## Run the Application

Start the local development server:

```bash
php artisan serve
```

Open the project in the browser:

```text
http://127.0.0.1:8000
```

Register a user:

```text
http://127.0.0.1:8000/register
```

Login page:

```text
http://127.0.0.1:8000/login
```

## Laragon Windows Path Example

For Windows Laragon users, run the commands inside the project folder:

```text
C:\laragon\www\Pritech-Task\mini-issue-tracker
```

## Demo Data

The seeder creates sample:

* Users
* Projects
* Issues
* Tags
* Comments
* Issue-tag relationships
* Issue-user assignments

To reset and recreate demo data, run:

```bash
php artisan migrate:fresh --seed
```

## Notes

This project uses Laravel Blade templates, Form Request validation, Eloquent relationships, factories, seeders, AJAX interactions, and eager loading.
