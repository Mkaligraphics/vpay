<?php
require '../config/database.php';
$db = new dbase;
$tenant = filter_input(INPUT_POST, 'tenant_id', FILTER_VALIDATE_INT) ?: 0;
$stmt = $db->con->prepare("SELECT i.*, p.id AS property_id, pu.id AS unit_id FROM invoices i LEFT JOIN properties p ON p.name = i.property LEFT JOIN property_units pu ON pu.property_id = p.id AND pu.unit_number = i.unit WHERE i.tenant_id = ? AND i.status = 'unpaid' AND i.active = 1 ORDER BY i.due_date, i.id");
$stmt->bind_param('i', $tenant);
$stmt->execute();
echo '<option value="">Select Invoice</option>';
foreach ($stmt->get_result() as $row) {
    if (!$row['property_id'] || !$row['unit_id']) continue;
    echo '<option value="'.h($row['id']).'" data-property="'.h($row['property']).'" data-property-id="'.h($row['property_id']).'" data-unit="'.h($row['unit']).'" data-unit-id="'.h($row['unit_id']).'" data-amount="'.h($row['total_amount']).'" data-period="'.h(substr($row['due_date'], 0, 7).'-01').'">'.h($row['invoice_no']).' — KES '.number_format($row['total_amount'], 2).'</option>';
}
