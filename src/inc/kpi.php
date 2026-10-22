<?php
$occupiedUnits = (int)$data->units_status('occupied');
$vacantUnits = (int)$data->units_status('vacant');
$totalUnits = $occupiedUnits + $vacantUnits;
$collected = (float)$data->collected_revenue();
$expected = (float)$data->expected_revenue();
$pending = (float)$data->pending_cash();
$occupancy = $totalUnits ? (int)round($occupiedUnits / $totalUnits * 100) : 0;
?>
<section class="stats-grid" aria-label="Portfolio summary">
  <article class="stat-card"><div class="stat-top"><span>Total units</span><span class="stat-icon stat-icon-slate"><i class="fas fa-building" aria-hidden="true"></i></span></div><p class="stat-value"><?= number_format($totalUnits) ?><span class="stat-unit">units</span></p><div class="stat-bottom"><span class="stat-dot"></span><?= $occupiedUnits ?> occupied <span class="stat-separator">·</span> <?= $vacantUnits ?> vacant</div></article>
  <article class="stat-card stat-card-accent"><div class="stat-top"><span>Rent collected</span><span class="stat-icon"><i class="fas fa-wallet" aria-hidden="true"></i></span></div><p class="stat-value"><span class="stat-currency">KES</span><?= number_format($collected) ?></p><div class="stat-bottom"><span class="stat-dot"></span>For <?= date('F Y') ?></div></article>
  <article class="stat-card"><div class="stat-top"><span>Pending payments</span><span class="stat-icon stat-icon-gold"><i class="far fa-clock" aria-hidden="true"></i></span></div><p class="stat-value"><span class="stat-currency">KES</span><?= number_format($pending) ?></p><div class="stat-bottom">Expected rent less collections</div></article>
  <article class="stat-card"><div class="stat-top"><span>Expected revenue</span><span class="stat-icon stat-icon-slate"><i class="fas fa-arrow-trend-up" aria-hidden="true"></i></span></div><p class="stat-value"><span class="stat-currency">KES</span><?= number_format($expected) ?></p><div class="stat-bottom">Monthly active lease value</div></article>
</section>
