<?php
$password = 'admin123';
$hash = '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DRZlG2';

$result = password_verify($password, $hash);

echo "Password: " . $password . "<br>";
echo "Hash: " . $hash . "<br>";
echo "Verification Result: " . ($result ? "TRUE - Password matches!" : "FALSE - Password does NOT match!") . "<br>";

// Generate a fresh hash for admin123
$fresh_hash = password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 10]);
echo "<br><strong>Fresh hash for 'admin123':</strong><br>";
echo $fresh_hash . "<br>";

// Test the fresh hash
$fresh_result = password_verify('admin123', $fresh_hash);
echo "Fresh hash verification: " . ($fresh_result ? "TRUE" : "FALSE") . "<br>";
?>
