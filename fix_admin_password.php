<?php
/**
 * Fix Admin Password
 * Run this script to update the admin password hash in the database
 */

require_once __DIR__ . '/config/database.php';

// Update the admin user with correct password hash
$email = 'admin@coffeeshop.com';
$password_hash = '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DRZlG2';

$stmt = $conn->prepare("UPDATE admin_users SET password_hash = ? WHERE email = ?");
$stmt->bind_param("ss", $password_hash, $email);

if ($stmt->execute()) {
    echo "<h2>Success!</h2>";
    echo "<p>Admin password hash has been updated.</p>";
    echo "<p><strong>You can now login with:</strong></p>";
    echo "<ul>";
    echo "<li>Email: admin@coffeeshop.com</li>";
    echo "<li>Password: admin123</li>";
    echo "</ul>";
    echo "<p><a href='public/index.php?page=admin-login'>Go to Admin Login</a></p>";
} else {
    echo "<h2>Error!</h2>";
    echo "<p>Failed to update password: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?>
