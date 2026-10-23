<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';
$db = new dbase;
$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$lease = $_POST['lease_start'] ?? '';
if (!$name || !$phone || ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) || !valid_date($lease)) { http_response_code(422); exit('Enter a name, phone, valid email and lease date.'); }
$stmt = $db->con->prepare('INSERT INTO tenants (name, phone, email, lease_start) VALUES (?, ?, ?, ?)');
$stmt->bind_param('ssss', $name, $phone, $email, $lease);
$stmt->execute();
echo 'success';
