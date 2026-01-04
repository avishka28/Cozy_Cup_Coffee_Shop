<?php
// Auth Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends BaseController {
    
    /**
     * Show registration form
     */
    public function showRegister() {
        $this->render('auth/register');
    }
    
    /**
     * Handle registration
     */
    public function handleRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=register');
        }
        
        // Verify CSRF token
        if (!SecurityHelper::verifyCSRFToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Invalid request');
            $this->redirect(SITE_URL . '/public/index.php?page=register');
        }
        
        $email = $this->getPost('email');
        $password = $this->getPost('password');
        $confirm_password = $this->getPost('confirm_password');
        $full_name = $this->getPost('full_name');
        $phone = $this->getPost('phone');
        
        // Validate inputs
        if (!ValidationHelper::validateRequired($email) || !ValidationHelper::validateRequired($password) || 
            !ValidationHelper::validateRequired($full_name) || !ValidationHelper::validateRequired($phone)) {
            $this->setFlash('error', 'All fields are required');
            $this->redirect(SITE_URL . '/public/index.php?page=register');
        }
        
        if ($password !== $confirm_password) {
            $this->setFlash('error', 'Passwords do not match');
            $this->redirect(SITE_URL . '/public/index.php?page=register');
        }
        
        // Register user
        $user = new User();
        $result = $user->register($email, $password, $full_name, $phone);
        
        if ($result['success']) {
            $this->setFlash('success', 'Registration successful. Please log in.');
            $this->redirect(SITE_URL . '/public/index.php?page=login');
        } else {
            $this->setFlash('error', $result['error']);
            $this->redirect(SITE_URL . '/public/index.php?page=register');
        }
    }
    
    /**
     * Show login form
     */
    public function showLogin() {
        if (SessionHelper::isLoggedIn()) {
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        $this->render('auth/login');
    }
    
    /**
     * Handle login
     */
    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=login');
        }
        
        // Verify CSRF token
        if (!SecurityHelper::verifyCSRFToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Invalid request');
            $this->redirect(SITE_URL . '/public/index.php?page=login');
        }
        
        $email = $this->getPost('email');
        $password = $this->getPost('password');
        
        // Validate inputs
        if (!ValidationHelper::validateRequired($email) || !ValidationHelper::validateRequired($password)) {
            $this->setFlash('error', 'Email and password are required');
            $this->redirect(SITE_URL . '/public/index.php?page=login');
        }
        
        // Login user
        $user = new User();
        $result = $user->login($email, $password);
        
        if ($result['success']) {
            $this->setFlash('success', 'Login successful');
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        } else {
            $this->setFlash('error', $result['error']);
            $this->redirect(SITE_URL . '/public/index.php?page=login');
        }
    }
    
    /**
     * Handle logout
     */
    public function handleLogout() {
        SessionHelper::destroyUser();
        session_destroy();
        $this->setFlash('success', 'Logged out successfully');
        $this->redirect(SITE_URL . '/public/index.php?page=home');
    }
}

?>
