<?php
session_start();

require 'src/config/database.php';
require 'src/config/security.php';

$data = new dbase();
$security = new security(); // Ensure class name matches your security.php

$error = "";

/*
|--------------------------------------------------------------------------
| HANDLE LOGIN REQUEST
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['email']) && !empty($_POST['password'])) {

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Encrypt password using your AES method
        $encryptedPassword = $security->aes('encrypt', $password);

        // Prepare statement
        $stmt = $data->con->prepare("
            SELECT id, password FROM users WHERE email = ? LIMIT 1
        ");

        if ($stmt) {

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            $user = $result->fetch_assoc();
            if ($user && (password_verify($password, $user['password']) || hash_equals($user['password'], $encryptedPassword))) {

                session_regenerate_id(true);

                // Store session
                $_SESSION['id'] = $user['id'];

                /*
                |--------------------------------------------------------------------------
                | LOG USER LOGIN
                |--------------------------------------------------------------------------
                */
                $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
                $browserInfo = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
                $deviceType = 'Desktop'; // You can improve detection later
                $os = php_uname();

                $stmtLog = $data->con->prepare("
                    INSERT INTO logs (localip, userid, brs, devicetype, ostype)
                    VALUES (?, ?, ?, ?, ?)
                ");

                if ($stmtLog) {
                    $stmtLog->bind_param("sisss", $ip, $user['id'], $browserInfo, $deviceType, $os);
                    $stmtLog->execute();
                    $stmtLog->close();
                }

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit;

            } else {
                $error = "Authentication failed. Please check your credentials.";
            }

            $stmt->close();

        } else {
            $error = "System error. Please try again later.";
        }

    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#142c30">
<title>Welcome back · VPay</title>
<link rel="icon" href="src/img/icon.png">
<link rel="stylesheet" href="src/vendor/fontawesome/css/all.min.css">
<link rel="stylesheet" href="src/output.css?v=<?= filemtime(__DIR__ . '/src/output.css') ?>">
</head>
<body class="login-body">
<div class="login-layout">
  <section class="login-story" aria-label="VPay property management">
    <a href="index.php" class="brand"><span class="brand-symbol">v<span>↗</span></span><span>vpay<span class="brand-dot">.</span><small>PROPERTY MANAGER</small></span></a>
    <div class="login-story-content"><span class="story-pill"><span></span>BUILT FOR BETTER PROPERTY MANAGEMENT</span><h1>Great spaces.<br>Even greater <em>possibilities.</em></h1><p>Bring your properties, people and payments together.<br>A little more clarity. A lot more room to grow.</p></div>
    <div class="architecture-wrap"><img src="src/img/architecture.svg" alt="Architectural illustration of a residential community in warm emerald and ivory" width="720" height="600"><div class="illustration-caption"><span class="caption-line"></span>GOOD PLACES. THOUGHTFULLY MANAGED.</div></div>
    <div class="login-story-footer"><span>One workspace. Every property.</span><span>Designed around you <span aria-hidden="true">↗</span></span></div>
  </section>
  <main class="login-main">
    <div class="login-mobile-brand"><span class="brand-symbol">v<span>↗</span></span><span>vpay.</span></div>
    <div class="login-topline"><span class="login-secure"><i class="fas fa-lock" aria-hidden="true"></i>Your private workspace</span><span class="login-edition">PROPERTY MANAGEMENT</span></div>
    <div class="login-form-wrap"><div class="login-welcome-icon"><i class="fas fa-arrow-right-to-bracket" aria-hidden="true"></i></div><p class="eyebrow">A GOOD DAY TO MOVE FORWARD</p><h2>Welcome back<span>.</span></h2><p class="login-description">Sign in to your workspace and make yourself at home.</p>
      <?php if (!empty($error)): ?><div class="login-error" role="alert"><i class="fas fa-circle-exclamation" aria-hidden="true"></i><?= h($error) ?></div><?php endif; ?>
      <form method="POST" class="login-form">
        <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
        <div><label for="email">Email address</label><div class="login-input-wrap"><i class="far fa-envelope" aria-hidden="true"></i><input type="email" id="email" name="email" value="<?= h($_POST['email'] ?? '') ?>" autocomplete="username" placeholder="you@company.com" required></div></div>
        <div><label for="password">Password</label><div class="login-input-wrap"><i class="fas fa-lock" aria-hidden="true"></i><input type="password" name="password" id="password" autocomplete="current-password" placeholder="Enter your password" required><button type="button" id="togglePassword" aria-label="Show password" aria-pressed="false"><i class="far fa-eye" aria-hidden="true"></i></button></div></div>
        <div class="login-session-note"><i class="fas fa-shield-halved" aria-hidden="true"></i>Secure access to your property workspace</div>
        <button type="submit" class="login-submit">Sign in to workspace <span aria-hidden="true">↗</span></button>
      </form>
      <div class="login-help"><span>Need a hand signing in?</span><p>Contact your workspace administrator for access or a password reset.</p></div>
      <div class="login-value-line"><span></span><i class="fas fa-leaf" aria-hidden="true"></i>Less admin. More possibility.<span></span></div>
    </div>
    <footer class="login-footer"><span>© <?= date('Y') ?> VPay. All rights reserved.</span><span>Made for the way you manage.</span></footer>
  </main>
</div>
<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const input = document.getElementById('password');
    const show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    this.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    this.setAttribute('aria-pressed', String(show));
    this.querySelector('i').className = show ? 'far fa-eye-slash' : 'far fa-eye';
});
</script>
</body>
</html>
