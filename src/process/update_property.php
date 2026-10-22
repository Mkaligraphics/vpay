<?php
require '../config/database.php';
$db = new dbase;
$v0 = $_POST['name'] ?? '';
$v1 = $_POST['county'] ?? '';
$v2 = $_POST['town'] ?? '';
$v3 = $_POST['units'] ?? '';
$v4 = $_POST['min_rent'] ?? '';
$v5 = $_POST['max_rent'] ?? '';
$v6 = $_POST['description'] ?? '';
$v7 = $_POST['id'] ?? '';
$stmt = $db->con->prepare('UPDATE properties SET name=?, county=?, town=?, units=?, min_rent=?, max_rent=?, description=? WHERE id=?');
$stmt->bind_param('sssiddsi', $v0, $v1, $v2, $v3, $v4, $v5, $v6, $v7);
$stmt->execute();
echo 'success';
