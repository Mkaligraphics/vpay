<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';
$db = new dbase;

header('Content-Type: application/json');

// ==========================
// INPUT DATA (SANITIZED)
// ==========================
$tenant_id     = $_POST['tenant_id'] ?? null;
$property      = $_POST['property'] ?? '';
$unit          = $_POST['unit'] ?? '';
$monthly_rent  = $_POST['amount'] ?? 0;
$months        = $_POST['months'] ?? 0;
$total_amount  = $_POST['total'] ?? 0;
$due_date_raw  = $_POST['due_date'] ?? '';
$period_to_raw = $_POST['period_to'] ?? '';
$description   = $_POST['description'] ?? '';

$status = "unpaid";

// ==========================
// VALIDATION
// ==========================
if(!$tenant_id || !$monthly_rent || !$months || !$total_amount){
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

if($months <= 0){
    echo json_encode(["status" => "error", "message" => "Invalid billing period"]);
    exit;
}

// ==========================
// FORMAT DATES
// ==========================
if (!valid_date($due_date_raw) || !valid_date($period_to_raw) || $period_to_raw <= $due_date_raw || !is_numeric($monthly_rent) || $monthly_rent <= 0) {
    echo json_encode(['status'=>'error', 'message'=>'Enter positive rent and a valid billing period ending after the due date.']); exit;
}
$due_date = $due_date_raw;
$period_to = $period_to_raw;
$start = new DateTimeImmutable($due_date);
$end = new DateTimeImmutable($period_to);
$months = ((int)$end->format('Y') - (int)$start->format('Y')) * 12 + ((int)$end->format('m') - (int)$start->format('m'));
if ((int)$end->format('d') > (int)$start->format('d')) $months++;
$total_amount = round($monthly_rent * $months, 2);

// ==========================
// CHECK DUPLICATE INVOICE
// ==========================
$check = $db->con->prepare("
    SELECT id
    FROM invoices
    WHERE tenant_id = ?
    AND period_to = ?
    LIMIT 1
");

if(!$check){
    echo json_encode(["status" => "error", "message" => $db->con->error]);
    exit;
}

$check->bind_param("is", $tenant_id, $period_to);
$check->execute();
$check->store_result();

if($check->num_rows > 0){
    echo json_encode([
        "status" => "error",
        "message" => "Invoice already exists for this tenant in the selected period"
    ]);
    $check->close();
    exit;
}
$check->close();

// ==========================
// GENERATE INVOICE NUMBER
// ==========================
$year = date('Y');

$result = $db->con->query("
    SELECT invoice_no
    FROM invoices
    WHERE invoice_no LIKE 'INV-$year-%'
    ORDER BY id DESC
    LIMIT 1
");

if($result && $result->num_rows > 0){
    $row = $result->fetch_assoc();
    $lastNumber = (int) substr($row['invoice_no'], -4);
    $newNumber  = $lastNumber + 1;
} else {
    $newNumber = 1;
}

$formattedNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
$invoice_no = "INV-$year-$formattedNumber";

// ==========================
// INSERT INVOICE
// ==========================
$stmt = $db->con->prepare("
INSERT INTO invoices
(invoice_no, tenant_id, property, unit, monthly_rent, months, total_amount, due_date, period_to, description, status)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if(!$stmt){
    echo json_encode(["status" => "error", "message" => $db->con->error]);
    exit;
}

$stmt->bind_param(
    "sissdidssss",
    $invoice_no,
    $tenant_id,
    $property,
    $unit,
    $monthly_rent,
    $months,
    $total_amount,
    $due_date,
    $period_to,
    $description,
    $status
);

// ==========================
// EXECUTE
// ==========================
if($stmt->execute()){
    echo json_encode([
        "status" => "success",
        "invoice_no" => $invoice_no
    ]);
} else {

    // Handle duplicate key error (if DB constraint exists)
    if($db->con->errno == 1062){
        echo json_encode([
            "status" => "error",
            "message" => "Duplicate invoice detected for this period"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => $stmt->error
        ]);
    }
}

$stmt->close();
$db->con->close();
?>
