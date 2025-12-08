<?php
// Simple script to test PDO connection to PostgreSQL without Laravel overhead

// 1. Read .env file manually
$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    die(".env file not found\n");
}

$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$env = [];
foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    $parts = explode('=', $line, 2);
    if (count($parts) === 2) {
        $env[trim($parts[0])] = trim($parts[1]);
    }
}

// 2. Extract Config
$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '5432';
$db   = $env['DB_DATABASE'] ?? 'postgres';
$user = $env['DB_USERNAME'] ?? 'postgres';
$pass = $env['DB_PASSWORD'] ?? '';

// 3. Attempt Connection
echo "Attempting connection to:\n";
echo "Host: $host\n";
echo "Port: $port\n";
echo "Database: $db\n";
echo "User: $user\n";
echo "Password: " . ($pass ? "****" : "(empty)") . "\n\n";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_TIMEOUT => 5]);
    echo "✅ SUCCESS! Connected to database.\n";
    
    // Test query
    $stmt = $pdo->query("SELECT version()");
    $version = $stmt->fetchColumn();
    echo "Server Version: $version\n";
    
} catch (PDOException $e) {
    echo "❌ ERROR: Could not connect.\n";
    echo "Message: " . $e->getMessage() . "\n";
}
