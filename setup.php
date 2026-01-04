<?php
/**
 * Coffee Shop E-Commerce Setup Script
 * Run this script once to initialize the database
 */

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'coffee_shop';

// Create connection to MySQL server (without selecting database)
$conn = new mysqli($db_host, $db_user, $db_pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected to MySQL server successfully.<br>";

// Read and execute schema
$schema = file_get_contents(__DIR__ . '/database/schema.sql');

// Split by semicolon and execute each statement
$statements = array_filter(array_map('trim', explode(';', $schema)));

foreach ($statements as $statement) {
    if (!empty($statement)) {
        if (!$conn->query($statement)) {
            echo "Error executing statement: " . $conn->error . "<br>";
            echo "Statement: " . substr($statement, 0, 100) . "...<br>";
        }
    }
}

echo "<h2>Database Setup Complete!</h2>";
echo "<p>The database has been initialized successfully.</p>";
echo "<p><strong>Admin Credentials:</strong></p>";
echo "<ul>";
echo "<li>Email: admin@coffeeshop.com</li>";
echo "<li>Password: admin123</li>";
echo "</ul>";
echo "<p><a href='public/index.php?page=home'>Go to Home Page</a></p>";

$conn->close();
?>
