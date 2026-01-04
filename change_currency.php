<?php
/**
 * Change Currency to Rs.
 * Updates all currency references from $ to Rs.
 */

echo "Currency Change: $ to Rs.\n";
echo "========================\n\n";

// Files to update
$files_to_update = [
    'app/views/customer/menu.php',
    'app/views/customer/cart.php',
    'app/views/customer/checkout.php',
    'app/views/customer/account.php',
    'app/views/customer/order-details.php',
    'app/views/customer/order-confirmation.php',
    'app/views/admin/order-details.php',
    'app/views/admin/customer-details.php',
];

$updated_files = 0;
$total_replacements = 0;

foreach ($files_to_update as $file) {
    $filepath = __DIR__ . '/' . $file;
    
    if (!file_exists($filepath)) {
        echo "File not found: {$file}\n";
        continue;
    }
    
    $content = file_get_contents($filepath);
    $original_content = $content;
    
    // Replace all $ with Rs.
    $content = str_replace('$', 'Rs.', $content);
    
    // Count replacements
    $replacements = substr_count($original_content, '$');
    
    if ($content !== $original_content) {
        file_put_contents($filepath, $content);
        echo "Updated: {$file} ({$replacements} replacements)\n";
        $updated_files++;
        $total_replacements += $replacements;
    }
}

echo "\n\nSummary\n";
echo "=======\n\n";
echo "Files updated: {$updated_files}\n";
echo "Total replacements: {$total_replacements}\n";

require_once __DIR__ . '/config/database.php';

echo "\n\nSample Menu Items:\n";
echo "==================\n\n";

$result = $conn->query("SELECT id, name, price FROM menu_items LIMIT 5");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id']}, {$row['name']}: Rs.{$row['price']}\n";
    }
}

$conn->close();

echo "\nCurrency change complete!\n";
?>
