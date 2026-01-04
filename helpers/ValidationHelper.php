<?php
// Validation Helper

class ValidationHelper {
    
    /**
     * Validate email format
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Validate password strength
     */
    public static function validatePassword($password) {
        if (strlen($password) < MIN_PASSWORD_LENGTH) {
            return false;
        }
        return true;
    }
    
    /**
     * Validate phone number
     */
    public static function validatePhone($phone) {
        // Remove non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        // Check if phone has at least 10 digits
        return strlen($phone) >= 10;
    }
    
    /**
     * Validate required field
     */
    public static function validateRequired($value) {
        return !empty(trim($value));
    }
    
    /**
     * Validate address
     */
    public static function validateAddress($address) {
        return !empty(trim($address)) && strlen($address) >= 5;
    }
    
    /**
     * Validate numeric value
     */
    public static function validateNumeric($value) {
        return is_numeric($value) && $value > 0;
    }
    
    /**
     * Validate date format (YYYY-MM-DD)
     */
    public static function validateDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
    
    /**
     * Validate time format (HH:MM)
     */
    public static function validateTime($time) {
        $t = DateTime::createFromFormat('H:i', $time);
        return $t && $t->format('H:i') === $time;
    }
    
    /**
     * Sanitize string input
     */
    public static function sanitizeString($string) {
        return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Validate file upload
     */
    public static function validateFileUpload($file, $allowedTypes = ['image/jpeg', 'image/png', 'image/webp']) {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return false;
        }
        
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        return in_array($mimeType, $allowedTypes);
    }
}

?>
