<?php
// Session Helper

class SessionHelper {
    
    /**
     * Set session value
     */
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    /**
     * Get session value
     */
    public static function get($key, $default = null) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    
    /**
     * Check if session key exists
     */
    public static function has($key) {
        return isset($_SESSION[$key]);
    }
    
    /**
     * Remove session value
     */
    public static function remove($key) {
        unset($_SESSION[$key]);
    }
    
    /**
     * Clear all session data
     */
    public static function clear() {
        $_SESSION = [];
    }
    
    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        return self::has('user_id') && self::has('user_role');
    }
    
    /**
     * Check if user is admin
     */
    public static function isAdmin() {
        return self::isLoggedIn() && self::get('user_role') === ROLE_ADMIN;
    }
    
    /**
     * Check if user is customer
     */
    public static function isCustomer() {
        return self::isLoggedIn() && self::get('user_role') === ROLE_CUSTOMER;
    }
    
    /**
     * Get current user ID
     */
    public static function getUserId() {
        return self::get('user_id');
    }
    
    /**
     * Get current user role
     */
    public static function getUserRole() {
        return self::get('user_role');
    }
    
    /**
     * Get current user name
     */
    public static function getUserName() {
        return self::get('user_name');
    }
    
    /**
     * Set user session (after login)
     */
    public static function setUser($userId, $userName, $userRole) {
        self::set('user_id', $userId);
        self::set('user_name', $userName);
        self::set('user_role', $userRole);
        self::set('login_time', time());
    }
    
    /**
     * Destroy user session (logout)
     */
    public static function destroyUser() {
        self::remove('user_id');
        self::remove('user_name');
        self::remove('user_role');
        self::remove('login_time');
    }
    
    /**
     * Check if session has expired
     */
    public static function isExpired() {
        if (!self::has('login_time')) {
            return false;
        }
        return (time() - self::get('login_time')) > SESSION_TIMEOUT;
    }
    
    /**
     * Set flash message
     */
    public static function setFlash($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    /**
     * Get flash message
     */
    public static function getFlash() {
        if (self::has('flash')) {
            $flash = self::get('flash');
            self::remove('flash');
            return $flash;
        }
        return null;
    }
}

?>
