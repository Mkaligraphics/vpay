<?php
require_once __DIR__ . '/bootstrap.php';
date_default_timezone_set('Africa/Nairobi');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
class dbase {
    public $con;
    public function __construct() {
        $this->con = new mysqli(getenv('DB_HOST') ?: 'localhost', getenv('DB_USER') ?: 'admin', getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : 'admin254', getenv('DB_NAME') ?: 'vpay', (int)(getenv('DB_PORT') ?: 3306));
        $this->con->set_charset('utf8mb4');
    }
}
