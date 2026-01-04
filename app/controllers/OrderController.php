<?php
// Order Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Table.php';
require_once __DIR__ . '/../models/MenuItem.php';

class OrderController extends BaseController {
    
    /**
     * Show checkout page
     */
    public function showCheckout() {
        $this->requireCustomer();
        
        if (Cart::isEmpty()) {
            $this->setFlash('error', 'Your cart is empty');
            $this->redirect(SITE_URL . '/public/index.php?page=menu');
        }
        
        $cartItems = Cart::getItems();
        $menuItem = new MenuItem();
        $table = new Table();
        
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
        
        $tables = $table->getAll();
        
        $this->render('customer/checkout', [
            'items' => $items,
            'total' => $total,
            'tables' => $tables
        ]);
    }
    
    /**
     * Handle order placement
     */
    public function handleCheckout() {
        $this->requireCustomer();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=checkout');
        }
        
        // Verify CSRF token
        if (!SecurityHelper::verifyCSRFToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Invalid request');
            $this->redirect(SITE_URL . '/public/index.php?page=checkout');
        }
        
        if (Cart::isEmpty()) {
            $this->setFlash('error', 'Your cart is empty');
            $this->redirect(SITE_URL . '/public/index.php?page=menu');
        }
        
        $order_type = $this->getPost('order_type');
        $delivery_address = $this->getPost('delivery_address', '');
        $table_id = $this->getPost('table_id', null);
        
        // Calculate total
        $cartItems = Cart::getItems();
        $menuItem = new MenuItem();
        $total = 0;
        
        foreach ($cartItems as $cartItem) {
            $item = $menuItem->getById($cartItem['menu_item_id']);
            if ($item) {
                $total += $item['price'] * $cartItem['quantity'];
            }
        }
        
        // Create order
        $order = new Order();
        $orderData = [
            'order_type' => $order_type,
            'total_price' => $total,
            'delivery_address' => $delivery_address,
            'table_id' => $table_id
        ];
        
        $result = $order->create(SessionHelper::getUserId(), $orderData);
        
        if (!$result['success']) {
            $this->setFlash('error', $result['error']);
            $this->redirect(SITE_URL . '/public/index.php?page=checkout');
        }
        
        $order_id = $result['order_id'];
        
        // Create order items
        $orderItem = new OrderItem();
        foreach ($cartItems as $cartItem) {
            $item = $menuItem->getById($cartItem['menu_item_id']);
            if ($item) {
                $orderItem->create($order_id, $cartItem['menu_item_id'], $cartItem['quantity'], $cartItem['special_requests'], $item['price']);
            }
        }
        
        // Clear cart
        Cart::clear();
        
        $this->setFlash('success', 'Order placed successfully');
        $this->redirect(SITE_URL . '/public/index.php?page=order-confirmation&id=' . $order_id);
    }
    
    /**
     * Show order confirmation
     */
    public function showConfirmation() {
        $this->requireCustomer();
        
        $order_id = $this->getGet('id');
        
        if (!ValidationHelper::validateNumeric($order_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        $order = new Order();
        $orderData = $order->getById($order_id);
        
        if (!$orderData || $orderData['customer_id'] != SessionHelper::getUserId()) {
            $this->setFlash('error', 'Order not found');
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        $orderItem = new OrderItem();
        $items = $orderItem->getByOrder($order_id);
        
        $this->render('customer/order-confirmation', [
            'order' => $orderData,
            'items' => $items
        ]);
    }
}

?>
