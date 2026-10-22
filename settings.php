<?php
session_start();
require 'src/config/database.php';
require 'src/config/class.php';
$db = new dbase;
$data = new modules;
$settings = [];
try { foreach ($db->con->query("SELECT meta_key, meta_value FROM settings") as $setting) $settings[$setting["meta_key"]] = $setting["meta_value"]; } catch (mysqli_sql_exception $e) { error_log($e); }
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Settings - VPAY</title>
<?php require 'src/inc/headerlinks.php'; ?>


</head>

<body class="app-body h-full bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

<!-- SIDEBAR -->
<?php require 'src/inc/sidebar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden">

<!-- HEADER -->
<?php require 'src/inc/header.php'; ?>

<main class="flex-1 overflow-y-auto p-8 space-y-6">

<!-- PAGE TITLE -->
<div>
    <h1 class="text-2xl font-bold text-gray-700">System Settings</h1>
    <p class="text-gray-500 text-sm">Manage your system configuration</p>
</div>

<div class="bg-white rounded-2xl shadow overflow-hidden">

<!-- TABS -->
<div class="border-b flex space-x-6 px-6 py-3 text-sm font-medium">
    <button class="tab-btn text-blue-600 border-b-2 border-blue-600 pb-2" data-tab="general">General</button>
    <button class="tab-btn text-gray-500" data-tab="invoice">Invoice</button>
    <button class="tab-btn text-gray-500" data-tab="payment">Payments</button>
    <button class="tab-btn text-gray-500" data-tab="security">Security</button>
</div>

<form id="settingsForm" class="p-6 space-y-6">
<input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">

<!-- ================= GENERAL ================= -->
<div class="tab-content" id="general">

<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="text-sm text-gray-600">Company Name</label>
<input type="text" name="company_name" class="w-full border p-3 rounded-lg">
</div>

<div>
<label class="text-sm text-gray-600">Phone</label>
<input type="text" name="phone" class="w-full border p-3 rounded-lg">
</div>

<div>
<label class="text-sm text-gray-600">Email</label>
<input type="email" name="email" class="w-full border p-3 rounded-lg">
</div>

<div>
<label class="text-sm text-gray-600">Address</label>
<input type="text" name="address" class="w-full border p-3 rounded-lg">
</div>

<div>
<label class="text-sm text-gray-600">Currency</label>
<select name="currency" class="w-full border p-3 rounded-lg">
<option value="KES">KES</option>
<option value="USD">USD</option>
</select>
</div>

</div>
</div>

<!-- ================= INVOICE ================= -->
<div class="tab-content hidden" id="invoice">

<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="text-sm text-gray-600">Invoice Prefix</label>
<input type="text" name="invoice_prefix" value="INV-" class="w-full border p-3 rounded-lg">
</div>

<div>
<label class="text-sm text-gray-600">Default Due Days</label>
<input type="number" name="due_days" value="30" class="w-full border p-3 rounded-lg">
</div>

<div>
<label class="text-sm text-gray-600">Late Fee (%)</label>
<input type="number" name="late_fee" value="0" class="w-full border p-3 rounded-lg">
</div>

</div>
</div>

<!-- ================= PAYMENTS ================= -->
<div class="tab-content hidden" id="payment">

<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="text-sm text-gray-600">Mpesa Paybill</label>
<input type="text" name="paybill" class="w-full border p-3 rounded-lg">
</div>

<div>
<label class="text-sm text-gray-600">Account Number Format</label>
<input type="text" name="account_format" placeholder="e.g Tenant ID" class="w-full border p-3 rounded-lg">
</div>

</div>
</div>

<!-- ================= SECURITY ================= -->
<div class="tab-content hidden" id="security">

<div class="grid md:grid-cols-3 gap-4">

<input type="password" name="current_password" placeholder="Current Password"
class="border p-3 rounded-lg">

<input type="password" name="new_password" placeholder="New Password"
class="border p-3 rounded-lg">

<input type="password" name="confirm_password" placeholder="Confirm Password"
class="border p-3 rounded-lg">

</div>

</div>

<!-- SUBMIT -->
<div>
<button type="submit"
class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
Save Settings
</button>
</div>

</form>

</div>

</main>
</div>
</div>

<?php require 'src/inc/bottomlinks.php'; ?>

<script>

const savedSettings = <?= json_encode($settings, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
Object.entries(savedSettings).forEach(([name, value]) => {
    $('#settingsForm').find('[name="' + name + '"]').val(value);
});
// TAB SWITCHING
$(".tab-btn").click(function(){
    let tab = $(this).data("tab");

    $(".tab-btn").removeClass("text-blue-600 border-b-2 border-blue-600")
                 .addClass("text-gray-500");

    $(this).addClass("text-blue-600 border-b-2 border-blue-600");

    $(".tab-content").addClass("hidden");
    $("#" + tab).removeClass("hidden");
});

// SAVE SETTINGS
$("#settingsForm").submit(function(e){
    e.preventDefault();

    $.ajax({
        url: "src/process/settings.php",
        method: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(res){
            if(res.status === "success"){
                $.notify("Settings saved successfully", "success");
            } else {
                $.notify(res.message, "error");
            }
        },
        error: function(){
            $.notify("Error saving settings. Check the values and try again.", "error");
        }
    });
});

</script>

</body>
</html>
