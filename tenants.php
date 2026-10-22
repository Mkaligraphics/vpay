<?php
session_start();
require 'src/config/database.php';
require 'src/config/class.php';
$db = new dbase;
$data = new modules;

/* Tenants with Apartment + Unit */
$tenants = $db->con->query("
SELECT
    t.id,
    t.name,
    t.phone,
    t.email,
    t.lease_start,
    t.active,

    ti.property_id,
    ti.unit_id,
    ti.amount,

    u.unit_number,
    p.name AS property_name

FROM tenants t

LEFT JOIN tenant_info ti ON t.id = ti.tenant_id AND ti.active = 1
LEFT JOIN property_units u ON ti.unit_id = u.id
LEFT JOIN properties p ON ti.property_id = p.id

WHERE t.active = 1
ORDER BY t.id DESC
");

/* Apartments */
$properties = $db->con->query("
SELECT id, name
FROM properties
WHERE active = 1
ORDER BY name ASC
");
?>

<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tenants | VPAY</title>

<?php require 'src/inc/headerlinks.php'; ?>


</head>

<body class="app-body h-full bg-gray-100">

<div class="flex h-screen overflow-hidden">

<?php require 'src/inc/sidebar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden">

<?php require 'src/inc/header.php'; ?>

<main class="flex-1 overflow-y-auto p-8 space-y-8">


<div class="flex justify-between mb-6">

<div>
<h2 class="text-2xl font-bold text-gray-700">Tenants</h2>
<p class="text-gray-500 text-sm">Manage property tenants</p>
</div>


<div class="flex gap-2">
    <button onclick="openAddTenant()"
    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
    + Add Tenant
    </button>

    <button onclick="openAssociateModal()"
    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
    + Associate Unit
    </button>
</div>

</div>

<div class="bg-white shadow rounded-xl p-6">

        <div class="overflow-x-auto"><?php include 'src/inc/tenants.php'; ?></div>


</div>


</main>

</div>

</div>


<!-- ADD TENANT MODAL -->
<?php require 'src/modals/addtenant.php'; ?>
<?php require 'src/modals/associate_unit.php'; ?>

<!-- BOTTOM LINK -->
<?php require 'src/inc/bottomlinks.php'; ?>
<!-- DATATABLE LINKS -->
<?php require 'src/inc/datatablelinks.php'; ?>
<!-- DASHBOARD JS -->
<script src="src/scripts/tenants.js"></script>


</body>
</html>
