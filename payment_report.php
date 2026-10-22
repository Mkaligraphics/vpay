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
<title>Payments Report | VPAY</title>

<?php require 'src/inc/headerlinks.php'; ?>





</head>

<body class="app-body h-full bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

<?php require 'src/inc/sidebar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden">

<?php require 'src/inc/header.php'; ?>

<main class="flex-1 overflow-y-auto p-8">


<!-- TITLE -->
<div class="mb-6">
<h2 class="text-2xl font-bold text-gray-700">Payments Report</h2>
<p class="text-gray-500 text-sm">Filter and view all payments</p>
</div>

<!-- FILTER CARD -->
<div class="bg-white shadow rounded-2xl p-4 mb-6 flex flex-wrap gap-4 items-end">

<div>
<label class="text-sm text-gray-600">From</label>
<input type="date" id="from_date"
class="border rounded-lg px-3 py-2">
</div>

<div>
<label class="text-sm text-gray-600">To</label>
<input type="date" id="to_date"
class="border rounded-lg px-3 py-2">
</div>

<button id="filterBtn"
class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
Filter
</button>

<button id="resetBtn"
class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
Reset
</button>

</div>

<!-- TABLE -->
<div class="bg-white shadow rounded-2xl p-6">

<div class="overflow-x-auto">

<table class="w-full text-sm text-left">

<thead class="bg-gray-100 text-gray-600">
<tr>
<th class="p-3">#</th>
<th class="p-3">Tenant</th>
<th class="p-3">Property</th>
<th class="p-3">Amount</th>
<th class="p-3">Method</th>
<th class="p-3">Payment For</th>
<th class="p-3">Date</th>
</tr>
</thead>

<tbody id="paymentsBody">
<!-- AJAX -->
</tbody>

</table>

</div>


</div>

</main>

</div>
</div>
<!-- BOTTOM LINK -->
<?php require 'src/inc/bottomlinks.php'; ?>
<!-- DATATABLE LINKS -->
<?php require 'src/inc/datatablelinks.php'; ?>
<!-- DASHBOARD JS -->
<script src="src/scripts/payments_report.js"></script>

</body>
</html>
