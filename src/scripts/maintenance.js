
// Auto set today
$(document).ready(function(){
let today = new Date().toISOString().split('T')[0];
$("#request_date").val(today);
});

// Load tenant details
$("#tenant").change(function(){

let tenant_id = $(this).val();

$.ajax({
url: "src/harvest/get_tenant_details.php",
type: "POST",
data: {tenant_id: tenant_id},
dataType: "json",
success: function(res){

$("#property").html(
`<option value="${res.property_id}">${res.property_name}</option>`
);

loadUnits(res.property_id, res.unit_id);

}
});

});

// Load units
function loadUnits(property_id, selected_unit = null){

$.ajax({
url: "src/harvest/get_units.php",
type: "POST",
data: {property_id: property_id},
success: function(html){

$("#unit").html(html);

if(selected_unit){
$("#unit").val(selected_unit);
}

}
});

}

// Submit form
$("#maintenanceForm").submit(function(e){
e.preventDefault();

$.ajax({
url: "src/process/save_maintenance.php",
type: "POST",
data: $(this).serialize(),
success: function(){

$("#successMsg").removeClass("hidden");

setTimeout(()=>{
$("#successMsg").addClass("hidden");
location.reload();
},2000);

}
});

});

