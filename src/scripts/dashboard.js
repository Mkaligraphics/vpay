
$(document).ready(function(){

$('#propertiesTable').DataTable({
dom: 'Bfrtip',
buttons: ['copy','csv','excel','pdf','print'],
pageLength: 10
});

});




function toggleProfile(){
document.getElementById('profileMenu').classList.toggle('hidden');
}

// Open modal
$(document).on("click",".editBtn",function(){

$("#editModal").removeClass("hidden");

$("#edit_id").val($(this).data("id"));
$("#edit_name").val($(this).data("name"));
$("#edit_county").val($(this).data("county"));
$("#edit_town").val($(this).data("town"));
$("#edit_units").val($(this).data("units"));
$("#edit_minrent").val($(this).data("minrent"));
$("#edit_maxrent").val($(this).data("maxrent"));
$("#edit_status").val($(this).data("status"));
$("#edit_description").val($(this).data("description"));

});

// Close modal
$("#closeModal").click(function(){
$("#editModal").addClass("hidden");
});

// Update property
$("#editForm").submit(function(e){
e.preventDefault();

$.ajax({
url:"src/process/update_property.php",
type:"POST",
data:$(this).serialize(),
success:function(){
alert("Property Updated Successfully");
location.reload();
}
});
});

// Delete property
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
