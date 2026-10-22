<?php
require '../config/database.php';
$db = new dbase;
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(422); exit('Invalid tenant.'); }
try {
    $db->con->begin_transaction();
    $stmt = $db->con->prepare('SELECT id FROM tenants WHERE id = ? FOR UPDATE');
    $stmt->bind_param('i', $id); $stmt->execute();
    if (!$stmt->get_result()->fetch_assoc()) throw new DomainException('Tenant not found.');
    $stmt = $db->con->prepare("UPDATE property_units u JOIN tenant_info ti ON ti.unit_id = u.id SET u.status = 'vacant' WHERE ti.tenant_id = ? AND ti.active = 1");
    $stmt->bind_param('i', $id); $stmt->execute();
    $stmt = $db->con->prepare('UPDATE tenant_info SET active = 0 WHERE tenant_id = ?');
    $stmt->bind_param('i', $id); $stmt->execute();
    $stmt = $db->con->prepare('UPDATE tenants SET active = 0 WHERE id = ?');
    $stmt->bind_param('i', $id); $stmt->execute();
    $db->con->commit(); echo 'success';
} catch (Throwable $e) {
    $db->con->rollback(); error_log($e); http_response_code(500); echo 'Unable to remove tenant.';
}
