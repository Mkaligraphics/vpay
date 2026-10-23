<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';
$db = new dbase();

$property_id = $_POST['property_id'];
$total_units = $_POST['total_units'];
$prefix = $_POST['prefix'];
$start = $_POST['start_number'];
$unit_type = $_POST['unit_type'];
$rent = $_POST['rent'];
$status = $_POST['status'];
$description = $_POST['description'];

$stmt = $db->con->prepare("INSERT INTO property_units
(property_id, unit_number, unit_type, rent, status, description)
VALUES (?,?,?,?,?,?)");

for($i = 0; $i < $total_units; $i++){

$unit_number = $prefix . ($start + $i);

$stmt->bind_param(
"issdss",
$property_id,
$unit_number,
$unit_type,
$rent,
$status,
$description
);

$stmt->execute();

}

header("Location: ../../units.php?success=1");
?>
