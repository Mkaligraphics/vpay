<?php
$pageNames = ['dashboard'=>'Overview','properties'=>'Properties','tenants'=>'Tenants','payments'=>'Record payment','newproperty'=>'Add property','property_units'=>'Create units','property_types'=>'Property types','units'=>'Units','invoices'=>'Invoices','create_invoices'=>'Create invoice','payment_report'=>'Payment report','occupancy_report'=>'Occupancy report','settings'=>'Settings','maintenance'=>'Maintenance'];
$pageKey = basename($_SERVER['SCRIPT_NAME'], '.php');
$pageTitle = $pageNames[$pageKey] ?? 'VPay';
$userName = $data->getfield('name') ?: 'Account';
?>
<header class="app-header">
  <div class="header-location"><button type="button" id="mobileMenuBtn" aria-label="Open navigation" aria-controls="appSidebar" aria-expanded="false" class="mobile-menu-button md:hidden"><i class="fas fa-bars" aria-hidden="true"></i></button><span class="header-workspace">Workspace</span><span class="header-slash">/</span><span class="header-current"><?= h($pageTitle) ?></span></div>
  <div class="header-right"><span class="header-date"><i class="far fa-calendar" aria-hidden="true"></i><?= date('D, d M Y') ?></span><span class="header-divider"></span><div class="relative"><button type="button" id="profileButton" aria-label="Account menu for <?= h($userName) ?>" aria-expanded="false" class="profile-trigger"><span class="avatar"><?= h(strtoupper(substr($userName, 0, 2))) ?></span><span class="profile-name"><?= h($userName) ?><small>My account</small></span><i class="fas fa-chevron-down" aria-hidden="true"></i></button><div id="profileMenu" class="hidden profile-menu"><p>Signed in as <strong><?= h($userName) ?></strong></p><a href="settings.php"><i class="fas fa-sliders" aria-hidden="true"></i>Settings</a><a href="logout.php" class="signout"><i class="fas fa-arrow-right-from-bracket" aria-hidden="true"></i>Sign out</a></div></div></div>
</header>
