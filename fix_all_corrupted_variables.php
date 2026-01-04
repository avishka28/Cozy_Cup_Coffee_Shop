<?php
/**
 * Fix All Remaining Corrupted PHP Variables
 */

echo "Fixing All Remaining Corrupted Variables\n";
echo "=======================================\n\n";

$files = [
    'app/views/customer/checkout.php',
    'app/views/admin/customer-details.php',
    'app/views/admin/order-details.php',
];

$replacements = [
    'Rs.customer' => '$customer',
    'Rs.orders' => '$orders',
    'Rs.order' => '$order',
    'Rs.tables' => '$tables',
    'Rs.table' => '$table',
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
echo "\nAll corrupted variables have been fixed!\n";
?>
