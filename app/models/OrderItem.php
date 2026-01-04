<?php
// Order Item Model

require_once __DIR__ . '/Database.php';

class OrderItem {
    private $db;
    
    public $id;
    public $order_id;
    public $menu_item_id;
    public $quantity;
    public $special_requests;
    public $item_price;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Create order item
     */
    public function create($order_id, $menu_item_id, $quantity, $special_requests, $item_price) {
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, menu_item_id, quantity, special_requests, item_price) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisd", $order_id, $menu_item_id, $quantity, $special_requests, $item_price);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Order item created'];
        } else {
            return ['success' => false, 'error' => 'Failed to create order item'];
        }
    }
    
    /**
     * Get items by order
     */
    public function getByOrder($order_id) {
        $stmt = $this->db->prepare("SELECT oi.*, m.name, m.description FROM order_items oi JOIN menu_items m ON oi.menu_item_id = m.id WHERE oi.order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>
