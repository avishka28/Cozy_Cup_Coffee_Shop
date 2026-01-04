<?php
// Image Helper

class ImageHelper {
    
    private static $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    private static $maxFileSize = 5242880; // 5MB
    
    /**
     * Upload and optimize image
     */
    public static function uploadImage($file, $uploadDir = null) {
        if ($uploadDir === null) {
            $uploadDir = UPLOAD_DIR;
        }
        
        // Validate file
        if (!self::validateImage($file)) {
            return ['success' => false, 'error' => 'Invalid image file'];
        }
        
        // Create upload directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Generate unique filename
        $filename = uniqid('img_') . '_' . time() . '.' . self::getFileExtension($file['name']);
        $filepath = $uploadDir . $filename;
        
        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            return ['success' => false, 'error' => 'Failed to upload image'];
        }
        
        // Optimize image
        self::optimizeImage($filepath);
        
        return [
            'success' => true,
            'filename' => $filename,
            'path' => $filepath
        ];
    }
    
    /**
     * Validate image file
     */
    private static function validateImage($file) {
        // Check if file exists
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return false;
        }
        
        // Check file size
        if ($file['size'] > self::$maxFileSize) {
            return false;
        }
        
        // Check MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        return in_array($mimeType, self::$allowedTypes);
    }
    
    /**
     * Optimize image
     */
    private static function optimizeImage($filepath) {
        $imageInfo = getimagesize($filepath);
        $mimeType = $imageInfo['mime'];
        
        // Load image based on type
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($filepath);
                imagejpeg($image, $filepath, 85);
                break;
            case 'image/png':
                $image = imagecreatefrompng($filepath);
                imagepng($image, $filepath, 8);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($filepath);
                imagewebp($image, $filepath, 85);
                break;
        }
        
        if (isset($image)) {
            imagedestroy($image);
        }
    }
    
    /**
     * Get file extension
     */
    private static function getFileExtension($filename) {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return strtolower($ext);
    }
    
    /**
     * Delete image file
     */
    public static function deleteImage($filepath) {
        if (file_exists($filepath)) {
            return unlink($filepath);
        }
        return false;
    }
    
    /**
     * Get image URL
     */
    public static function getImageUrl($filename) {
        return SITE_URL . '/public/uploads/' . $filename;
    }
    
    /**
     * Resize image
     */
    public static function resizeImage($filepath, $width, $height) {
        $imageInfo = getimagesize($filepath);
        $mimeType = $imageInfo['mime'];
        
        // Load image
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($filepath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($filepath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($filepath);
                break;
            default:
                return false;
        }
        
        // Create resized image
        $resized = imagecreatetruecolor($width, $height);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $width, $height, $imageInfo[0], $imageInfo[1]);
        
        // Save resized image
        switch ($mimeType) {
            case 'image/jpeg':
                imagejpeg($resized, $filepath, 85);
                break;
            case 'image/png':
                imagepng($resized, $filepath, 8);
                break;
            case 'image/webp':
                imagewebp($resized, $filepath, 85);
                break;
        }
        
        imagedestroy($image);
        imagedestroy($resized);
        
        return true;
    }
}

?>
