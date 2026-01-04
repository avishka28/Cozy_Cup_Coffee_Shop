<?php
// Table Model

require_once __DIR__ . '/Database.php';

class Table {
    private $db;
    
    public $id;
    public $table_number;
    public $capacity;
    public $is_available;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Get all tables
     */
    public function getAll() {
        $result = $this->db->query("SELECT * FROM tables ORDER BY table_number");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get table by ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tables WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    /**
     * Get available tables for a specific date and time
     */
    public function getAvailable($date, $time, $guests) {
        // Get tables that are not reserved at the specified time
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
}

?>
