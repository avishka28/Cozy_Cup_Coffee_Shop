<?php
/**
 * Remove Duplicate Menu Items
 * Identifies and removes duplicate items, keeping only one of each
 */

require_once __DIR__ . '/config/database.php';

echo "Duplicate Menu Items Removal\n";
echo "============================\n\n";

// Find duplicates
$query = "SELECT name, category, price, COUNT(*) as count, GROUP_CONCAT(id) as ids 
          FROM menu_items 
          GROUP BY name, category, price 
          HAVING count > 1";

$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$duplicates = [];
$total_duplicates = 0;

echo "Found Duplicates:\n";
echo "-----------------\n\n";

while ($row = $result->fetch_assoc()) {
    $ids = explode(',', $row['ids']);
    $keep_id = $ids[0]; // Keep the first one
    $delete_ids = array_slice($ids, 1); // Delete the rest
    
    echo "Item: {$row['name']} ({$row['category']}) - \${$row['price']}\n";
    echo "  Total copies: {$row['count']}\n";
    echo "  IDs: {$row['ids']}\n";
    echo "  Keeping ID: {$keep_id}\n";
    echo "  Deleting IDs: " . implode(', ', $delete_ids) . "\n\n";
    
    $duplicates[] = [
        'name' => $row['name'],
        'category' => $row['category'],
        'keep_id' => $keep_id,
        'delete_ids' => $delete_ids
    ];
    
    $total_duplicates += count($delete_ids);
}

if (empty($duplicates)) {
    echo "✓ No duplicates found!\n";
    $conn->close();
    exit;
}

echo "\nRemoving Duplicates...\n";
echo "=====================\n\n";

// Delete duplicates
$delete_count = 0;

foreach ($duplicates as $dup) {
    foreach ($dup['delete_ids'] as $id) {
        $delete_query = "DELETE FROM menu_items WHERE id = ?";
        $stmt = $conn->prepare($delete_query);
        
        if (!$stmt) {
            echo "✗ Error preparing delete for ID {$id}: " . $conn->error . "\n";
            continue;
        }
        
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo "✓ Deleted duplicate: {$dup['name']} (ID: {$id})\n";
            $delete_count++;
        } else {
            echo "✗ Error deleting ID {$id}: " . $stmt->error . "\n";
        }
        
        $stmt->close();
    }
}

echo "\n\nSummary\n";
echo "=======\n\n";
echo "Total duplicates removed: {$delete_count}\n";

// Show remaining items
$remaining = $conn->query("SELECT category, COUNT(*) as count FROM menu_items GROUP BY category");

echo "\nRemaining Menu Items:\n";
echo "--------------------\n\n";

if ($remaining) {
    while ($row = $remaining->fetch_assoc()) {
        echo "{$row['category']}: {$row['count']} items\n";
    }
}

// Show all remaining items
echo "\n\nAll Remaining Items:\n";
echo "-------------------\n\n";

$all_items = $conn->query("SELECT id, name, category, price FROM menu_items ORDER BY category, name");

if ($all_items) {
    $current_category = '';
    while ($row = $all_items->fetch_assoc()) {
        if ($row['category'] !== $current_category) {
            echo "\n{$row['category']}:\n";
            $current_category = $row['category'];
        }
        echo "  ID: {$row['id']}, {$row['name']} - \${$row['price']}\n";
    }
}

$conn->close();

echo "\n✓ Duplicate removal complete!\n";
?>
