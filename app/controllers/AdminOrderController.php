<?php
// Admin Order Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';

class AdminOrderController extends BaseController {
    
    /**
     * Show order management page
     */
    public function showOrderManagement() {
        $this->requireAdmin();
        
        $order = new Order();
        $orders = $order->getAll();
        
        $this->render('admin/order-management', [
            'orders' => $orders
        ]);
    }
    
    /**
     * Show order details
     */
    public function showOrderDetails() {
        $this->requireAdmin();
        
        $order_id = $this->getGet('id');
        
        if (!ValidationHelper::validateNumeric($order_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=order-management');
        }
        
        $order = new Order();
        $orderData = $order->getById($order_id);
        
        if (!$orderData) {
            $this->setFlash('error', 'Order not found');
            $this->redirect(SITE_URL . '/public/index.php?page=order-management');
        }
        
        $orderItem = new OrderItem();
        $items = $orderItem->getByOrder($order_id);
        
        $this->render('admin/order-details', [
            'order' => $orderData,
            'items' => $items
        ]);
    }
    
    /**
     * Handle approve order
     */
    public function handleApproveOrder() {
        $this->requireAdmin();
        
        $order_id = $this->getGet('id');
        
        if (!ValidationHelper::validateNumeric($order_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=order-management');
        }
        
        $order = new Order();
        $result = $order->updateStatus($order_id, ORDER_STATUS_PROCESSING);
        
        if ($result['success']) {
            $this->setFlash('success', 'Order approved and moved to processing');
        } else {
            $this->setFlash('error', $result['error']);
        }
        
        $this->redirect(SITE_URL . '/public/index.php?page=order-management');
    }
    
    /**
     * Handle reject order
     */
    public function handleRejectOrder() {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=order-management');
        }
        
        $order_id = $this->getPost('order_id');
        
        if (!ValidationHelper::validateNumeric($order_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=order-management');
        }
        
        $order = new Order();
        $result = $order->updateStatus($order_id, ORDER_STATUS_REJECTED);
        
        if ($result['success']) {
            $this->setFlash('success', 'Order rejected');
        } else {
            $this->setFlash('error', $result['error']);
        }
        
        $this->redirect(SITE_URL . '/public/index.php?page=order-management');
    }
    
    /**
     * Handle complete order
     */
    public function handleCompleteOrder() {
        $this->requireAdmin();
        
        $order_id = $this->getGet('id');
        
        if (!ValidationHelper::validateNumeric($order_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=order-management');
        }
        
        $order = new Order();
        $result = $order->updateStatus($order_id, ORDER_STATUS_COMPLETED);
        
        if ($result['success']) {
            $this->setFlash('success', 'Order marked as completed');
        } else {
            $this->setFlash('error', $result['error']);
        }
        
        $this->redirect(SITE_URL . '/public/index.php?page=order-management');
    }
}

?>
