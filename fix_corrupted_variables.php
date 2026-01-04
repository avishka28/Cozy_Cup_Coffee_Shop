<?php
/**
 * Fix Corrupted PHP Variables
 * Restores Rs. that replaced $ in PHP variables
 */

echo "Fixing Corrupted PHP Variables\n";
echo "==============================\n\n";

$files = [
    'app/views/customer/account.php',
    'app/views/customer/order-details.php',
    'app/views/customer/order-confirmation.php',
    'app/views/customer/checkout.php',
    'app/views/customer/reservation-form.php',
    'app/views/customer/reservation-tables.php',
    'app/views/customer/reservation-confirmation.php',
    'app/views/customer/reservation-details.php',
];

$replacements = [
    'Rs.profile' => '$profile',
    'Rs.orders' => '$orders',
    'Rs.order' => '$order',
    'Rs.reservations' => '$reservations',
    'Rs.reservation' => '$reservation',
    'Rs.items' => '$items',
    'Rs.item' => '$item',
    'Rs.total' => '$total',
    'Rs.categories' => '$categories',
    'Rs.cat' => '$cat',
    'Rs.selected_category' => '$selected_category',
];

$total_fixes = 0;

foreach ($files as $file) {
    $filepath = __DIR__ . '/' . $file;
    
    if (!file_exists($filepath)) {
        echo "File not found: {$file}\n";
        continue;
    }
    
    $content = file_get_contents($filepath);
    $original_content = $content;
    
    // Replace all corrupted variables
    foreach ($replacements as $corrupted => $correct) {
        $count = substr_count($content, $corrupted);
        if ($count > 0) {
            $content = str_replace($corrupted, $correct, $content);
            $total_fixes += $count;
        }
    }
    
    if ($content !== $original_content) {
        file_put_contents($filepath, $content);
        echo "✓ Fixed: {$file}\n";
    }
}

echo "\n✓ Total fixes applied: {$total_fixes}\n";
echo "\nAll corrupted PHP variables have been restored!\n";
?>
