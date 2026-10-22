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

<title>Create Invoice</title>

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

            <h2 class="text-2xl font-bold mb-6 text-gray-700">
                Create Invoice
            </h2>

            <!-- INVOICE FORM -->
            <?php require 'src/forms/invoice.php'; ?>

        </main>

    </div>

</div>

<!-- SUCCESS MESSAGE -->
<div id="successMsg"
    class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg hidden">
    Invoice Created Successfully!
</div>

<!-- LINKS -->
<?php require 'src/inc/bottomlinks.php'; ?>
<?php require 'src/inc/datatablelinks.php'; ?>

<!-- INVOICE JS -->
<script src="src/scripts/invoice.js"></script>

</body>
</html>
