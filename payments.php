<?php
    session_start();
    require 'src/config/database.php';
    require 'src/config/class.php';
    $db = new dbase;
    $data = new modules;
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Make Payment</title>
<?php require 'src/inc/headerlinks.php'; ?>


</head>

<body class="app-body bg-gray-100 h-full">

<div class="flex h-screen overflow-hidden">

<!-- SIDEBAR -->
<?php require 'src/inc/sidebar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden">

<!-- HEADER -->
<?php require 'src/inc/header.php'; ?>

<main class="flex-1 overflow-y-auto p-8 bg-white m-4">


<h2 class="text-2xl font-bold mb-6 text-gray-700">Make Payment</h2>

                <?php require 'src/forms/payments.php'; ?>
</main>
</div>
</div>

<!-- SUCCESS MESSAGE -->
<div id="successMsg"
    class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg hidden">
    Payment Successful!
</div>


<!-- BOTTOM LINK -->
<?php require 'src/inc/bottomlinks.php'; ?>
<!-- DATATABLE LINKS -->
<?php require 'src/inc/datatablelinks.php'; ?>
<!-- DASHBOARD JS -->
<script src="src/scripts/payments.js"></script>

</body>
</html>
