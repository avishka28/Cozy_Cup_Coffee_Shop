<?php
// Menu Item Model

require_once __DIR__ . '/Database.php';

class MenuItem {
    private $db;
    
    public $id;
    public $name;
    public $description;
    public $category;
    public $price;
    public $image_path;
    public $is_available;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Get all menu items
     */
    public function getAll() {
        $result = $this->db->query("SELECT * FROM menu_items WHERE is_available = TRUE ORDER BY category, name");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get items by category
     */
    public function getByCategory($category) {
        $stmt = $this->db->prepare("SELECT * FROM menu_items WHERE category = ? AND is_available = TRUE ORDER BY name");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get item by ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM menu_items WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    /**
     * Create new menu item
     */
    public function create($data) {
        // Validate inputs
        if (!ValidationHelper::validateRequired($data['name'])) {
            return ['success' => false, 'error' => 'Item name is required'];
        }
        
        if (!ValidationHelper::validateRequired($data['category'])) {
            return ['success' => false, 'error' => 'Category is required'];
        }
        
        if (!ValidationHelper::validateNumeric($data['price'])) {
            return ['success' => false, 'error' => 'Invalid price'];
        }
        
        $name = $data['name'];
        $description = $data['description'] ?? '';
        $category = $data['category'];
        $price = $data['price'];
        $image_path = $data['image_path'] ?? null;
        
        $stmt = $this->db->prepare("INSERT INTO menu_items (name, description, category, price, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssds", $name, $description, $category, $price, $image_path);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Menu item created successfully', 'id' => $this->db->getLastInsertId()];
        } else {
            return ['success' => false, 'error' => 'Failed to create menu item'];
        }
    }
    
    /**
     * Update menu item
     */
    public function update($id, $data) {
        $updates = [];
        $params = [];
        $types = "";
        
        if (isset($data['name'])) {
            $updates[] = "name = ?";
            $params[] = $data['name'];
            $types .= "s";
        }
        
        if (isset($data['description'])) {
            $updates[] = "description = ?";
            $params[] = $data['description'];
            $types .= "s";
        }
        
        if (isset($data['category'])) {
            $updates[] = "category = ?";
            $params[] = $data['category'];
            $types .= "s";
        }
        
        if (isset($data['price'])) {
            $updates[] = "price = ?";
            $params[] = $data['price'];
            $types .= "d";
        }
        
        if (isset($data['image_path'])) {
            $updates[] = "image_path = ?";
            $params[] = $data['image_path'];
            $types .= "s";
        }
        
        if (isset($data['is_available'])) {
            $updates[] = "is_available = ?";
            $params[] = $data['is_available'];
            $types .= "i";
        }
        
        if (empty($updates)) {
            return ['success' => false, 'error' => 'No data to update'];
        }
        
        $params[] = $id;
        $types .= "i";
        
        $sql = "UPDATE menu_items SET " . implode(", ", $updates) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Menu item updated successfully'];
        } else {
            return ['success' => false, 'error' => 'Failed to update menu item'];
        }
    }
    
    /**
     * Delete menu item
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM menu_items WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Menu item deleted successfully'];
        } else {
            return ['success' => false, 'error' => 'Failed to delete menu item'];
        }
    }
    
    /**
     * Get all categories
     */
    public function getCategories() {
        $result = $this->db->query("SELECT DISTINCT category FROM menu_items ORDER BY category");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>
