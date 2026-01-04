<?php
/**
 * Fix Currency - Restore and properly update
 * Only replace $ in display contexts, not in PHP variables
 */

echo "Fixing Currency Display\n";
echo "=======================\n\n";

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

foreach ($files_to_update as $file) {
    $filepath = __DIR__ . '/' . $file;
    
    if (!file_exists($filepath)) {
        echo "File not found: {$file}\n";
        continue;
    }
    
    $content = file_get_contents($filepath);
    $original_content = $content;
    
    // Fix PHP variables first - restore them
    $content = str_replace('Rs.$', '$', $content);
    
    // Now replace only display currency: "Rs." followed by number_format or echo
    // Pattern: Rs.<?php echo number_format
    $content = str_replace('Rs.<?php echo number_format', 'Rs.<?php echo number_format', $content);
    
    // Pattern: Rs.<?php echo $ (for variables)
    $content = preg_replace('/Rs\.(<\?php\s+echo\s+\$)/', 'Rs.$1', $content);
    
    // Pattern: Direct Rs. in text (already done, keep it)
    
    if ($content !== $original_content) {
        file_put_contents($filepath, $content);
        echo "Fixed: {$file}\n";
        $updated_files++;
    }
}

echo "\nFixed {$updated_files} files\n";
?>
