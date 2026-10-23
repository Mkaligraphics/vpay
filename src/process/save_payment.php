<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json');
$db = new dbase;
$invoiceId = filter_input(INPUT_POST, 'invoice_id', FILTER_VALIDATE_INT);
$tenant = filter_input(INPUT_POST, 'tenant_id', FILTER_VALIDATE_INT);
$method = $_POST['method'] ?? '';
$date = $_POST['payment_date'] ?? '';
if (!$invoiceId || !$tenant || !in_array($method, ['M-Pesa', 'Cash', 'Bank'], true) || !valid_date($date)) {
    http_response_code(422);
    echo json_encode(['status'=>'error', 'message'=>'Select an invoice, payment method and valid payment date.']);
    exit;
}
try {
    $db->con->begin_transaction();
    $stmt = $db->con->prepare('SELECT * FROM invoices WHERE id = ? AND tenant_id = ? AND active = 1 FOR UPDATE');
    $stmt->bind_param('ii', $invoiceId, $tenant);
    $stmt->execute();
    $invoice = $stmt->get_result()->fetch_assoc();
    if (!$invoice || $invoice['status'] !== 'unpaid') throw new DomainException('This invoice is unavailable or has already been paid.');
    // Resolve legacy invoice names on the server; never trust posted amounts or property IDs.
    $stmt = $db->con->prepare('SELECT p.id FROM properties p JOIN property_units u ON u.property_id = p.id WHERE p.name = ? AND u.unit_number = ?');
    $stmt->bind_param('ss', $invoice['property'], $invoice['unit']);
    $stmt->execute();
    $properties = $stmt->get_result();
    if ($properties->num_rows !== 1) throw new DomainException('The invoice property or unit could not be uniquely identified.');
    $property = $properties->fetch_assoc()['id'];
    $amount = $invoice['total_amount'];
    if ($amount <= 0 || !valid_date($invoice['due_date'])) throw new DomainException('The invoice amount or billing date is invalid.');
    $period = substr($invoice['due_date'], 0, 7) . '-01';
    $stmt = $db->con->prepare('INSERT INTO payments (tenant, property_id, amount, method, payment_for, date) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('iidsss', $tenant, $property, $amount, $method, $period, $date);
    $stmt->execute();
    $stmt = $db->con->prepare("UPDATE invoices SET status = 'paid' WHERE id = ?");
    $stmt->bind_param('i', $invoiceId);
    $stmt->execute();
    $db->con->commit();
    echo json_encode(['status'=>'success', 'message'=>'Payment recorded and invoice marked as paid.']);
} catch (Throwable $e) {
    $db->con->rollback();
    http_response_code($e instanceof DomainException ? 422 : 500);
    if (!($e instanceof DomainException)) error_log($e);
    echo json_encode(['status'=>'error', 'message'=>$e instanceof DomainException ? $e->getMessage() : 'Unable to save payment. Please try again.']);
}
