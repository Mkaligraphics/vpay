<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';
$db = new dbase();

$id = (int)($_GET['id'] ?? 0);

$q = $db->con->query("SELECT COUNT(*) as total FROM property_units WHERE property_id='$id'");
$r = $q->fetch_assoc();

echo $r['total'];
?>
