<?php
// Cart Model

class Cart {
    
    /**
     * Initialize cart in session
     */
    public static function init() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }
    
    /**
     * Add item to cart
     */
    public static function addItem($menu_item_id, $quantity, $special_requests = '') {
        self::init();
        
        // Check if item already in cart
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['menu_item_id'] == $menu_item_id) {
                $item['quantity'] += $quantity;
                return true;
            }
        }
        
        // Add new item to cart
        $_SESSION['cart'][] = [
            'menu_item_id' => $menu_item_id,
            'quantity' => $quantity,
            'special_requests' => $special_requests
        ];
        
        return true;
    }
    
    /**
     * Remove item from cart
     */
    public static function removeItem($menu_item_id) {
        self::init();
        
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['menu_item_id'] == $menu_item_id) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Update item quantity
     */
    public static function updateQuantity($menu_item_id, $quantity) {
        self::init();
        
        if ($quantity <= 0) {
            return self::removeItem($menu_item_id);
        }
        
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['menu_item_id'] == $menu_item_id) {
                $item['quantity'] = $quantity;
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get all cart items
     */
    public static function getItems() {
        self::init();
        return $_SESSION['cart'];
    }
    
    /**
     * Get cart count
     */
    public static function getCount() {
        self::init();
        return count($_SESSION['cart']);
    }
    
    /**
     * Clear cart
     */
    public static function clear() {
        $_SESSION['cart'] = [];
    }
    
    /**
     * Check if cart is empty
     */
    public static function isEmpty() {
        self::init();
        return empty($_SESSION['cart']);
    }
}

?>
