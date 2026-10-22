<?php
require '../config/database.php';
$db = new dbase;

$tenant_id = (int)($_POST['tenant_id'] ?? 0);

$query = $db->con->query("
    SELECT
        u.id,
        u.unit_number,
        u.rent
    FROM property_units u
    JOIN tenant_info ti ON ti.unit_id = u.id
    WHERE ti.tenant_id = '$tenant_id'
    AND ti.active = 1
");

echo '<option value="">Select Unit</option>';

while ($row = $query->fetch_assoc()) {
    echo '
        <option value="'.$row['id'].'" data-rent="'.$row['rent'].'">
            '.$row['unit_number'].'
        </option>
    ';
}
?>
