<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';

$db = new dbase;

$property_id = (int)($_POST['property_id'] ?? 0);

echo '<option value="">Select Unit</option>';

if (!$property_id) {
    echo '<option disabled>No results found</option>';
    exit;
}

// ✅ Only VACANT units
$result = $db->con->query("
    SELECT id, unit_number, rent
    FROM property_units
    WHERE property_id = '$property_id'
    AND status = 'vacant'
    AND active = '1'
");

if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}' data-rent='{$row['rent']}'>
                Unit {$row['unit_number']} - KES {$row['rent']}
              </option>";
    }

} else {
    echo '<option disabled>No vacant units available</option>';
}
?>
