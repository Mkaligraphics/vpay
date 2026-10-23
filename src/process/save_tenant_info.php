<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';
$db = new dbase;
$tenant = filter_input(INPUT_POST, 'tenant_id', FILTER_VALIDATE_INT);
$property = filter_input(INPUT_POST, 'property_id', FILTER_VALIDATE_INT);
$unit = filter_input(INPUT_POST, 'unit_id', FILTER_VALIDATE_INT);
$amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
if (!$tenant || !$property || !$unit || $amount === false || $amount <= 0) { http_response_code(422); exit('Select a tenant, property, unit and positive rent.'); }
try {
    $db->con->begin_transaction();
    $stmt = $db->con->prepare("SELECT id FROM property_units WHERE id = ? AND property_id = ? AND active = 1 AND status = 'vacant' FOR UPDATE");
    $stmt->bind_param('ii', $unit, $property); $stmt->execute();
    if (!$stmt->get_result()->fetch_assoc()) throw new DomainException('This unit is no longer vacant.');
    $stmt = $db->con->prepare('SELECT id FROM tenants WHERE id = ? AND active = 1');
    $stmt->bind_param('i', $tenant); $stmt->execute();
    if (!$stmt->get_result()->fetch_assoc()) throw new DomainException('Select an active tenant.');
    $stmt = $db->con->prepare('SELECT id FROM tenant_info WHERE unit_id = ? AND active = 1');
    $stmt->bind_param('i', $unit); $stmt->execute();
    if ($stmt->get_result()->num_rows) throw new DomainException('This unit is already assigned.');
    $stmt = $db->con->prepare('INSERT INTO tenant_info (tenant_id, property_id, unit_id, amount) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('iiid', $tenant, $property, $unit, $amount); $stmt->execute();
    $stmt = $db->con->prepare("UPDATE property_units SET status = 'occupied' WHERE id = ?");
    $stmt->bind_param('i', $unit); $stmt->execute();
    $db->con->commit(); echo 'success';
} catch (Throwable $e) {
    $db->con->rollback();
    if (!($e instanceof DomainException)) error_log($e);
    http_response_code(422); echo $e instanceof DomainException ? $e->getMessage() : 'Unable to assign unit.';
}
