<?php
// Reservation Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Reservation.php';

class ReservationController extends BaseController {
    
    /**
     * Show reservation form
     */
    public function showReservationForm() {
        $this->requireCustomer();
        $this->render('customer/reservation-form');
    }
    
    /**
     * Handle availability check
     */
    public function handleAvailabilityCheck() {
        $this->requireCustomer();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=reservations');
        }
        
        // Verify CSRF token
        if (!SecurityHelper::verifyCSRFToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Invalid request');
            $this->redirect(SITE_URL . '/public/index.php?page=reservations');
        }
        
        $reservation_date = $this->getPost('reservation_date');
        $reservation_time = $this->getPost('reservation_time');
        $number_of_guests = $this->getPost('number_of_guests');
        
        // Validate inputs
        if (!ValidationHelper::validateDate($reservation_date) || !ValidationHelper::validateTime($reservation_time) || 
            !ValidationHelper::validateNumeric($number_of_guests)) {
            $this->setFlash('error', 'Please fill in all required fields');
            $this->redirect(SITE_URL . '/public/index.php?page=reservations');
        }
        
        // Get available tables
        $reservation = new Reservation();
        $available_tables = $reservation->getAvailableTables($reservation_date, $reservation_time, $number_of_guests);
        
        $this->render('customer/reservation-tables', [
            'available_tables' => $available_tables,
            'reservation_date' => $reservation_date,
            'reservation_time' => $reservation_time,
            'number_of_guests' => $number_of_guests
        ]);
    }
    
    /**
     * Handle reservation creation
     */
    public function handleReservation() {
        $this->requireCustomer();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(SITE_URL . '/public/index.php?page=reservations');
        }
        
        // Verify CSRF token
        if (!SecurityHelper::verifyCSRFToken($this->getPost('csrf_token'))) {
            $this->setFlash('error', 'Invalid request');
            $this->redirect(SITE_URL . '/public/index.php?page=reservations');
        }
        
        $reservation_date = $this->getPost('reservation_date');
        $reservation_time = $this->getPost('reservation_time');
        $number_of_guests = $this->getPost('number_of_guests');
        $table_id = $this->getPost('table_id');
        
        // Validate inputs
        if (!ValidationHelper::validateDate($reservation_date) || !ValidationHelper::validateTime($reservation_time) || 
            !ValidationHelper::validateNumeric($number_of_guests) || !ValidationHelper::validateNumeric($table_id)) {
            $this->setFlash('error', 'Please fill in all required fields');
            $this->redirect(SITE_URL . '/public/index.php?page=reservations');
        }
        
        // Create reservation
        $reservation = new Reservation();
        $result = $reservation->create(SessionHelper::getUserId(), [
            'reservation_date' => $reservation_date,
            'reservation_time' => $reservation_time,
            'number_of_guests' => $number_of_guests,
            'table_id' => $table_id
        ]);
        
        if ($result['success']) {
            $this->setFlash('success', $result['message']);
            $this->redirect(SITE_URL . '/public/index.php?page=reservation-confirmation&id=' . $result['reservation_id']);
        } else {
            $this->setFlash('error', $result['error']);
            $this->redirect(SITE_URL . '/public/index.php?page=reservations');
        }
    }
    
    /**
     * Show reservation confirmation
     */
    public function showConfirmation() {
        $this->requireCustomer();
        
        $reservation_id = $this->getGet('id');
        
        if (!ValidationHelper::validateNumeric($reservation_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        $reservation = new Reservation();
        $reservationData = $reservation->getById($reservation_id);
        
        if (!$reservationData || $reservationData['customer_id'] != SessionHelper::getUserId()) {
            $this->setFlash('error', 'Reservation not found');
            $this->redirect(SITE_URL . '/public/index.php?page=home');
        }
        
        $this->render('customer/reservation-confirmation', [
            'reservation' => $reservationData
        ]);
    }
}

?>
