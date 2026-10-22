<?php
require '../config/database.php';
$db = new dbase;
$v0 = $_POST['type_name'] ?? '';
$v1 = $_POST['description'] ?? '';
$v2 = $_POST['id'] ?? '';
$stmt = $db->con->prepare('UPDATE property_types SET type_name=?, description=? WHERE id=?');
$stmt->bind_param('ssi', $v0, $v1, $v2);
$stmt->execute();
echo 'success';
