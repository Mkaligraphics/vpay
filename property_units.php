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
<title>Add Property Units | VPAY RealEstate</title>

<?php require 'src/inc/headerlinks.php'; ?>




</head>

<body class="app-body h-full bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

<?php require 'src/inc/sidebar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden">

<?php require 'src/inc/header.php'; ?>

<main class="flex-1 overflow-y-auto p-8">

<div class="max-w-4xl mx-auto">

<div class="mb-6">
<h2 class="text-2xl font-bold text-gray-700">Create Property Units</h2>
<p class="text-gray-500 text-sm">Units will load automatically from property settings</p>
</div>

<div class="bg-white shadow rounded-2xl p-8">

<form action="src/process/save_units.php" method="POST" class="space-y-6">
<input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">

<!-- PROPERTY -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Select Property
</label>

<select id="propertySelect" name="property_id" required
class="w-full border border-gray-300 rounded-lg px-4 py-2 cursor-pointer">

<option value="">Choose Property</option>

<?php
$properties = $db->con->query("SELECT * FROM properties WHERE status='Active'");
foreach($properties as $row){
echo "<option
value='".$row['id']."'
data-units='".$row['units']."'
data-name='".$row['name']."'>
".$row['name']."
</option>";
}
?>

</select>
</div>

<!-- AUTO PROPERTY INFO -->
<div class="bg-gray-50 border rounded-lg p-4 hidden" id="propertyInfo">

<p class="text-sm text-gray-600">
Property Units:
<strong id="propertyUnits"></strong>
</p>

<p class="text-sm text-gray-600">
Units Already Created:
<strong id="createdUnits">0</strong>
</p>

<p class="text-sm text-gray-600">
Units Remaining:
<strong id="remainingUnits"></strong>
</p>

</div>

<!-- UNIT SETTINGS -->
<div class="grid md:grid-cols-3 gap-6">

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Units To Generate
</label>
<input type="number" id="totalUnits" name="total_units" required
class="w-full border border-gray-300 rounded-lg px-4 py-2">
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Unit Prefix
</label>
<input type="text" id="prefix" name="prefix" value="A"
class="w-full border border-gray-300 rounded-lg px-4 py-2">
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Starting Number
</label>
<input type="number" id="startNumber" name="start_number" value="1"
class="w-full border border-gray-300 rounded-lg px-4 py-2">
</div>

</div>

<!-- AUTO LABEL PREVIEW -->
<div class="bg-gray-100 rounded-lg p-4">
<p class="text-sm font-medium text-gray-700 mb-2">Unit Preview</p>
<div id="unitPreview" class="text-sm text-gray-600"></div>
</div>

<!-- UNIT TYPE + RENT -->
<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Unit Type
</label>

<select name="unit_type"
class="w-full border border-gray-300 rounded-lg px-4 py-2">

<?php
$types = $db->con->query("SELECT * FROM property_types WHERE status='Active'");
foreach($types as $row){
echo "<option value='".$row['type_name']."'>".$row['type_name']."</option>";
}
?>

</select>
</div>

<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Rent Amount (KES)
</label>
<input type="number" name="rent" required
class="w-full border border-gray-300 rounded-lg px-4 py-2">
</div>

</div>

<!-- STATUS -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Unit Status
</label>

<select name="status"
class="w-full border border-gray-300 rounded-lg px-4 py-2">
<option value="Available">Available</option>
<option value="Occupied">Occupied</option>
<option value="Maintenance">Maintenance</option>
</select>
</div>

<!-- DESCRIPTION -->
<div>
<label class="block text-sm font-medium text-gray-600 mb-1">
Description
</label>

<textarea name="description" rows="4"
class="w-full border border-gray-300 rounded-lg px-4 py-2"></textarea>
</div>

<div class="flex justify-end gap-4 pt-4">
<a href="units.php"
class="px-6 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
Cancel
</a>

<button type="submit"
class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
Generate Units
</button>
</div>

</form>

</div>
</div>

</main>
</div>
</div>

<script>

let createdUnitsFromDB = 0;

$("#propertySelect").change(function(){

let selected = $(this).find(":selected");

let totalUnits = selected.data("units");

$("#propertyInfo").removeClass("hidden");
$("#propertyUnits").text(totalUnits);

// get already created units
let propertyId = $(this).val();

$.get("src/harvest/get_units_count.php?id=" + propertyId, function(data){

createdUnitsFromDB = parseInt(data);
$("#createdUnits").text(createdUnitsFromDB);

let remaining = totalUnits - createdUnitsFromDB;
$("#remainingUnits").text(remaining);

$("#totalUnits").val(remaining);

});

});

$("#totalUnits, #prefix, #startNumber").on("input", function(){

let total = parseInt($("#totalUnits").val());
let prefix = $("#prefix").val();
let start = parseInt($("#startNumber").val());

let preview = "";

for(let i=0;i<Math.min(total,20);i++){
preview += prefix + (start + i) + ", ";
}

$("#unitPreview").text(preview);

});

</script>

</body>
</html>
