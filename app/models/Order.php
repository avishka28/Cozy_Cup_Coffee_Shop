<?php
// Order Model

require_once __DIR__ . '/Database.php';

class Order {
    private $db;
    
    public $id;
    public $customer_id;
    public $order_type;
    public $status;
    public $total_price;
    public $delivery_address;
    public $table_id;
    public $created_at;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Create new order
     */
    public function create($customer_id, $order_data) {
        // Validate inputs
        if (!ValidationHelper::validateRequired($order_data['order_type'])) {
            return ['success' => false, 'error' => 'Order type is required'];
        }
        
        if (!ValidationHelper::validateNumeric($order_data['total_price'])) {
            return ['success' => false, 'error' => 'Invalid total price'];
        }
        
        // Validate order type specific requirements
        if ($order_data['order_type'] === ORDER_TYPE_DELIVERY) {
            if (!ValidationHelper::validateAddress($order_data['delivery_address'])) {
                return ['success' => false, 'error' => 'Valid delivery address is required'];
            }
        }
        
        if ($order_data['order_type'] === ORDER_TYPE_DINE_IN) {
            if (!ValidationHelper::validateNumeric($order_data['table_id'])) {
                return ['success' => false, 'error' => 'Table selection is required'];
            }
        }
        
        $order_type = $order_data['order_type'];
        $total_price = $order_data['total_price'];
        $delivery_address = $order_data['delivery_address'] ?? null;
        $table_id = $order_data['table_id'] ?? null;
        $status = ORDER_STATUS_PENDING;
        
        $stmt = $this->db->prepare("INSERT INTO orders (customer_id, order_type, status, total_price, delivery_address, table_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssi", $customer_id, $order_type, $status, $total_price, $delivery_address, $table_id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Order created successfully', 'order_id' => $this->db->getLastInsertId()];
        } else {
            return ['success' => false, 'error' => 'Failed to create order'];
        }
    }
    
    /**
     * Get order by ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    /**
     * Get orders by customer
     */
    public function getByCustomer($customer_id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get all orders
     */
    public function getAll() {
        $result = $this->db->query("SELECT o.*, c.full_name, c.email, c.phone FROM orders o JOIN customers c ON o.customer_id = c.id ORDER BY o.created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Update order status
     */
    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Order status updated'];
        } else {
            return ['success' => false, 'error' => 'Failed to update order status'];
        }
    }
}

?>
