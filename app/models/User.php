<?php
// User Model

require_once __DIR__ . '/Database.php';

class User {
    private $db;
    
    public $id;
    public $email;
    public $password_hash;
    public $full_name;
    public $phone;
    public $created_at;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Register new customer
     */
    public function register($email, $password, $full_name, $phone) {
        // Validate inputs
        if (!ValidationHelper::validateEmail($email)) {
            return ['success' => false, 'error' => 'Invalid email format'];
        }
        
        if (!ValidationHelper::validatePassword($password)) {
            return ['success' => false, 'error' => 'Password must be at least ' . MIN_PASSWORD_LENGTH . ' characters'];
        }
        
        if (!ValidationHelper::validateRequired($full_name)) {
            return ['success' => false, 'error' => 'Full name is required'];
        }
        
        if (!ValidationHelper::validatePhone($phone)) {
            return ['success' => false, 'error' => 'Invalid phone number'];
        }
        
        // Check if email already exists
        $stmt = $this->db->prepare("SELECT id FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return ['success' => false, 'error' => 'Email already exists'];
        }
        
        // Hash password
        $password_hash = SecurityHelper::hashPassword($password);
        
        // Insert new customer
        $stmt = $this->db->prepare("INSERT INTO customers (email, password_hash, full_name, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $password_hash, $full_name, $phone);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Registration successful'];
        } else {
            return ['success' => false, 'error' => 'Registration failed'];
        }
    }
    
    /**
     * Login customer
     */
    public function login($email, $password) {
        // Validate inputs
        if (!ValidationHelper::validateEmail($email)) {
            return ['success' => false, 'error' => 'Invalid email or password'];
        }
        
        if (!ValidationHelper::validateRequired($password)) {
            return ['success' => false, 'error' => 'Invalid email or password'];
        }
        
        // Get user from database
        $stmt = $this->db->prepare("SELECT id, email, password_hash, full_name FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return ['success' => false, 'error' => 'Invalid email or password'];
        }
        
        $user = $result->fetch_assoc();
        
        // Verify password
        if (!SecurityHelper::verifyPassword($password, $user['password_hash'])) {
            return ['success' => false, 'error' => 'Invalid email or password'];
        }
        
        // Set session
        SessionHelper::setUser($user['id'], $user['full_name'], ROLE_CUSTOMER);
        
        return ['success' => true, 'message' => 'Login successful', 'user_id' => $user['id']];
    }
    
    /**
     * Get customer profile
     */
    public function getProfile($customer_id) {
        $stmt = $this->db->prepare("SELECT id, email, full_name, phone, created_at FROM customers WHERE id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return null;
        }
        
        return $result->fetch_assoc();
    }
    
    /**
     * Update customer profile
     */
    public function updateProfile($customer_id, $data) {
        $updates = [];
        $params = [];
        $types = "";
        
        if (isset($data['full_name'])) {
            $updates[] = "full_name = ?";
            $params[] = $data['full_name'];
            $types .= "s";
        }
        
        if (isset($data['phone'])) {
            if (!ValidationHelper::validatePhone($data['phone'])) {
                return ['success' => false, 'error' => 'Invalid phone number'];
            }
            $updates[] = "phone = ?";
            $params[] = $data['phone'];
            $types .= "s";
        }
        
        if (empty($updates)) {
            return ['success' => false, 'error' => 'No data to update'];
        }
        
        $params[] = $customer_id;
        $types .= "i";
        
        $sql = "UPDATE customers SET " . implode(", ", $updates) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Profile updated successfully'];
        } else {
            return ['success' => false, 'error' => 'Failed to update profile'];
        }
    }
    
    /**
     * Get customer by ID
     */
    public function getById($customer_id) {
        $stmt = $this->db->prepare("SELECT id, email, full_name, phone, created_at FROM customers WHERE id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Get all customers
     */
    public function getAll() {
        $result = $this->db->query("SELECT id, email, full_name, phone, created_at FROM customers ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>
