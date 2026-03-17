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

<script src="https://cdn.tailwindcss.com"></script>

<script>
tailwind.config = {
  darkMode: 'class'
}
</script>

</head>

<body class="h-full bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

<!-- SIDEBAR -->
<?php require 'src/inc/sidebar.php'; ?>

<!-- MAIN CONTENT -->
<div class="flex-1 flex flex-col overflow-hidden">

<!-- HEADER -->
<?php require 'src/inc/header.php'; ?>

<!-- CONTENT -->
<main class="flex-1 overflow-y-auto p-8">

<div class="max-w-4xl mx-auto">

<!-- PAGE TITLE -->
<div class="mb-6">
<h2 class="text-2xl font-bold text-gray-700">Add New Property</h2>
<p class="text-gray-500 text-sm">Create and register a new property in the system</p>
</div>

<!-- FORM CARD -->
<div class="bg-white shadow rounded-2xl p-8">

<form action="src/process/save_property.php" method="POST" class="space-y-6">

<!-- PROPERTY NAME -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Property Name
</label>
<input type="text" name="property_name" required
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
</div>

<!-- LOCATION -->
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

<!-- PROPERTY TYPE -->
<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Property Type
</label>

<select name="type"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">

<option>Apartment</option>
<option>Commercial</option>
<option>Hostel</option>
<option>Single House</option>
<option>Mixed Use</option>

</select>
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Total Units
</label>
<input type="number" name="units"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
</div>

</div>

<!-- RENT -->
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

<!-- STATUS -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Property Status
</label>

<select name="status"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">

<option value="Active">Active</option>
<option value="Inactive">Inactive</option>
<option value="Under Construction">Under Construction</option>

</select>
</div>

<!-- DESCRIPTION -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Description
</label>

<textarea name="description" rows="4"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"></textarea>
</div>

<!-- BUTTONS -->
<div class="flex justify-end gap-4 pt-4">

<a href="properties.php"
class="px-6 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
Cancel
</a>

<button type="submit"
class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
Save Property
</button>

</div>

</form>

</div>

</div>

</main>

</div>
</div>


<script>

$("#propertyMenuBtn").click(function(){

$("#propertySubmenu").slideToggle(200);

$("#propertyArrow").toggleClass("rotate-180");

});

function toggleProfile(){
document.getElementById('profileMenu').classList.toggle('hidden');
}

</script>

</body>
</html>