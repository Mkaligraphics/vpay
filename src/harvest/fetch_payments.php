<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';
$db = new dbase;
$from = $_POST['from'] ?? '';
$to = $_POST['to'] ?? '';
if (($from && !valid_date($from)) || ($to && !valid_date($to)) || ($from && $to && $from > $to)) { http_response_code(422); exit('Select a valid date range.'); }
$start = $from ?: '1000-01-01';
$end = $to ?: '9999-12-31';
$stmt = $db->con->prepare('SELECT p.*, t.name AS tenant_name, pr.name AS property_name FROM payments p LEFT JOIN tenants t ON p.tenant = t.id LEFT JOIN properties pr ON p.property_id = pr.id WHERE p.date BETWEEN ? AND ? ORDER BY p.id DESC');
$stmt->bind_param('ss', $start, $end); $stmt->execute();
$rows = $stmt->get_result();
$i = 0;
foreach ($rows as $row) {
    echo '<tr><td>'.(++$i).'</td><td>'.h($row['tenant_name']).'</td><td>'.h($row['property_name']).'</td><td>KES '.number_format($row['amount'], 2).'</td><td>'.h($row['method']).'</td><td>'.h($row['payment_for']).'</td><td>'.h($row['date']).'</td></tr>';
}
if (!$i) echo '<tr><td colspan="7" class="p-5 text-center text-gray-500">No payments found</td></tr>';
