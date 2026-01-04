<?php
/**
 * Test Cart and Account Functionality
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/models/Cart.php';
require_once __DIR__ . '/app/models/Order.php';
require_once __DIR__ . '/app/models/User.php';

echo "Cart and Account Functionality Test\n";
echo "===================================\n\n";

// Test 1: Check if cart is working
echo "Test 1: Cart Functionality\n";
echo "-------------------------\n";

Cart::init();
echo "Cart initialized\n";

// Add test item
Cart::addItem(1, 2, 'Extra hot');
echo "Added item to cart\n";

$items = Cart::getItems();
echo "Cart items count: " . count($items) . "\n";
echo "Cart contents: " . json_encode($items) . "\n\n";

// Test 2: Check database connection
echo "Test 2: Database Connection\n";
echo "---------------------------\n";

require_once __DIR__ . '/config/database.php';

if ($conn->connect_error) {
    echo "Database connection failed: " . $conn->connect_error . "\n";
} else {
    echo "Database connection successful\n";
    
    // Check if orders table exists
    $result = $conn->query("SELECT COUNT(*) as count FROM orders");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "Orders in database: " . $row['count'] . "\n";
    }
    
    // Check if customers table exists
    $result = $conn->query("SELECT COUNT(*) as count FROM customers");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "Customers in database: " . $row['count'] . "\n";
    }
}

echo "\n\nTest 3: Order Model\n";
echo "-------------------\n";

$order = new Order();

// Test creating an order (if customer exists)
$result = $conn->query("SELECT id FROM customers LIMIT 1");
if ($result && $result->num_rows > 0) {
    $customer = $result->fetch_assoc();
    $customer_id = $customer['id'];
    
    echo "Found customer ID: {$customer_id}\n";
    
    // Try to get orders for this customer
    $orders = $order->getByCustomer($customer_id);
    echo "Orders for customer: " . count($orders) . "\n";
    
    if (!empty($orders)) {
        echo "Sample order: " . json_encode($orders[0]) . "\n";
    }
} else {
    echo "No customers found in database\n";
}

echo "\n\nTest 4: User Model\n";
echo "------------------\n";

$user = new User();

// Get first customer
$result = $conn->query("SELECT id FROM customers LIMIT 1");
if ($result && $result->num_rows > 0) {
    $customer = $result->fetch_assoc();
    $profile = $user->getProfile($customer['id']);
    
    if ($profile) {
        echo "Customer profile found:\n";
        echo "Name: " . $profile['full_name'] . "\n";
        echo "Email: " . $profile['email'] . "\n";
    } else {
        echo "Could not retrieve customer profile\n";
    }
} else {
    echo "No customers found\n";
}

$conn->close();

echo "\n✓ Tests complete!\n";
?>
