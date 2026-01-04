<?php
// QR Order Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/MenuItem.php';
require_once __DIR__ . '/../models/Cart.php';

class QROrderController extends BaseController {
    
    /**
     * Show QR order menu
     */
    public function showQRMenu() {
        $table_number = $this->getGet('table');
        
        if (!ValidationHelper::validateRequired($table_number)) {
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        // Store table number in session
        SessionHelper::set('qr_table_number', $table_number);
        
        $menuItem = new MenuItem();
        $items = $menuItem->getAll();
        
        $this->render('customer/qr-order', [
            'items' => $items,
            'table_number' => $table_number
        ]);
    }
    
    /**
     * Handle add to cart from QR
     */
    public function handleQRAddToCart() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        // Verify CSRF token
        if (!SecurityHelper::verifyCSRFToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Invalid request');
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        $menu_item_id = $this->getPost('menu_item_id');
        $quantity = $this->getPost('quantity');
        $table_number = $this->getPost('table_number');
        $special_requests = $this->getPost('special_requests', '');
        
        // Validate inputs
        if (!ValidationHelper::validateNumeric($menu_item_id) || !ValidationHelper::validateNumeric($quantity)) {
            $this->setFlash('error', 'Invalid item or quantity');
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        // Verify menu item exists
        $menuItem = new MenuItem();
        $item = $menuItem->getById($menu_item_id);
        
        if (!$item) {
            $this->setFlash('error', 'Menu item not found');
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        // Store table number in session
        SessionHelper::set('qr_table_number', $table_number);
        
        // Add to cart
        Cart::addItem($menu_item_id, $quantity, $special_requests);
        
        $this->setFlash('success', 'Item added to cart');
        $this->redirect(SITE_URL . '/public/index.php?page=qr-menu&table=' . urlencode($table_number));
    }
    
    /**
     * Show QR cart
     */
    public function showQRCart() {
        $table_number = $this->getGet('table');
        
        if (!ValidationHelper::validateRequired($table_number)) {
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        SessionHelper::set('qr_table_number', $table_number);
        
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
        
        $this->render('customer/qr-cart', [
            'items' => $items,
            'total' => $total,
            'table_number' => $table_number
        ]);
    }
    
    /**
     * Handle QR checkout
     */
    public function handleQRCheckout() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        // Verify CSRF token
        if (!SecurityHelper::verifyCSRFToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Invalid request');
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        $table_number = $this->getPost('table_number');
        
        if (Cart::isEmpty()) {
            $this->setFlash('error', 'Your cart is empty');
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        // Get table ID from table number
        require_once __DIR__ . '/../models/Table.php';
        $tableModel = new Table();
        $tables = $tableModel->getAll();
        $table_id = null;
        
        foreach ($tables as $table) {
            if ($table['table_number'] == $table_number) {
                $table_id = $table['id'];
                break;
            }
        }
        
        if (!$table_id) {
            $this->setFlash('error', 'Invalid table');
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
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
        require_once __DIR__ . '/../models/Order.php';
        require_once __DIR__ . '/../models/OrderItem.php';
        
        $order = new Order();
        $orderData = [
            'order_type' => ORDER_TYPE_DINE_IN,
            'total_price' => $total,
            'table_id' => $table_id
        ];
        
        // Create guest order (no customer login required for QR orders)
        $guest_customer_id = $this->createGuestCustomer();
        
        $result = $order->create($guest_customer_id, $orderData);
        
        if (!$result['success']) {
            $this->setFlash('error', $result['error']);
            $this->redirect(SITE_URL . '/public/index.php?page=home');
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
        SessionHelper::remove('qr_table_number');
        
        $this->setFlash('success', 'Order placed successfully');
        $this->redirect(SITE_URL . '/public/index.php?page=qr-confirmation&id=' . $order_id . '&table=' . urlencode($table_number));
    }
    
    /**
     * Show QR confirmation
     */
    public function showQRConfirmation() {
        $order_id = $this->getGet('id');
        $table_number = $this->getGet('table');
        
        if (!ValidationHelper::validateNumeric($order_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        require_once __DIR__ . '/../models/Order.php';
        require_once __DIR__ . '/../models/OrderItem.php';
        
        $order = new Order();
        $orderData = $order->getById($order_id);
        
        if (!$orderData) {
            $this->setFlash('error', 'Order not found');
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        $orderItem = new OrderItem();
        $items = $orderItem->getByOrder($order_id);
        
        $this->render('customer/qr-confirmation', [
            'order' => $orderData,
            'items' => $items,
            'table_number' => $table_number
        ]);
    }
    
    /**
     * Create guest customer for QR orders
     */
    private function createGuestCustomer() {
        require_once __DIR__ . '/../models/User.php';
        
        // For QR orders, create a temporary guest customer
        $guest_email = 'guest_' . time() . '@qrorder.local';
        $guest_password = SecurityHelper::generateToken(16);
        $guest_name = 'QR Guest';
        $guest_phone = '0000000000';
        
        $user = new User();
        $result = $user->register($guest_email, $guest_password, $guest_name, $guest_phone);
        
        if ($result['success']) {
            // Get the newly created user ID
            $stmt = $this->db->prepare("SELECT id FROM customers WHERE email = ?");
            $stmt->bind_param("s", $guest_email);
            $stmt->execute();
            $result = $stmt->get_result();
            $customer = $result->fetch_assoc();
            return $customer['id'];
        }
        
        return null;
    }
}

?>
