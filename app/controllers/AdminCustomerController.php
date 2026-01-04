<?php
// Admin Customer Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Order.php';

class AdminCustomerController extends BaseController {
    
    /**
     * Show customer management page
     */
    public function showCustomerManagement() {
        $this->requireAdmin();
        
        $user = new User();
        $customers = $user->getAll();
        
        $this->render('admin/customer-management', [
            'customers' => $customers
        ]);
    }
    
    /**
     * Show customer details
     */
    public function showCustomerDetails() {
        $this->requireAdmin();
        
        $customer_id = $this->getGet('id');
        
        if (!ValidationHelper::validateNumeric($customer_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=customer-management');
        }
        
        $user = new User();
        $customer = $user->getById($customer_id);
        
        if (!$customer) {
            $this->setFlash('error', 'Customer not found');
            $this->redirect(SITE_URL . '/public/index.php?page=customer-management');
        }
        
        $order = new Order();
        $orders = $order->getByCustomer($customer_id);
        
        $this->render('admin/customer-details', [
            'customer' => $customer,
            'orders' => $orders
        ]);
    }
}

?>
