<?php
require '../config/database.php';
$db = new dbase;
$id = $_POST['id'];

$db->con->query("UPDATE properties SET active = '0'  WHERE id='$id'");

echo "deleted";

?>