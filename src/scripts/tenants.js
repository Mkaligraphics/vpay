
$(document).ready(function(){

$('#tenantTable').DataTable({
dom:'Bfrtip',
buttons:['copy','excel','csv','pdf','print']
});

});


function openAddTenant(){
$('#addTenantModal').removeClass('hidden');
}

function closeModal(){
$('#addTenantModal').addClass('hidden');
}




/* Save Tenant */
$('#addTenantForm').submit(function(e){

e.preventDefault();

$.ajax({
url:'src/process/save_tenant.php',
type:'POST',
data:$(this).serialize(),
success:function(res){
if(res.trim() === 'success') location.reload();
else $.notify(res, 'error');
},
error:function(xhr){ $.notify(xhr.responseText || 'Unable to save tenant.', 'error'); }
});

});


function deleteTenant(id){

if(confirm("Delete tenant?")){

$.ajax({
url:'src/process/delete_tenant.php',
type:'POST',
data:{id:id},
success:function(res){
if(res.trim() === 'success') location.reload();
else $.notify(res, 'error');
},
error:function(){ $.notify('Unable to remove tenant.', 'error'); }
});

}

}


// ===============================
// MODAL CONTROL
// ===============================
function openAssociateModal() {
    $("#associateModal").removeClass("hidden");
}

function closeAssociateModal() {
    $("#associateModal").addClass("hidden");

    // reset form
    $("#associateForm")[0].reset();
    $("#assoc_unit").html('<option value="">Select Unit</option>');
}


// ===============================
// LOAD UNITS BASED ON PROPERTY
// ===============================
$("#assoc_property").on("change", function () {

    let property_id = $(this).val();

    $("#assoc_unit").html('<option>Loading...</option>');

    $.ajax({
        url: "src/harvest/vacant_units.php",
        type: "POST",
        data: { property_id: property_id },

        success: function (res) {

            if (!res || res.trim() === "") {
                $("#assoc_unit").html('<option disabled>No results found</option>');
                return;
            }

            $("#assoc_unit").html(res);
        }
    });
});


// ===============================
// AUTO FILL RENT
// ===============================
$("#assoc_unit").on("change", function () {

    let rent = $("#assoc_unit option:selected").data("rent");

    $("#assoc_amount").val(rent || '');
});


// ===============================
// SAVE ASSOCIATION
// ===============================
$("#associateForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
        url: "src/process/save_tenant_info.php",
        type: "POST",
        data: $(this).serialize(),

        success: function (res) {

            res = res.trim();

            if (res === "success") {

                $.notify("Unit assigned successfully", "success");

                setTimeout(() => location.reload(), 1200);

            } else {
                $.notify(res, "error");
            }
        },

        error: function () {
            $.notify("Request failed", "error");
        }
    });
});


