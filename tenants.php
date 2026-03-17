<?php
session_start();
require 'src/config/database.php';
require 'src/config/class.php';
$db = new dbase;
$data = new modules;

$tenants = $db->con->query("SELECT * FROM tenants ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en" class="h-full">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tenants | VPAY</title>

<?php require 'src/inc/headerlinks.php'; ?>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

</head>

<body class="h-full bg-gray-100">

<div class="flex h-screen overflow-hidden">

<?php require 'src/inc/sidebar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden">

<?php require 'src/inc/header.php'; ?>

<main class="flex-1 overflow-y-auto p-8">

<div class="max-w-7xl mx-auto">

<div class="flex justify-between mb-6">

<div>
<h2 class="text-2xl font-bold text-gray-700">Tenants</h2>
<p class="text-gray-500 text-sm">Manage property tenants</p>
</div>

<button onclick="openAddTenant()"
class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
+ Add Tenant
</button>

</div>

<div class="bg-white shadow rounded-xl p-6">

<table id="tenantTable" class="display w-full">

<thead>

<tr>
<th>ID</th>
<th>Unit</th>
<th>Name</th>
<th>Phone</th>
<th>Email</th>
<th>Lease Start</th>
<th>Lease End</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($tenants)){ ?>

<tr id="row_<?php echo $row['id']; ?>">

<td><?php echo $row['id']; ?></td>
<td><?php echo $row['shop_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['phone']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['lease_start']; ?></td>
<td><?php echo $row['lease_end']; ?></td>

<td class="space-x-2">

<button onclick="editTenant(<?php echo $row['id']; ?>)"

class="bg-green-500 text-white px-3 py-1 rounded text-sm">
Edit
</button>

<button onclick="deleteTenant(<?php echo $row['id']; ?>)"

class="bg-red-500 text-white px-3 py-1 rounded text-sm">
Delete
</button>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</main>

</div>

</div>


<!-- ADD TENANT MODAL -->

<div id="addTenantModal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center">

<div class="bg-white rounded-xl p-6 w-96">

<h3 class="text-lg font-semibold mb-4">Add Tenant</h3>

<form id="addTenantForm">

<input type="text" name="shop_id" placeholder="Shop / Unit"
class="w-full border p-2 mb-3 rounded">

<input type="text" name="name" placeholder="Tenant Name"
class="w-full border p-2 mb-3 rounded">

<input type="text" name="phone" placeholder="Phone"
class="w-full border p-2 mb-3 rounded">

<input type="email" name="email" placeholder="Email"
class="w-full border p-2 mb-3 rounded">

<label class="text-sm">Lease Start</label>

<input type="date" name="lease_start"
class="w-full border p-2 mb-3 rounded">

<label class="text-sm">Lease End</label>

<input type="date" name="lease_end"
class="w-full border p-2 mb-3 rounded">

<div class="flex justify-end gap-3">

<button type="button" onclick="closeModal()"
class="px-4 py-2 bg-gray-300 rounded">
Cancel
</button>

<button type="submit"
class="px-4 py-2 bg-blue-600 text-white rounded">
Save
</button>

</div>

</form>

</div>

</div>



<script>

$(document).ready(function(){

$('#tenantTable').DataTable({

dom:'Bfrtip',

buttons:[
'copy','excel','csv','pdf','print'
]

});

});


function openAddTenant(){

$('#addTenantModal').removeClass('hidden');

}


function closeModal(){

$('#addTenantModal').addClass('hidden');

}



$('#addTenantForm').submit(function(e){

e.preventDefault();

$.ajax({

url:'src/process/save_tenant.php',

type:'POST',

data:$(this).serialize(),

success:function(){

location.reload();

}

});

});



function deleteTenant(id){

if(confirm("Delete tenant?")){

$.ajax({

url:'src/process/delete_tenant.php',

type:'POST',

data:{id:id},

success:function(){

$("#row_"+id).fadeOut();

}

});

}

}

</script>

</body>

</html>