<?php
session_start();
require 'src/config/database.php';
require 'src/config/class.php';
$db = new dbase;
$data = new modules;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Occupancy Report | VPAY</title>

<?php require 'src/inc/headerlinks.php'; ?>





</head>

<body class="app-body bg-gray-100">

<div class="flex h-screen overflow-hidden">

<?php require 'src/inc/sidebar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden">

<?php require 'src/inc/header.php'; ?>

<main class="flex-1 overflow-y-auto p-8">


<!-- TITLE -->
<div class="mb-6">
<h2 class="text-2xl font-bold text-gray-700">Occupancy Report</h2>
<p class="text-gray-500 text-sm">Track vacant and occupied units</p>
</div>

<?php
$total = $db->con->query("SELECT COUNT(*) as total FROM property_units WHERE active=1")->fetch_assoc()['total'];

$vacant = $db->con->query("SELECT COUNT(*) as total FROM property_units WHERE active=1 AND status='vacant'")->fetch_assoc()['total'];

$occupied = $db->con->query("SELECT COUNT(*) as total FROM property_units WHERE active=1 AND status='occupied'")->fetch_assoc()['total'];
?>

<!-- STATS -->
<div class="grid md:grid-cols-3 gap-4 mb-6">

<div class="bg-white p-5 rounded-xl shadow">
<p class="text-gray-500 text-sm">Total Units</p>
<p class="text-2xl font-bold"><?= $total ?></p>
</div>

<div class="bg-green-50 p-5 rounded-xl shadow">
<p class="text-gray-500 text-sm">Vacant Units</p>
<p class="text-2xl font-bold text-green-600"><?= $vacant ?></p>
</div>

<div class="bg-red-50 p-5 rounded-xl shadow">
<p class="text-gray-500 text-sm">Occupied Units</p>
<p class="text-2xl font-bold text-red-600"><?= $occupied ?></p>
</div>

</div>

<!-- TABLE -->
<div class="bg-white shadow rounded-2xl p-6">

<table class="w-full text-sm text-left">

<thead class="bg-gray-100 text-gray-600">
<tr>
<th class="p-3">#</th>
<th class="p-3">Property</th>
<th class="p-3">Unit</th>
<th class="p-3">Type</th>
<th class="p-3">Rent</th>
<th class="p-3">Status</th>
</tr>
</thead>

<tbody>

<?php
$sql = $db->con->query("
SELECT
    u.id,
    u.property_id,
    p.name AS property_name,
    u.unit_number,
    u.unit_type,
    u.rent,
    u.status
FROM property_units u
LEFT JOIN properties p ON u.property_id = p.id
WHERE u.active = 1
ORDER BY u.id DESC
");

$i = 1;

while($row = $sql->fetch_assoc()):
?>

<tr class="border-b hover:bg-gray-50">

<td class="p-3"><?= $i++ ?></td>

<td class="p-3"><?= h($row['property_name']) ?></td>

<td class="p-3 font-semibold">
Unit <?= h($row['unit_number']) ?>
</td>

<td class="p-3"><?= h($row['unit_type']) ?></td>

<td class="p-3 text-green-600 font-semibold">
KES <?= number_format($row['rent'], 2) ?>
</td>

<td class="p-3">
<?php if ($row['status'] == 'vacant') { ?>
    <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Vacant</span>
<?php } else { ?>
    <span class="px-2 py-1 bg-red-100 text-red-700 rounded">Occupied</span>
<?php } ?>
</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>



</main>

</div>
</div>

</body>
</html>
