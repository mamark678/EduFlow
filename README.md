<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## About EduFlow

EduFlow is a Learning Management System (LMS) built with Laravel. It provides a comprehensive platform for online education with features including:

- **Course Management**: Create and organize courses with modules, videos, and documents
- **User Roles**: Support for students, instructors, and administrators
- **Forums**: Reddit-style discussion forums for course communities
- **Progress Tracking**: Monitor student progress through course modules
- **Announcements**: Broadcast important updates to users
- **Enrollment System**: Flexible course enrollment with verification

## Setup Instructions

### 1. Clone and Install

```bash
git clone <repository-url>
cd eduflow
composer install
npm install
```

### 2. Environment Configuration

Copy the example environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 3. Database Setup (Supabase PostgreSQL)

EduFlow uses **Supabase** as its database backend. Follow these steps:

#### Create a Supabase Project

1. Go to [supabase.com](https://supabase.com) and create a new project
2. Wait for your project to be provisioned
3. Navigate to **Settings → Database** in your Supabase dashboard

#### Configure Database Connection

Update your `.env` file with your Supabase credentials:

```env
DB_CONNECTION=pgsql
DB_HOST=your-project-ref.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-database-password

SUPABASE_URL=https://your-project-ref.supabase.co
SUPABASE_KEY=your-anon-key
```

**Where to find these values:**
- `DB_HOST`: Found in Settings → Database → Connection string (host part)
- `DB_PASSWORD`: The password you set when creating the project
- `SUPABASE_URL`: Your project URL from Settings → API
- `SUPABASE_KEY`: The `anon` public key from Settings → API

#### Run Migrations

Once configured, run the migrations to create all database tables:

```bash
php artisan migrate
```

### 4. Create Admin User

Create an admin account using the provided script:

```bash
php create_admin.php
```

Or refer to `ADMIN_SETUP.md` for detailed instructions.

### 5. Build Assets and Run

Build frontend assets:

```bash
npm run dev
```

Start the development server:

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Additional Documentation

- **[ERD_EduFlow.md](ERD_EduFlow.md)** - Database schema and entity relationships
- **[ADMIN_SETUP.md](ADMIN_SETUP.md)** - Admin account setup guide
- **[UseCase_EduFlow.md](UseCase_EduFlow.md)** - Use cases and feature documentation
- **[Gantt_EduFlow.md](Gantt_EduFlow.md)** - Project timeline and milestones

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
