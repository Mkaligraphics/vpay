$(document).ready(function(){

// DATEPICKER
$(".datepicker").datepicker({
    dateFormat: "yy-mm-dd"
});

// SUBMIT FORM
$("#invoiceForm").submit(function(e){
    e.preventDefault();

    $.ajax({
        url: "src/process/create_invoice.php",
        method: "POST",
        data: $(this).serialize(),
        dataType: "json", // VERY IMPORTANT
        success: function(res){

            if(res.status === "success"){
                
                $.notify("Invoice created: " + res.invoice_no, "success");

                $("#invoiceForm")[0].reset();
                $("#property_display, #unit_display, #months_display, #total_display").val("");

            } else {

                $.notify(res.message, "error");

            }
        },
        error: function(){
            $.notify("Something went wrong. Try again.", "error");
        }
    });
  });
    });


$(document).ready(function(){

  // =============================
  // SET PROPERTY & UNIT FROM TENANT
  // =============================
  $("#tenant").on("change", function(){

    let selected = $(this).find(":selected");

    let property = selected.data("property");
    let unit     = selected.data("unit");

    $("#property_display").val(property);
    $("#property").val(property);

    $("#unit_display").val(unit);
    $("#unit").val(unit);
    $("#amount").val(selected.data("rent") || "").trigger("change");

  });

  // =============================
  // CALCULATE MONTHS + TOTAL
  // =============================
  function calculateInvoice(){

    let start = $("#due_date").val();
    let end   = $("#period_to").val();
    let rent  = parseFloat($("#amount").val());

    if(!start || !end || !rent) return;

    let d1 = new Date(start);
    let d2 = new Date(end);

    if(d2.getTime() === d1.getTime()){
      setValues(0, 0);
      return;
    }

    if(d2 < d1){
      setValues(0, 0);
      return;
    }

    let months = (d2.getFullYear() - d1.getFullYear()) * 12 +
                 (d2.getMonth() - d1.getMonth());

    if(d2.getDate() > d1.getDate()){
      months += 1;
    }

    let total = months * rent;

    setValues(months, total);

    $("#description").val(`Rent for ${months} month(s)`);

  }

  function setValues(months, total){
    $("#months_display").val(months);
    $("#months").val(months);

    $("#total_display").val(total);
    $("#total").val(total);
  }

  $("#due_date, #period_to, #amount").on("change keyup", calculateInvoice);

});