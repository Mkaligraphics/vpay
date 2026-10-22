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
<title>Property Types | VPAY RealEstate</title>

<?php require 'src/inc/headerlinks.php'; ?>




</head>

<body class="app-body h-full bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

<?php require 'src/inc/sidebar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden">

<?php require 'src/inc/header.php'; ?>

<main class="flex-1 overflow-y-auto p-8">

<div class="max-w-6xl mx-auto">

<!-- PAGE TITLE -->
<div class="mb-6">
<h2 class="text-2xl font-bold text-gray-700">Property Types</h2>
<p class="text-gray-500 text-sm">Manage property categories in the system</p>
</div>

<div class="grid md:grid-cols-3 gap-6">

<!-- ADD TYPE FORM -->
<div class="bg-white shadow rounded-2xl p-6">

<h3 class="font-semibold text-gray-700 mb-4">Add Property Type</h3>

<form id="addTypeForm" class="space-y-4">
<input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">

<div>
<label class="text-sm text-gray-600">Type Name</label>
<input type="text" name="type_name" required
class="w-full border border-gray-300 rounded-lg px-4 py-2">
</div>

<div>
<label class="text-sm text-gray-600">Description</label>
<textarea name="description"
class="w-full border border-gray-300 rounded-lg px-4 py-2"></textarea>
</div>

<button type="submit"
class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
Save Type
</button>

</form>

</div>

<!-- TABLE -->
<div class="md:col-span-2 bg-white shadow rounded-2xl p-6">

<h3 class="font-semibold text-gray-700 mb-4">Available Property Types</h3>

<div class="overflow-x-auto">
<table class="w-full text-sm text-left" id="typesTable">

<thead class="bg-gray-100 text-gray-600">
<tr>
<th class="p-3">ID</th>
<th class="p-3">Type</th>
<th class="p-3">Description</th>
<th class="p-3">Action</th>
</tr>
</thead>

<tbody id="typesBody">
<!-- AJAX-loaded content will appear here -->
</tbody>

</table>
</div>

</div>

</div>

</div>

</main>

</div>
</div>

<script>
$(document).ready(function(){

    // Load property types dynamically
    function loadTypes(){
        $.get('src/harvest/fetch_property_types.php', function(data){
            $('#typesBody').html(data);
        });
    }

    loadTypes(); // initial load

    // Add new type
    $('#addTypeForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'src/process/save_property_type.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response){
                $('#addTypeForm')[0].reset();
                loadTypes();
            }
        });
    });

    // Delete type
    $(document).on('click', '.deleteType', function(e){
        e.preventDefault();
        if(confirm('Delete this type?')){
            var id = $(this).data('id');
            $.post('src/process/delete_property_type.php', {id: id}, function(){
                loadTypes();
            });
        }
    });

    // Edit type (simple prompt)
    $(document).on('click', '.editType', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var typeName = $(this).data('name');
        var description = $(this).data('desc');

        var newName = prompt("Edit Type Name:", typeName);
        if(newName === null) return; // cancel

        var newDesc = prompt("Edit Description:", description);
        if(newDesc === null) return;

        $.post('src/process/edit_property_type.php', {id:id, type_name:newName, description:newDesc}, function(){
            loadTypes();
        });
    });

});
</script>

</body>
</html>
