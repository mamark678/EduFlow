<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Storage;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get the first instructor user
$user = User::where('role', 'instructor')->first();

if (!$user) {
    echo "No instructor user found.\n";
    exit(1);
}

// Print avatar field
echo "User: {$user->name}\n";
echo "Avatar field: " . ($user->avatar ?? 'null') . "\n";

// Print avatar_url accessor
echo "Avatar URL (from accessor): " . ($user->avatar_url ?? 'null') . "\n";

// Check if file exists in storage
if ($user->avatar) {
    $fileExists = Storage::disk('public')->exists('avatars/' . $user->avatar);
    echo "File exists in storage/app/public/avatars: " . ($fileExists ? 'yes' : 'no') . "\n";
    if ($fileExists) {
        $publicUrl = Storage::disk('public')->url('avatars/' . $user->avatar);
        echo "Public URL: $publicUrl\n";
        // Try to fetch the file via HTTP (if possible)
        if (function_exists('curl_init')) {
            $ch = curl_init($publicUrl);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            echo "HTTP status for public URL: $httpCode\n";
        }
    }
}

echo "Done.\n"; 