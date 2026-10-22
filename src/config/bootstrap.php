<?php
if (PHP_SAPI !== 'cli') {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    $script = realpath($_SERVER['SCRIPT_FILENAME'] ?? '');
    $login = realpath(__DIR__ . '/../../index.php');
    if ($script !== $login && empty($_SESSION['id'])) {
        if (strpos($script ?: '', DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR) !== false) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Please sign in again.']);
        } else {
            header('Location: index.php');
        }
        exit;
    }
    if (strpos($script ?: '', DIRECTORY_SEPARATOR . 'process' . DIRECTORY_SEPARATOR) !== false && $_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('POST required.'); }
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !hash_equals($_SESSION['csrf_token'], $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit('Your session has expired. Reload the page and try again.');
    }
}
function h($value) { return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8'); }
function valid_date($value) {
    $date = DateTimeImmutable::createFromFormat('!Y-m-d', (string)$value);
    return $date && $date->format('Y-m-d') === $value;
}
