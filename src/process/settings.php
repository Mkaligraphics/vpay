<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/database.php';
require '../config/security.php';
header('Content-Type: application/json');
$db = new dbase;
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
try {
    $db->con->begin_transaction();
    if (!empty($_POST['new_password'])) {
        $password = $_POST['new_password'];
        if ($password !== ($_POST['confirm_password'] ?? '') || strlen($password) < 8) throw new DomainException('Passwords must match and contain at least 8 characters.');
        $id = (int)$_SESSION['id'];
        $stmt = $db->con->prepare('SELECT password FROM users WHERE id = ? FOR UPDATE');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $current = $_POST['current_password'] ?? '';
        $legacy = (new security)->aes('encrypt', $current);
        if (!$user || !(password_verify($current, $user['password']) || hash_equals($user['password'], $legacy))) throw new DomainException('Current password is incorrect.');
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->con->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->bind_param('si', $hash, $id);
        $stmt->execute();
    }
    $keys = ['company_name','phone','email','address','currency','invoice_prefix','due_days','late_fee','paybill','account_format'];
    if (!in_array($_POST['currency'] ?? '', ['KES','USD'], true)) throw new DomainException('Select a supported currency.');
    if (!filter_var($_POST['due_days'] ?? '', FILTER_VALIDATE_INT, ['options'=>['min_range'=>0,'max_range'=>365]] ) && ($_POST['due_days'] ?? '') !== '0') throw new DomainException('Due days must be between 0 and 365.');
    if (!is_numeric($_POST['late_fee'] ?? '') || $_POST['late_fee'] < 0 || $_POST['late_fee'] > 100) throw new DomainException('Late fee must be between 0 and 100.');
    $stmt = $db->con->prepare('INSERT INTO settings (meta_key, meta_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE meta_value = VALUES(meta_value)');
    foreach ($keys as $key) {
        $value = trim($_POST[$key] ?? '');
        $stmt->bind_param('ss', $key, $value);
        $stmt->execute();
    }
    $db->con->commit();
    echo json_encode(['status'=>'success', 'message'=>'Settings saved.']);
} catch (Throwable $e) {
    $db->con->rollback();
    if (!($e instanceof DomainException)) error_log($e);
    http_response_code($e instanceof DomainException ? 422 : 500);
    echo json_encode(['status'=>'error','message'=>$e instanceof DomainException ? $e->getMessage() : 'Unable to save settings. Confirm the settings migration has been applied.']);
}
