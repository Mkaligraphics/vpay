<?php

require '../config/database.php';
$db = new dbase();
if($_POST){

$name = $_POST['property_name'];
$county = $_POST['county'];
$town = $_POST['town'];
$type = $_POST['type'];
$units = $_POST['units'];
$min_rent = $_POST['min_rent'];
$max_rent = $_POST['max_rent'];
$status = $_POST['status'];
$description = $_POST['description'];

$sql = "INSERT INTO properties
(name, county, town, type, units, min_rent, max_rent, status, description)
VALUES
('$name','$county','$town','$type','$units','$min_rent','$max_rent','$status','$description')";

$db->con->query($sql);

header("Location: ../../dashboard.php");

}
?>