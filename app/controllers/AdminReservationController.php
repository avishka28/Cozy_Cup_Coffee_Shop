<?php
// Admin Reservation Controller

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Reservation.php';

class AdminReservationController extends BaseController {
    
    /**
     * Show reservation management page
     */
    public function showReservationManagement() {
        $this->requireAdmin();
        
        $reservation = new Reservation();
        $reservations = $reservation->getAll();
        
        $this->render('admin/reservation-management', [
            'reservations' => $reservations
        ]);
    }
    
    /**
     * Show reservation details
     */
    public function showReservationDetails() {
        $this->requireAdmin();
        
        $reservation_id = $this->getGet('id');
        
        if (!ValidationHelper::validateNumeric($reservation_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=reservation-management');
        }
        
        $reservation = new Reservation();
        $reservationData = $reservation->getById($reservation_id);
        
        if (!$reservationData) {
            $this->setFlash('error', 'Reservation not found');
            $this->redirect(SITE_URL . '/public/index.php?page=reservation-management');
        }
        
        $this->render('admin/reservation-details', [
            'reservation' => $reservationData
        ]);
    }
    
    /**
     * Handle accept reservation
     */
    public function handleAcceptReservation() {
        $this->requireAdmin();
        
        $reservation_id = $this->getGet('id');
        
        if (!ValidationHelper::validateNumeric($reservation_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=reservation-management');
        }
        
        $reservation = new Reservation();
        $result = $reservation->updateStatus($reservation_id, RESERVATION_STATUS_ACCEPTED);
        
        if ($result['success']) {
            $this->setFlash('success', 'Reservation accepted');
        } else {
            $this->setFlash('error', $result['error']);
        }
        
        $this->redirect(SITE_URL . '/public/index.php?page=reservation-management');
    }
    
    /**
     * Handle decline reservation
     */
    public function handleDeclineReservation() {
        $this->requireAdmin();
        
        $reservation_id = $this->getGet('id');
        
        if (!ValidationHelper::validateNumeric($reservation_id)) {
            $this->redirect(SITE_URL . '/public/index.php?page=reservation-management');
        }
        
        $reservation = new Reservation();
        $result = $reservation->updateStatus($reservation_id, RESERVATION_STATUS_DECLINED);
        
        if ($result['success']) {
            $this->setFlash('success', 'Reservation declined');
        } else {
            $this->setFlash('error', $result['error']);
        }
        
        $this->redirect(SITE_URL . '/public/index.php?page=reservation-management');
    }
}

?>
