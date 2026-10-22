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

<title>All Invoices</title>

<?php require 'src/inc/headerlinks.php'; ?>
<?php require 'src/inc/datatablelinks.php'; ?>



</head>

<body class="app-body bg-gray-100 h-full">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <?php require 'src/inc/sidebar.php'; ?>

    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- HEADER -->
        <?php require 'src/inc/header.php'; ?>

        <main class="flex-1 overflow-y-auto p-8 bg-white m-4">

            <h2 class="text-2xl font-bold mb-6 text-gray-700">
                All Invoices
            </h2>

            <div class="overflow-x-auto">
                <table id="invoiceTable" class="min-w-full text-sm text-left">
                    <thead class="bg-gray-200 text-gray-600 uppercase">
                        <tr>
                            <th class="p-3">#</th>
                            <th class="p-3">Tenant</th>
                            <th class="p-3">Property</th>
                            <th class="p-3">Unit</th>
                            <th class="p-3">Amount</th>
                            <th class="p-3">Due Date</th>
                            <th class="p-3">Period to</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $query = $db->con->query("
                            SELECT i.*, t.name AS tenant_name
                            FROM invoices i
                            JOIN tenants t ON i.tenant_id = t.id WHERE i.active = '1'
                            ORDER BY i.id DESC
                        ");

                        $i = 1;
                        while($row = $query->fetch_assoc()):
                        ?>
                        <tr class="border-b">
                            <td class="p-3"><?= $i++; ?></td>
                            <td class="p-3"><?= h($row['tenant_name']) ?></td>
                            <td class="p-3"><?= h($row['property']) ?></td>
                            <td class="p-3"><?= h($row['unit']) ?></td>
                            <td class="p-3">KES <?= number_format($row['total_amount']); ?></td>
                            <td class="p-3"><?= h($row['due_date']) ?></td>
                            <td class="p-3"><?= h($row['period_to']) ?></td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-white text-xs
                                    <?= $row['status']=='paid' ? 'bg-green-500' : 'bg-yellow-500'; ?>">
                                    <?= ucfirst($row['status']); ?>
                                </span>
                            </td>
                            <td class="p-3 flex gap-2">
                                <button class="editBtn bg-blue-500 text-white px-3 py-1 rounded"
                                    data-id="<?= h($row['id']) ?>">
                                    Edit
                                </button>

                                <button class="deleteBtn bg-red-500 text-white px-3 py-1 rounded"
                                    data-id="<?= h($row['id']) ?>">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>

                </table>
            </div>

        </main>

    </div>

</div>

<!-- ===================== -->
<!-- EDIT MODAL -->
<!-- ===================== -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">

    <div class="bg-white p-6 rounded-lg w-full max-w-lg">

        <h3 class="text-lg font-bold mb-4">Edit Invoice</h3>

        <form id="editForm">
<input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
            <input type="hidden" name="id" id="edit_id">

            <div class="mb-3">
                <label>Amount</label>
                <input type="text" name="amount" id="edit_amount" class="w-full border p-2 rounded">
            </div>

            <!-- DUE DATE -->
            <div class="mb-3">
                <label>Due Date</label>
                <div class="relative">
                    <input type="text" name="due_date" id="edit_due_date"
                        class="w-full border p-2 pr-10 rounded datepicker cursor-pointer"
                        placeholder="YYYY-MM-DD" readonly>

                    <i class="fas fa-calendar-alt absolute right-3 top-3 text-gray-500 pointer-events-none"></i>
                </div>
            </div>

            <!-- PERIOD TO -->
            <div class="mb-3">
                <label>Period To</label>
                <div class="relative">
                    <input type="text" name="period_to" id="edit_period_to"
                        class="w-full border p-2 pr-10 rounded datepicker cursor-pointer"
                        placeholder="YYYY-MM-DD" readonly>

                    <i class="fas fa-calendar-alt absolute right-3 top-3 text-gray-500 pointer-events-none"></i>
                </div>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select disabled id="edit_status" class="w-full border p-2 rounded">
                    <option value="unpaid">Unpaid</option>
                    <option value="paid">Paid</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" id="closeModal" class="px-4 py-2 bg-gray-400 text-white rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Update</button>
            </div>
        </form>

    </div>

</div>

<!-- SUCCESS -->
<div id="successMsg" class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg hidden"></div>

<?php require 'src/inc/bottomlinks.php'; ?>

<!-- ===================== -->
<!-- SCRIPT -->
<!-- ===================== -->
<script>
$(document).ready(function(){

    // DATATABLE
    $('#invoiceTable').DataTable();

    // =====================
    // DELETE
    // =====================
    $(document).on("click", ".deleteBtn", function(){
        let id = $(this).data("id");

        if(confirm("Delete this invoice?")){
            $.post("src/process/delete_invoice.php", {id:id}, function(){
                location.reload();
            });
        }
    });

    // =====================
    // OPEN EDIT MODAL
    // =====================
    $(document).on("click", ".editBtn", function(){
        let id = $(this).data("id");

        $.post("src/harvest/get_invoice.php", {id:id}, function(res){
            let data = JSON.parse(res);
            if (!data || data.status === "paid") { $.notify("Paid invoices cannot be edited.", "warn"); return; }

            $("#edit_id").val(data.id);
            $("#edit_amount").val(data.total_amount);
            $("#edit_due_date").val(data.due_date);
            $("#edit_status").val(data.status);
            $("#edit_period_to").val(data.period_to); // ✅ NEW

            $("#editModal").removeClass("hidden").addClass("flex");
        });
    });

    // CLOSE MODAL
    $("#closeModal").click(function(){
        $("#editModal").addClass("hidden").removeClass("flex");
    });

    // =====================
    // UPDATE
    // =====================
    $("#editForm").submit(function(e){
        e.preventDefault();

        $.post("src/process/update_invoice.php", $(this).serialize(), function(){
            $("#successMsg").text("Invoice Updated Successfully").removeClass("hidden");

            setTimeout(() => location.reload(), 1000);
        }).fail(function(xhr){ $.notify(xhr.responseText || "Unable to update invoice.", "error"); });
    });

});

$(".datepicker").datepicker({
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true
});
</script>

</body>
</html>
