<?php
// Admin Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/AdminUser.php';

class AdminController extends BaseController {
    
    /**
     * Show admin login form
     */
    public function showAdminLogin() {
        if (SessionHelper::isAdmin()) {
            $this->redirect(SITE_URL . '/public/index.php?page=admin-dashboard');
        }
        $this->render('admin/login');
    }
    
    /**
     * Handle admin login
     */
    public function handleAdminLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=admin-login');
        }
        
        // Verify CSRF token
        if (!SecurityHelper::verifyCSRFToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Invalid request');
            $this->redirect(SITE_URL . '/public/index.php?page=admin-login');
        }
        
        $email = $this->getPost('email');
        $password = $this->getPost('password');
        
        // Validate inputs
        if (!ValidationHelper::validateRequired($email) || !ValidationHelper::validateRequired($password)) {
            $this->setFlash('error', 'Email and password are required');
            $this->redirect(SITE_URL . '/public/index.php?page=admin-login');
        }
        
        // Login admin
        $admin = new AdminUser();
        $result = $admin->login($email, $password);
        
        if ($result['success']) {
            $this->setFlash('success', 'Admin login successful');
            $this->redirect(SITE_URL . '/public/index.php?page=admin-dashboard');
        } else {
            $this->setFlash('error', $result['error']);
            $this->redirect(SITE_URL . '/public/index.php?page=admin-login');
        }
    }
    
    /**
     * Show admin dashboard
     */
    public function showDashboard() {
        $this->requireAdmin();
        $this->render('admin/dashboard');
    }
    
    /**
     * Handle admin logout
     */
    public function handleAdminLogout() {
        SessionHelper::destroyUser();
        session_destroy();
        $this->setFlash('success', 'Logged out successfully');
        $this->redirect(SITE_URL . '/public/index.php?page=home');
    }
}

?>
