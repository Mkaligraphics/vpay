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
<title>Properties · VPay</title>
<?php require 'src/inc/headerlinks.php'; ?>


</head>

<body class="app-body h-full bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

<!-- SIDEBAR -->
<?php require 'src/inc/sidebar.php'; ?>

<div class="flex-1 flex flex-col overflow-hidden">

<!-- HEADER -->
<?php require 'src/inc/header.php'; ?>

<main class="flex-1 overflow-y-auto p-8 space-y-8">

<div class="page-heading"><div><p class="eyebrow">YOUR PORTFOLIO</p><h1>Great places. One workspace<span class="heading-dot">.</span></h1><p>Manage your properties, rental ranges and availability.</p></div><a href="newproperty.php" class="button-primary"><i class="fas fa-plus" aria-hidden="true"></i>Add property</a></div>
<!-- PROPERTY TABLE -->
<section class="surface overflow-hidden">
<div class="panel-heading property-panel-heading">
        <div><p class="eyebrow">PLACES WITH POTENTIAL</p><h2>Your properties</h2></div>
            <a href="newproperty.php" class="button-secondary">
                    <i class="fas fa-plus" aria-hidden="true"></i> Add property
            </a>
</div>

<div class="overflow-x-auto">
        <?php include 'src/inc/properties.php'; ?>

</div>
</section>
<footer class="workspace-footer"><span>A little more clarity. A lot more possibility.</span><span>VPay · Property management, considered.</span></footer>
</main>
</div>
</div>

<!-- EDIT MODAL -->
<?php require 'src/modals/editproperty.php'; ?>
<!-- BOTTOM LINK -->
<?php require 'src/inc/bottomlinks.php'; ?>
<!-- DATATABLE LINKS -->
<?php require 'src/inc/datatablelinks.php'; ?>
<!-- DASHBOARD JS -->
<script src="src/scripts/dashboard.js"></script>

</body>
</html>
