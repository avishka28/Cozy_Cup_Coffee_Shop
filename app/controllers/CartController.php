<?php
// Cart Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/MenuItem.php';

class CartController extends BaseController {
    
    /**
     * Show cart page
     */
    public function showCart() {
        $this->requireCustomer();
        
        $cartItems = Cart::getItems();
        $menuItem = new MenuItem();
        
        $items = [];
        $total = 0;
        
        foreach ($cartItems as $cartItem) {
            $item = $menuItem->getById($cartItem['menu_item_id']);
            if ($item) {
                $item['quantity'] = $cartItem['quantity'];
                $item['special_requests'] = $cartItem['special_requests'];
                $item['subtotal'] = $item['price'] * $cartItem['quantity'];
                $total += $item['subtotal'];
                $items[] = $item;
            }
        }
        
        $this->render('customer/cart', [
            'items' => $items,
            'total' => $total
        ]);
    }
    
    /**
     * Handle add to cart
     */
    public function handleAddToCart() {
        $this->requireCustomer();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=menu');
        }
        
        // Verify CSRF token
        if (!SecurityHelper::verifyCSRFToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Invalid request');
            $this->redirect(SITE_URL . '/public/index.php?page=menu');
        }
        
        $menu_item_id = $this->getPost('menu_item_id');
        $quantity = $this->getPost('quantity');
        $special_requests = $this->getPost('special_requests', '');
        
        // Validate inputs
        if (!ValidationHelper::validateNumeric($menu_item_id) || !ValidationHelper::validateNumeric($quantity)) {
            $this->setFlash('error', 'Invalid item or quantity');
            $this->redirect(SITE_URL . '/public/index.php?page=menu');
        }
        
        // Verify menu item exists
        $menuItem = new MenuItem();
        $item = $menuItem->getById($menu_item_id);
        
        if (!$item) {
            $this->setFlash('error', 'Menu item not found');
            $this->redirect(SITE_URL . '/public/index.php?page=menu');
        }
        
        // Add to cart
        Cart::addItem($menu_item_id, $quantity, $special_requests);
        
        $this->setFlash('success', 'Item added to cart');
        $this->redirect(SITE_URL . '/public/index.php?page=cart');
    }
    
    /**
     * Handle remove from cart
     */
    public function handleRemoveFromCart() {
        $this->requireCustomer();
        
        $menu_item_id = $this->getGet('id');
        
        if (!ValidationHelper::validateNumeric($menu_item_id)) {
            $this->setFlash('error', 'Invalid item');
            $this->redirect(SITE_URL . '/public/index.php?page=cart');
        }
        
        Cart::removeItem($menu_item_id);
        
        $this->setFlash('success', 'Item removed from cart');
        $this->redirect(SITE_URL . '/public/index.php?page=cart');
    }
    
    /**
     * Handle update quantity
     */
    public function handleUpdateQuantity() {
        $this->requireCustomer();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=cart');
        }
        
        $menu_item_id = $this->getPost('menu_item_id');
        $quantity = $this->getPost('quantity');
        
        if (!ValidationHelper::validateNumeric($menu_item_id) || !ValidationHelper::validateNumeric($quantity)) {
            $this->setFlash('error', 'Invalid item or quantity');
            $this->redirect(SITE_URL . '/public/index.php?page=cart');
        }
        
        Cart::updateQuantity($menu_item_id, $quantity);
        
        $this->setFlash('success', 'Cart updated');
        $this->redirect(SITE_URL . '/public/index.php?page=cart');
    }
}

?>
