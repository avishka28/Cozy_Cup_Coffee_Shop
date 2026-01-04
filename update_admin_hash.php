<?php
require_once __DIR__ . '/config/database.php';

$email = 'admin@coffeeshop.com';
$password_hash = '$2y$10$S1sQcGTirPD60XXcvpzz8.6w7uYx.52.20ghR5bZ2PmsM.7Jf9ala';

$stmt = $conn->prepare("UPDATE admin_users SET password_hash = ? WHERE email = ?");
$stmt->bind_param("ss", $password_hash, $email);

if ($stmt->execute()) {
    echo "Success! Admin password hash updated.<br>";
    echo "Email: admin@coffeeshop.com<br>";
    echo "Password: admin123<br>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
