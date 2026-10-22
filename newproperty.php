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
<title>Add New Property | VPAY RealEstate</title>

<?php require 'src/inc/headerlinks.php'; ?>



</head>

<body class="app-body h-full bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

<?php require 'src/inc/sidebar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden">

<?php require 'src/inc/header.php'; ?>

<main class="flex-1 overflow-y-auto p-8">

<div class="max-w-5xl mx-auto">

<!-- PAGE TITLE -->
<div class="mb-8">
<h2 class="text-2xl font-bold text-gray-700">Add New Property</h2>
<p class="text-gray-500 text-sm">Register a new property in the system</p>
</div>

<!-- FORM -->
<div class="bg-white shadow rounded-2xl p-8">

<form action="src/process/save_property.php" method="POST" class="space-y-8">
<input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">

<!-- PROPERTY DETAILS -->
<div>
<h3 class="text-lg font-semibold text-gray-700 mb-4">Property Details</h3>

<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Property Name
</label>
<input type="text" name="property_name" required
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Total Units
</label>
<input type="number" name="units"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
</div>

</div>
</div>

<!-- LOCATION -->
<div>
<h3 class="text-lg font-semibold text-gray-700 mb-4">Location</h3>

<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
County
</label>
<input type="text" name="county"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Town / Area
</label>
<input type="text" name="town"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
</div>

</div>
</div>

<!-- RENT INFORMATION -->
<div>
<h3 class="text-lg font-semibold text-gray-700 mb-4">Rental Information</h3>

<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Minimum Rent (KES)
</label>
<input type="number" name="min_rent"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Maximum Rent (KES)
</label>
<input type="number" name="max_rent"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
</div>

</div>
</div>

<!-- STATUS -->
<div>
<h3 class="text-lg font-semibold text-gray-700 mb-4">Property Status</h3>

<select name="status"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">

<option value="Active">Active</option>
<option value="Inactive">Inactive</option>
<option value="Under Construction">Under Construction</option>

</select>
</div>

<!-- DESCRIPTION -->
<div>
<h3 class="text-lg font-semibold text-gray-700 mb-4">Additional Information</h3>

<textarea name="description" rows="4"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
placeholder="Write any notes about the property..."></textarea>
</div>

<!-- ACTION BUTTONS -->
<div class="flex justify-end gap-4 pt-6 border-t">

<a href="properties.php"
class="px-6 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
Cancel
</a>

<button type="submit"
class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow">
Save Property
</button>

</div>

</form>

</div>

</div>

</main>

</div>
</div>



</body>
</html>
