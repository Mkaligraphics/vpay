<?php

require '../config/database.php';

$db = new dbase();

if (!isset($_POST['id'])) {
    die("ID not received");
}

$id = $_POST['id'];

$stmt = $db->con->prepare("UPDATE property_types SET status='Inactive' WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Deleted successfully";
} else {
    echo $db->con->error;
}
?>
