<?php
session_start();
require 'src/config/database.php';
require 'src/config/class.php';
$db = new dbase;
$data = new modules;

// Fetch all property units with property name
$units = $db->con->query("
SELECT pu.*, p.name AS property_name
FROM property_units pu
LEFT JOIN properties p ON pu.property_id = p.id
ORDER BY pu.id DESC
");
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Property Units | VPAY RealEstate</title>


<?php require 'src/inc/headerlinks.php'; ?>


</head>

<body class="app-body h-full bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

<?php require 'src/inc/sidebar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden">

<?php require 'src/inc/header.php'; ?>

<main class="flex-1 overflow-y-auto p-8">

<div class="max-w-7xl mx-auto">

<!-- PAGE TITLE -->
<div class="flex justify-between items-center mb-6">
<h2 class="text-2xl font-bold text-gray-700">Property Units</h2>
<a href="property_units.php" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
Add Units
</a>
</div>

<!-- SUCCESS MESSAGE -->
<?php if(isset($_GET['success'])): ?>
<div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M5 13l4 4L19 7"/>
</svg>
Units generated successfully.
</div>
<?php endif; ?>

<!-- UNITS TABLE -->
<div class="bg-white shadow rounded-2xl overflow-hidden">
<table class="min-w-full text-sm text-left">
<thead class="bg-gray-100 text-gray-600 uppercase text-xs">
<tr>
<th class="px-6 py-3">Property</th>
<th class="px-6 py-3">Unit Number</th>
<th class="px-6 py-3">Unit Type</th>
<th class="px-6 py-3">Rent (KES)</th>
<th class="px-6 py-3">Status</th>
<th class="px-6 py-3">Description</th>
<th class="px-6 py-3">Created At</th>
</tr>
</thead>

<tbody class="divide-y">
<?php while($row = $units->fetch_assoc()): ?>
<tr class="hover:bg-gray-50">
<td class="px-6 py-4 font-medium text-gray-700"><?php echo $row['property_name']; ?></td>
<td class="px-6 py-4"><?php echo $row['unit_number']; ?></td>
<td class="px-6 py-4"><?php echo $row['unit_type']; ?></td>
<td class="px-6 py-4">KES <?php echo number_format($row['rent']); ?></td>
<td class="px-6 py-4">
<?php
if($row['status'] == 'Available') echo '<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Available</span>';
elseif($row['status'] == 'Occupied') echo '<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">Occupied</span>';
else echo '<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">Maintenance</span>';
?>
</td>
<td class="px-6 py-4 text-gray-500"><?php echo $row['description']; ?></td>
<td class="px-6 py-4 text-gray-500"><?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

</div>
</main>

</div>
</div>

<script>
// auto hide success message
setTimeout(() => {
let alert = document.querySelector('.bg-green-50');
if(alert) alert.style.display = 'none';
}, 4000);
</script>

</body>
</html>
