<?php
require '../config/database.php';
$db = new dbase;

$id=$_POST['id'];
$name=$_POST['name'];
$county=$_POST['county'];
$town=$_POST['town'];
$units=$_POST['units'];
$min_rent=$_POST['min_rent'];
$max_rent=$_POST['max_rent'];
$description=$_POST['description'];

$db->con->query("UPDATE properties SET

name='$name',
county='$county',
town='$town',
units='$units',
min_rent='$min_rent',
max_rent='$max_rent',
description='$description'

WHERE id='$id'");

echo "updated";

?>