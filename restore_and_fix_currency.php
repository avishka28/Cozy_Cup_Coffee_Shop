<?php
/**
 * Restore and Fix Currency
 * Properly restores PHP variables and updates currency display
 */

echo "Restoring and Fixing Currency\n";
echo "=============================\n\n";

$files = [
    'app/views/customer/menu.php',
    'app/views/customer/cart.php',
    'app/views/customer/checkout.php',
    'app/views/customer/account.php',
    'app/views/customer/order-details.php',
    'app/views/customer/order-confirmation.php',
    'app/views/admin/order-details.php',
    'app/views/admin/customer-details.php',
];

foreach ($files as $file) {
    $filepath = __DIR__ . '/' . $file;
    
    if (!file_exists($filepath)) {
        echo "File not found: {$file}\n";
        continue;
    }
    
    $content = file_get_contents($filepath);
    
    // Restore PHP variables
    $content = str_replace('Rs.$', '$', $content);
    $content = str_replace('Rs.<?php', '$<?php', $content);
    $content = str_replace('Rs.selected_category', '$selected_category', $content);
    $content = str_replace('Rs.categories', '$categories', $content);
    $content = str_replace('Rs.cat', '$cat', $content);
    $content = str_replace('Rs.items', '$items', $content);
    $content = str_replace('Rs.item', '$item', $content);
    
    // Now properly add Rs. for currency display
    // Pattern: $<?php echo number_format
    $content = str_replace('$<?php echo number_format', 'Rs.<?php echo number_format', $content);
    
    file_put_contents($filepath, $content);
    echo "Fixed: {$file}\n";
}

echo "\nAll files restored and currency fixed!\n";
?>
