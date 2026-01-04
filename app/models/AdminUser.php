<?php
// Admin User Model

require_once __DIR__ . '/Database.php';

class AdminUser {
    private $db;
    
    public $id;
    public $email;
    public $password_hash;
    public $name;
    public $created_at;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Login admin
     */
    public function login($email, $password) {
        // Validate inputs
        if (!ValidationHelper::validateEmail($email)) {
            return ['success' => false, 'error' => 'Invalid email or password'];
        }
        
        if (!ValidationHelper::validateRequired($password)) {
            return ['success' => false, 'error' => 'Invalid email or password'];
        }
        
        // Get admin from database
        $stmt = $this->db->prepare("SELECT id, email, password_hash, name FROM admin_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return ['success' => false, 'error' => 'Invalid email or password'];
        }
        
        $admin = $result->fetch_assoc();
        
        // Verify password
        if (!SecurityHelper::verifyPassword($password, $admin['password_hash'])) {
            return ['success' => false, 'error' => 'Invalid email or password'];
        }
        
        // Set session
        SessionHelper::setUser($admin['id'], $admin['name'], ROLE_ADMIN);
        
        return ['success' => true, 'message' => 'Login successful', 'admin_id' => $admin['id']];
    }
    
    /**
     * Get admin profile
     */
    public function getProfile($admin_id) {
        $stmt = $this->db->prepare("SELECT id, email, name, created_at FROM admin_users WHERE id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return null;
        }
        
        return $result->fetch_assoc();
    }
}

?>
