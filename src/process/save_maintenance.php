<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';

$db = new dbase;

$stmt = $db->con->prepare("
INSERT INTO maintenance
(tenant_id, property_id, unit_id, title, description, priority, status, request_date)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
"iiisssss",
$_POST['tenant_id'],
$_POST['property_id'],
$_POST['unit_id'],
$_POST['title'],
$_POST['description'],
$_POST['priority'],
$_POST['status'],
$_POST['request_date']
);

$stmt->execute();
?>
