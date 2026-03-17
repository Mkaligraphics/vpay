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
<title>VPAY RealEstate</title>
<script src="https://cdn.tailwindcss.com"></script>
<?php require 'src/inc/headerlinks.php'; ?>
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

    <!-- TOP NAV -->
 <?php require 'src/inc/header.php'; ?>


    <!-- CONTENT -->
    <main class="flex-1 overflow-y-auto p-8 space-y-8">

      <!-- KPI SECTION -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
          <p class="text-gray-500 text-sm">Total Properties</p>
          <h3 class="text-3xl font-bold text-blue-700 mt-2"><?php echo $data->totals('properties '); ?></h3>
          <p class="text-green-600 text-sm mt-2">+8% this month</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
          <p class="text-gray-500 text-sm">Occupied Units</p>
          <h3 class="text-3xl font-bold text-green-600 mt-2">132</h3>
          <p class="text-green-600 text-sm mt-2">+4% growth</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
          <p class="text-gray-500 text-sm">Pending Payments</p>
          <h3 class="text-3xl font-bold text-yellow-500 mt-2">18</h3>
          <p class="text-red-500 text-sm mt-2">-2% from last week</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
          <p class="text-gray-500 text-sm">Monthly Revenue</p>
          <h3 class="text-3xl font-bold text-purple-600 mt-2">KES 2,840,000</h3>
          <p class="text-green-600 text-sm mt-2">+12% increase</p>
        </div>

      </div>

      <!-- PROPERTY TABLE -->
      <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="p-6 border-b">
          <h3 class="font-semibold text-gray-700">Recent Properties</h3>
        </div>

        <div class="overflow-x-auto">
          
        <table id="propertiesTable" class="display w-full">
<thead>
<tr>
<th>Name</th>
<th>County</th>
<th>Town</th>
<th>Type</th>
<th>Units</th>
<th>Min Rent</th>
<th>Max Rent</th>
<th>Status</th>
<th>Description</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

<?php

$result = $db->con->query("SELECT * FROM properties WHERE active = '1'");

while($row = $result->fetch_assoc()){
?>

<tr>
<td><?= $row['name'] ?></td>
<td><?= $row['county'] ?></td>
<td><?= $row['town'] ?></td>
<td><?= $row['type'] ?></td>
<td><?= $row['units'] ?></td>
<td><?= $row['min_rent'] ?></td>
<td><?= $row['max_rent'] ?></td>
<td><?= $row['status'] ?></td>
<td><?= $row['description'] ?></td>

<td>


<button 
class="editBtn bg-blue-500 text-white px-2 py-1 rounded"
data-id="<?= $row['id'] ?>"
data-name="<?= $row['name'] ?>"
data-county="<?= $row['county'] ?>"
data-town="<?= $row['town'] ?>"
data-type="<?= $row['type'] ?>"
data-units="<?= $row['units'] ?>"
data-minrent="<?= $row['min_rent'] ?>"
data-maxrent="<?= $row['max_rent'] ?>"
data-status="<?= $row['status'] ?>"
data-description="<?= $row['description'] ?>"
>
Edit
</button>

<button 
class="deleteBtn bg-red-500 text-white px-2 py-1 rounded"
data-id="<?= $row['id'] ?>"
>
Delete
</button>

</td>


</tr>

<?php } ?>

</tbody>
</table>
        

<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">

<div class="bg-white p-6 rounded w-96">

<h2 class="text-xl font-bold mb-4">Edit Property</h2>

<form id="editForm">

<input type="hidden" id="edit_id" name="id">

<input type="text" id="edit_name" name="name" placeholder="Property Name" class="border w-full p-2 mb-2">

<input type="text" id="edit_county" name="county" placeholder="County" class="border w-full p-2 mb-2">

<input type="text" id="edit_town" name="town" placeholder="Town" class="border w-full p-2 mb-2">

<input type="number" id="edit_units" name="units" placeholder="Units" class="border w-full p-2 mb-2">

<input type="number" id="edit_minrent" name="min_rent" placeholder="Min Rent" class="border w-full p-2 mb-2">

<input type="number" id="edit_maxrent" name="max_rent" placeholder="Max Rent" class="border w-full p-2 mb-2">

<textarea id="edit_description" name="description" class="border w-full p-2 mb-2"></textarea>

<div class="flex justify-end gap-2">

<button type="button" id="closeModal" class="bg-gray-500 text-white px-3 py-1 rounded">
Cancel
</button>

<button type="submit" class="bg-green-600 text-white px-3 py-1 rounded">
Save
</button>

</div>

</form>

</div>
</div>
        </div>

      </div>

    </main>

  </div>

</div>
<script>
$(document).ready(function(){

$('#propertiesTable').DataTable({

dom: 'Bfrtip',

buttons: [
'copy',
'csv',
'excel',
'pdf',
'print'
],

pageLength: 10

});

});
</script>
<script>

$("#propertyMenuBtn").click(function(){

$("#propertySubmenu").slideToggle(200);

$("#propertyArrow").toggleClass("rotate-180");

});

</script>
<script>
function toggleProfile(){
  document.getElementById('profileMenu').classList.toggle('hidden');
}

$(document).on("click",".editBtn",function(){

$("#editModal").removeClass("hidden");

$("#edit_id").val($(this).data("id"));
$("#edit_name").val($(this).data("name"));
$("#edit_county").val($(this).data("county"));
$("#edit_town").val($(this).data("town"));
$("#edit_units").val($(this).data("units"));
$("#edit_minrent").val($(this).data("minrent"));
$("#edit_maxrent").val($(this).data("maxrent"));
$("#edit_description").val($(this).data("description"));

});
//modal
$("#closeModal").click(function(){
$("#editModal").addClass("hidden");
});

//edit
$("#editForm").submit(function(e){

e.preventDefault();

$.ajax({

url:"src/process/update_property.php",
type:"POST",
data:$(this).serialize(),

success:function(response){

alert("Property Updated Successfully");

location.reload();

}

});

});

//delete
$(document).on("click",".deleteBtn",function(){

var id=$(this).data("id");

if(confirm("Delete this property?")){

$.ajax({

url:"src/process/delete_property.php",
type:"POST",
data:{id:id},

success:function(){

alert("Property Deleted");

location.reload();

}

});

}

});
</script>

</body>
</html>