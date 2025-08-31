# EduFlow Admin Dashboard Setup

## Overview
The EduFlow admin dashboard provides comprehensive user management, analytics, and course oversight capabilities. This guide will help you set up and access your admin account.

## Features

### 🎯 Admin Dashboard
- **Comprehensive Analytics**: View user growth, course statistics, and enrollment trends
- **Real-time Charts**: Visual representation of platform growth over time
- **Key Metrics**: Total users, courses, enrollments, and engagement statistics

### 👥 User Management
- **Full CRUD Operations**: Create, read, update, and delete user accounts
- **Role Management**: Assign and manage user roles (student, instructor, admin)
- **Search & Filters**: Find users by name, email, role, or verification status
- **User Analytics**: View detailed user activity and statistics
- **Email Verification Control**: Manage email verification status

### 📊 Analytics
- **Growth Tracking**: Monthly user, course, and enrollment growth charts
- **Top Performers**: Identify leading instructors and popular courses
- **Platform Statistics**: Comprehensive overview of platform metrics
- **Performance Insights**: Average enrollments per course and engagement metrics

### 📚 Course Management
- **Course Overview**: View all courses with instructor information
- **Status Monitoring**: Track published vs draft courses
- **Enrollment Tracking**: Monitor course popularity and engagement
- **Search & Filter**: Find courses by title, description, or instructor

## Setup Instructions

### Option 1: Using Tinker (Recommended)
1. Open your terminal in the project directory
2. Run: `php artisan tinker`
3. Copy and paste the following code:

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$admin = User::create([
    'name' => 'Andre Marc Lads',
    'email' => 's.sambile.andremarc@cmu.edu.ph',
    'password' => Hash::make('2022302902'),
    'role' => 'admin',
    'email_verified' => true,
]);

echo "Admin account created successfully!\n";
echo "Name: " . $admin->name . "\n";
echo "Email: " . $admin->email . "\n";
echo "Role: " . $admin->role . "\n";
```

4. Replace `'Your Name'`, `'your-email@example.com'`, and `'your-secure-password'` with your actual information
5. Press Enter to execute

### Option 2: Using the Setup Script
1. Run: `php create_admin.php`
2. Follow the interactive prompts to enter your information
3. The script will validate your input and create the admin account

### Option 3: Database Seeder
1. Create a seeder: `php artisan make:seeder AdminUserSeeder`
2. Add the following to the seeder:

```php
public function run()
{
    User::create([
        'name' => 'Admin User',
        'email' => 'admin@eduflow.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'email_verified' => true,
    ]);
}
```

3. Run: `php artisan db:seed --class=AdminUserSeeder`

## Accessing the Admin Dashboard

### After Setup
1. Log in with your admin credentials at: `http://localhost:8000/login`
2. You'll see an "Admin Panel" link in the navigation
3. Click it to access the admin dashboard at: `http://localhost:8000/admin`

### Direct Access
- Admin Dashboard: `http://localhost:8000/admin`
- User Management: `http://localhost:8000/admin/users`
- Analytics: `http://localhost:8000/admin/analytics`
- Course Management: `http://localhost:8000/admin/courses`

## Admin Dashboard Sections

### 📈 Dashboard (`/admin`)
- Overview statistics
- Recent activity
- Growth charts
- Top performing content

### 👥 Users (`/admin/users`)
- List all users with search and filters
- View detailed user profiles
- Edit user information and roles
- Delete user accounts (with safety checks)

### 📊 Analytics (`/admin/analytics`)
- Comprehensive growth metrics
- Monthly trend analysis
- Top performers identification
- Platform performance insights

### 📚 Courses (`/admin/courses`)
- Course listing with instructor details
- Publication status tracking
- Enrollment statistics
- Course management tools

## Security Features

### 🔒 Admin Middleware
- Only users with `admin` role can access admin routes
- Automatic redirect for unauthorized access
- Session-based authentication

### 🛡️ Safety Measures
- Cannot delete your own admin account
- Confirmation dialogs for destructive actions
- Input validation and sanitization
- CSRF protection on all forms

### 👤 Role Management
- Three distinct roles: student, instructor, admin
- Role-based access control
- Granular permissions system

## Troubleshooting

### Common Issues

**"Access denied" error**
- Ensure your user has the `admin` role
- Check that you're logged in
- Verify the admin middleware is properly registered

**Admin panel not showing in navigation**
- Confirm your user role is set to `admin`
- Clear browser cache
- Check if the `isAdmin()` method exists in User model

**Analytics not loading**
- Ensure you have data in your database
- Check for any JavaScript errors in browser console
- Verify all required relationships are properly set up

### Getting Help
1. Check the Laravel logs: `storage/logs/laravel.log`
2. Verify database migrations: `php artisan migrate:status`
3. Clear application cache: `php artisan cache:clear`
4. Regenerate autoload files: `composer dump-autoload`

## Next Steps

After setting up your admin account:

1. **Explore the Dashboard**: Familiarize yourself with the analytics and metrics
2. **Review Users**: Check existing user accounts and their roles
3. **Monitor Courses**: Review course content and instructor activity
4. **Set Up Monitoring**: Consider setting up regular analytics reviews
5. **Customize**: Modify the admin interface to match your specific needs

## Support

For additional help or customizations:
- Review the Laravel documentation
- Check the admin controller code in `app/Http/Controllers/AdminController.php`
- Examine the admin views in `resources/views/admin/`
- Review the admin routes in `routes/web.php` 