<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';
$db = new dbase;
$v0 = $_POST['id'] ?? '';
$stmt = $db->con->prepare("UPDATE invoices SET active=0 WHERE id=? AND status='unpaid'");
$stmt->bind_param('i', $v0);
$stmt->execute();
echo 'success';
