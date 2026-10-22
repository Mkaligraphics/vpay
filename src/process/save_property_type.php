<?php
require '../config/database.php';
$db = new dbase;
$v0 = $_POST['type_name'] ?? '';
$v1 = $_POST['description'] ?? '';
$stmt = $db->con->prepare('INSERT INTO property_types(type_name, description) VALUES (?, ?)');
$stmt->bind_param('ss', $v0, $v1);
$stmt->execute();
echo 'success';
