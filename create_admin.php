<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== EduFlow Admin Account Setup ===\n\n";

// Check if admin already exists
$existingAdmin = User::where('role', 'admin')->first();
if ($existingAdmin) {
    echo "Admin account already exists:\n";
    echo "Name: {$existingAdmin->name}\n";
    echo "Email: {$existingAdmin->email}\n";
    echo "Role: {$existingAdmin->role}\n\n";
    
    $response = readline("Do you want to create another admin account? (y/n): ");
    if (strtolower($response) !== 'y') {
        echo "Exiting...\n";
        exit;
    }
}

echo "Please provide the following information for the admin account:\n\n";

// Get admin details
$name = readline("Full Name: ");
$email = readline("Email: ");
$password = readline("Password: ");

// Validate input
if (empty($name) || empty($email) || empty($password)) {
    echo "Error: All fields are required!\n";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Error: Invalid email format!\n";
    exit;
}

if (strlen($password) < 8) {
    echo "Error: Password must be at least 8 characters long!\n";
    exit;
}

// Check if email already exists
if (User::where('email', $email)->exists()) {
    echo "Error: A user with this email already exists!\n";
    exit;
}

try {
    // Create admin user
    $admin = User::create([
        'name' => $name,
        'email' => $email,
        'password' => Hash::make($password),
        'role' => 'admin',
        'email_verified' => true, // Admin accounts are automatically verified
    ]);

    echo "\n=== Admin Account Created Successfully! ===\n";
    echo "Name: {$admin->name}\n";
    echo "Email: {$admin->email}\n";
    echo "Role: {$admin->role}\n";
    echo "Email Verified: Yes\n";
    echo "Created: {$admin->created_at->format('F d, Y \a\t g:i A')}\n\n";
    
    echo "You can now log in to the admin dashboard at:\n";
    echo "http://localhost:8000/admin\n\n";
    
    echo "Admin Dashboard Features:\n";
    echo "- View comprehensive analytics and statistics\n";
    echo "- Manage all users (students, instructors, admins)\n";
    echo "- View and manage courses\n";
    echo "- Monitor platform growth and performance\n";
    echo "- Full CRUD operations on users and courses\n\n";

} catch (Exception $e) {
    echo "Error creating admin account: " . $e->getMessage() . "\n";
    exit;
}

echo "Setup complete!\n"; 