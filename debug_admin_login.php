<?php
require_once __DIR__ . '/config/database.php';

echo "<h2>Admin Login Debug</h2>";

// Check if admin exists
$email = 'admin@coffeeshop.com';
$stmt = $conn->prepare("SELECT id, email, password_hash, name FROM admin_users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p style='color:red;'><strong>ERROR: Admin user not found in database!</strong></p>";
} else {
    $admin = $result->fetch_assoc();
    echo "<p><strong>Admin found:</strong></p>";
    echo "ID: " . $admin['id'] . "<br>";
    echo "Email: " . $admin['email'] . "<br>";
    echo "Name: " . $admin['name'] . "<br>";
    echo "Password Hash: " . $admin['password_hash'] . "<br>";
    
    // Test password verification
    $password = 'admin123';
    $verify_result = password_verify($password, $admin['password_hash']);
    
    echo "<p><strong>Password Verification Test:</strong></p>";
    echo "Testing password: " . $password . "<br>";
    echo "Result: " . ($verify_result ? "<span style='color:green;'>TRUE - Password matches!</span>" : "<span style='color:red;'>FALSE - Password does NOT match!</span>") . "<br>";
    
    if (!$verify_result) {
        echo "<p><strong>Generating new hash for 'admin123':</strong></p>";
        $new_hash = password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 10]);
        echo "New Hash: " . $new_hash . "<br>";
        
        // Update with new hash
        $update_stmt = $conn->prepare("UPDATE admin_users SET password_hash = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $new_hash, $email);
        if ($update_stmt->execute()) {
            echo "<p style='color:green;'><strong>Hash updated successfully!</strong></p>";
            echo "Try logging in now with:<br>";
            echo "Email: admin@coffeeshop.com<br>";
            echo "Password: admin123<br>";
        }
        $update_stmt->close();
    }
}

$stmt->close();
$conn->close();
?>
