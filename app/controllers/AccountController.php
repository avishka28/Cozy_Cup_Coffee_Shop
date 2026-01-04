<?php
// Account Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';
require_once __DIR__ . '/../models/Reservation.php';

class AccountController extends BaseController {
    
    /**
     * Show account dashboard
     */
    public function showAccount() {
        $this->requireCustomer();
        
        $user = new User();
        $profile = $user->getProfile(SessionHelper::getUserId());
        
        $order = new Order();
        $orders = $order->getByCustomer(SessionHelper::getUserId());
        
        $reservation = new Reservation();
        $reservations = $reservation->getByCustomer(SessionHelper::getUserId());
        
        $this->render('customer/account', [
            'profile' => $profile,
            'orders' => $orders,
            'reservations' => $reservations
        ]);
    }
    
    /**
     * Show order details
     */
    public function showOrderDetails() {
        $this->requireCustomer();
        
        $order_id = $this->getGet('id');
        
        if (!ValidationHelper::validateNumeric($order_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=account');
        }
        
        $order = new Order();
        $orderData = $order->getById($order_id);
        
        if (!$orderData || $orderData['customer_id'] != SessionHelper::getUserId()) {
            $this->setFlash('error', 'Order not found');
            $this->redirect(SITE_URL . '/public/index.php?page=account');
        }
        
        $orderItem = new OrderItem();
        $items = $orderItem->getByOrder($order_id);
        
        $this->render('customer/order-details', [
            'order' => $orderData,
            'items' => $items
        ]);
    }
    
    /**
     * Show reservation details
     */
    public function showReservationDetails() {
        $this->requireCustomer();
        
        $reservation_id = $this->getGet('id');
        
        if (!ValidationHelper::validateNumeric($reservation_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=account');
        }
        
        $reservation = new Reservation();
        $reservationData = $reservation->getById($reservation_id);
        
        if (!$reservationData || $reservationData['customer_id'] != SessionHelper::getUserId()) {
            $this->setFlash('error', 'Reservation not found');
            $this->redirect(SITE_URL . '/public/index.php?page=account');
        }
        
        $this->render('customer/reservation-details', [
            'reservation' => $reservationData
        ]);
    }
}

?>
