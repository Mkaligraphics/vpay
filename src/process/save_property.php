<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';
$db = new dbase;
$v0 = $_POST['property_name'] ?? '';
$v1 = $_POST['county'] ?? '';
$v2 = $_POST['town'] ?? '';
$v3 = $_POST['units'] ?? '';
$v4 = $_POST['min_rent'] ?? '';
$v5 = $_POST['max_rent'] ?? '';
$v6 = $_POST['status'] ?? '';
$v7 = $_POST['description'] ?? '';
$stmt = $db->con->prepare('INSERT INTO properties (name, county, town, units, min_rent, max_rent, status, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
$stmt->bind_param('sssiddss', $v0, $v1, $v2, $v3, $v4, $v5, $v6, $v7);
$stmt->execute();
header('Location: ../../dashboard.php');
