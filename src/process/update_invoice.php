<?php
require '../config/database.php';
$db = new dbase;
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
$due = $_POST['due_date'] ?? '';
$end = $_POST['period_to'] ?? '';
if (!$id || !$amount || $amount <= 0 || !valid_date($due) || !valid_date($end) || $end <= $due) { http_response_code(422); exit('Enter a positive amount and valid billing dates.'); }
// Paid invoices are immutable; settlement happens through the payment flow.
$stmt = $db->con->prepare("UPDATE invoices SET total_amount=?, due_date=?, period_to=? WHERE id=? AND status='unpaid' AND active=1");
$stmt->bind_param('dssi', $amount, $due, $end, $id); $stmt->execute();
echo 'success';
