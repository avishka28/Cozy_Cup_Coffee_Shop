<?php
// Base Controller

class BaseController {
    protected $db;
    
    public function __construct() {
        require_once __DIR__ . '/../models/Database.php';
        $this->db = new Database();
    }
    
    /**
     * Render view
     */
    protected function render($view, $data = []) {
        extract($data);
        require __DIR__ . '/../views/' . $view . '.php';
    }
    
    /**
     * Redirect to URL
     */
    protected function redirect($url) {
        header("Location: " . $url);
        exit;
    }
    
    /**
     * Check if user is logged in
     */
    protected function requireLogin() {
        if (!SessionHelper::isLoggedIn()) {
            $this->redirect(SITE_URL . '/public/index.php?page=login');
        }
    }
    
    /**
     * Check if user is admin
     */
    protected function requireAdmin() {
        if (!SessionHelper::isAdmin()) {
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
    }
    
    /**
     * Check if user is customer
     */
    protected function requireCustomer() {
        if (!SessionHelper::isCustomer()) {
            $this->redirect(SITE_URL . '/public/index.php?page=login');
        }
    }
    
    /**
     * Get POST data
     */
    protected function getPost($key, $default = null) {
        return isset($_POST[$key]) ? SecurityHelper::sanitizeInput($_POST[$key]) : $default;
    }
    
    /**
     * Get GET data
     */
    protected function getGet($key, $default = null) {
        return isset($_GET[$key]) ? SecurityHelper::sanitizeInput($_GET[$key]) : $default;
    }
    
    /**
     * Set flash message
     */
    protected function setFlash($type, $message) {
        SessionHelper::setFlash($type, $message);
    }
}

?>
