<?php
require '../config/database.php';

$db = new dbase;

$tenant_id = $_POST['tenant_id'];

$stmt = $db->con->prepare("
SELECT
    p.name AS property,
    pu.unit_number AS unit,
    pu.rent
FROM tenant_info ti
JOIN tenants t ON ti.tenant_id = t.id
JOIN property_units pu ON ti.unit_id = pu.id
JOIN properties p ON pu.property_id = p.id
WHERE t.id = ?;
");

$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode($result);

?>
