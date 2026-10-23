<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';
$db = new dbase;
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) ?: 0;
$stmt = $db->con->prepare('SELECT * FROM invoices WHERE id = ? AND active = 1');
$stmt->bind_param('i', $id); $stmt->execute();
echo json_encode($stmt->get_result()->fetch_assoc());
