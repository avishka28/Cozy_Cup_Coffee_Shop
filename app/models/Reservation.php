<?php
// Reservation Model

require_once __DIR__ . '/Database.php';

class Reservation {
    private $db;
    
    public $id;
    public $customer_id;
    public $table_id;
    public $reservation_date;
    public $reservation_time;
    public $number_of_guests;
    public $status;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Create new reservation
     */
    public function create($customer_id, $reservation_data) {
        // Validate inputs
        if (!ValidationHelper::validateDate($reservation_data['reservation_date'])) {
            return ['success' => false, 'error' => 'Invalid reservation date'];
        }
        
        if (!ValidationHelper::validateTime($reservation_data['reservation_time'])) {
            return ['success' => false, 'error' => 'Invalid reservation time'];
        }
        
        if (!ValidationHelper::validateNumeric($reservation_data['number_of_guests'])) {
            return ['success' => false, 'error' => 'Invalid number of guests'];
        }
        
        if (!ValidationHelper::validateNumeric($reservation_data['table_id'])) {
            return ['success' => false, 'error' => 'Table selection is required'];
        }
        
        $reservation_date = $reservation_data['reservation_date'];
        $reservation_time = $reservation_data['reservation_time'];
        $number_of_guests = $reservation_data['number_of_guests'];
        $table_id = $reservation_data['table_id'];
        $status = RESERVATION_STATUS_PENDING;
        
        $stmt = $this->db->prepare("INSERT INTO reservations (customer_id, table_id, reservation_date, reservation_time, number_of_guests, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissii", $customer_id, $table_id, $reservation_date, $reservation_time, $number_of_guests, $status);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Reservation created successfully', 'reservation_id' => $this->db->getLastInsertId()];
        } else {
            return ['success' => false, 'error' => 'Failed to create reservation'];
        }
    }
    
    /**
     * Get reservation by ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT r.*, t.table_number FROM reservations r JOIN tables t ON r.table_id = t.id WHERE r.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    /**
     * Get reservations by customer
     */
    public function getByCustomer($customer_id) {
        $stmt = $this->db->prepare("SELECT r.*, t.table_number FROM reservations r JOIN tables t ON r.table_id = t.id WHERE r.customer_id = ? ORDER BY r.reservation_date DESC");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get all reservations
     */
    public function getAll() {
        $result = $this->db->query("SELECT r.*, c.full_name, c.email, c.phone, t.table_number FROM reservations r JOIN customers c ON r.customer_id = c.id JOIN tables t ON r.table_id = t.id ORDER BY r.reservation_date DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get available tables for a specific date and time
     */
    public function getAvailableTables($date, $time, $guests) {
        $stmt = $this->db->prepare("
            SELECT t.* FROM tables t 
            WHERE t.capacity >= ? 
            AND t.id NOT IN (
                SELECT table_id FROM reservations 
                WHERE reservation_date = ? 
                AND reservation_time = ? 
                AND status IN ('Pending', 'Accepted')
            )
            ORDER BY t.capacity, t.table_number
        ");
        $stmt->bind_param("iss", $guests, $date, $time);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Update reservation status
     */
    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE reservations SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Reservation status updated'];
        } else {
            return ['success' => false, 'error' => 'Failed to update reservation status'];
        }
    }
}

?>
