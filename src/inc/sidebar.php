<?php $navPage = basename($_SERVER['SCRIPT_NAME'], '.php'); ?>
<aside id="appSidebar" class="app-sidebar hidden md:flex flex-col">
  <a href="dashboard.php" class="brand" aria-label="VPay home"><span class="brand-symbol">v<span>↗</span></span><span>vpay<span class="brand-dot">.</span><small>PROPERTY MANAGER</small></span></a>
  <div class="workspace-switch"><span class="workspace-icon"><i class="fas fa-building" aria-hidden="true"></i></span><div><strong>My workspace</strong><small>Real estate management</small></div><span class="workspace-live" title="Workspace"></span></div>
  <nav class="sidebar-nav" aria-label="Main navigation">
    <p class="nav-label">WORKSPACE</p>
    <?php foreach ([['dashboard','fa-border-all','Overview'],['properties','fa-building','Properties'],['tenants','fa-users','Tenants'],['payments','fa-wallet','Payments']] as $item): ?>
    <a href="<?= h($item[0]) ?>.php" class="nav-link <?= $navPage === $item[0] ? 'nav-active' : '' ?>" <?= $navPage === $item[0] ? 'aria-current="page"' : '' ?>><i class="fas <?= h($item[1]) ?>" aria-hidden="true"></i><span><?= h($item[2]) ?></span><?php if ($navPage === $item[0]): ?><span class="active-dot"></span><?php endif; ?></a>
    <?php endforeach; ?>
    <button type="button" id="invoiceMenuBtn" class="nav-link nav-group" aria-controls="invoiceSubmenu" aria-expanded="false"><i class="fas fa-file-invoice" aria-hidden="true"></i><span>Invoices</span><i id="invoiceArrow" class="fas fa-chevron-down nav-arrow" aria-hidden="true"></i></button>
    <div id="invoiceSubmenu" class="nav-submenu" style="display:none"><a href="invoices.php">All invoices</a><a href="create_invoices.php">Create invoice</a></div>
    <a href="maintenance.php" class="nav-link <?= $navPage === 'maintenance' ? 'nav-active' : '' ?>"><i class="fas fa-screwdriver-wrench" aria-hidden="true"></i><span>Maintenance</span></a>
    <p class="nav-label nav-label-spaced">MANAGE</p>
    <button type="button" id="propertyMenuBtn" class="nav-link nav-group" aria-controls="propertySubmenu" aria-expanded="false"><i class="fas fa-layer-group" aria-hidden="true"></i><span>Property setup</span><i id="propertyArrow" class="fas fa-chevron-down nav-arrow" aria-hidden="true"></i></button>
    <div id="propertySubmenu" class="nav-submenu" style="display:none"><a href="newproperty.php">Add property</a><a href="property_units.php">Create units</a><a href="units.php">All units</a><a href="property_types.php">Property types</a></div>
    <button type="button" id="reportsMenuBtn" class="nav-link nav-group" aria-controls="reportsSubmenu" aria-expanded="false"><i class="fas fa-chart-simple" aria-hidden="true"></i><span>Reports</span><i id="reportsArrow" class="fas fa-chevron-down nav-arrow" aria-hidden="true"></i></button>
    <div id="reportsSubmenu" class="nav-submenu" style="display:none"><a href="payment_report.php">Payment report</a><a href="occupancy_report.php">Occupancy report</a></div>
    <a href="settings.php" class="nav-link <?= $navPage === 'settings' ? 'nav-active' : '' ?>"><i class="fas fa-sliders" aria-hidden="true"></i><span>Settings</span></a>
  </nav>
  <div class="sidebar-bottom"><div class="sidebar-note"><span class="note-icon"><i class="fas fa-arrow-trend-up" aria-hidden="true"></i></span><strong>Space to grow.</strong><p>Your next property starts here.</p><a href="newproperty.php">Add a property <span aria-hidden="true">↗</span></a></div><span class="sidebar-foot">VPay workspace <span>© <?= date('Y') ?></span></span></div>
</aside>
<button type="button" id="navBackdrop" class="nav-backdrop" aria-label="Close navigation" hidden></button>
