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
        $password = trim($_POST['password']);

        // Encrypt password using your AES method
        $encryptedPassword = $security->aes('encrypt', $password);

        // Prepare statement
        $stmt = $data->con->prepare("
            SELECT id FROM users  WHERE email = ? AND password = ? LIMIT 1
        ");

        if ($stmt) {

            $stmt->bind_param("ss", $email, $encryptedPassword);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {

                $user = $result->fetch_assoc();

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
<title>VPay Real Estate | Login</title>

<!-- TailwindCSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="src/img/icon.png" type="image/x-icon"/>
<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#1e3a8a'
            }
        }
    }
}
</script>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-blue-100">

<!-- Decorative Background -->
<div class="absolute inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-300 rounded-full blur-3xl opacity-20"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-300 rounded-full blur-3xl opacity-20"></div>
</div>

<div class="w-full max-w-md px-6">

  <!-- Branding -->
<div class="text-center mb-10">
    
    <div class="flex justify-center mb-4">
        <img src="src/img/logo.png" alt="VPay Real Estate Logo" class="w-20 h-20 object-contain">
    </div>

    <h1 class="text-3xl font-bold text-gray-800">VPay Real Estate</h1>
    <p class="text-gray-500 text-sm mt-2">Property Management System</p>

</div>

    <!-- Login Card -->
    <div class="bg-white shadow-2xl rounded-2xl p-8 border border-gray-100">

        <?php if (!empty($error)): ?>
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6 text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input type="email" name="email" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-blue-100 outline-none transition"
                    placeholder="admin@vpay.com">
            </div>

            <!-- Password -->
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-4 focus:ring-blue-100 outline-none transition"
                    placeholder="••••••••">
                <span id="togglePassword"
                    class="absolute right-4 top-11 cursor-pointer text-gray-400">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>

            <!-- Submit Button -->
      <button type="submit"
    class="w-full bg-red-600 hover:bg-red-700 active:scale-95 text-white font-semibold py-3 rounded-xl transition">
    Sign In
</button>

        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            Forgot your password?
            <a href="#" class="text-primary font-medium hover:underline">
                Reset here
            </a>
        </div>

    </div>

    <p class="text-center text-xs text-gray-400 mt-8">
        © <?= date('Y') ?> VPay Real Estate. All rights reserved.
    </p>

</div>

<!-- jQuery Script -->
<script>
$(document).ready(function(){

    $('#togglePassword').click(function(){
        let input = $('#password');
        let icon = $(this).find('i');

        if(input.attr('type') === 'password'){
            input.attr('type','text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type','password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

});
</script>

</body>
</html>