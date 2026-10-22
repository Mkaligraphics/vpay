<?php
require '../config/database.php';

$db = new dbase;

$tenant_id = intval($_POST['tenant_id']);

$stmt = $db->con->prepare("
    SELECT
        ti.tenant_id,
        ti.property_id,
        ti.unit_id,
        ti.amount,
        p.name AS property_name
    FROM tenant_info ti
    JOIN properties p ON ti.property_id = p.id
    WHERE ti.tenant_id = ?
    AND ti.active = 1
    LIMIT 1
");

$stmt->bind_param("i", $tenant_id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode($row);
?>
