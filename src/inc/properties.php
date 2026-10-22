
<table id="propertiesTable" class="display w-full">

<thead>
<tr>
<th>Name</th>
<th>Location</th>
<th>Units</th>
<th>Monthly rent</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

<?php
$result = $db->con->query("SELECT * FROM properties WHERE active='1'");

while($row = $result->fetch_assoc()){
?>

<tr>
<td><div class="property-cell"><span class="property-avatar"><i class="fas fa-building" aria-hidden="true"></i></span><div><strong><?= h($row['name']) ?></strong><small><?= h($row['description'] ?: 'Residential property') ?></small></div></div></td>
<td><span class="location-cell"><?= h($row['town']) ?><small><?= h($row['county']) ?></small></span></td>
<td><?= h($row['units']) ?></td>
<td class="rent-cell"><small>KES</small> <?= number_format($row['min_rent']) ?> – <?= number_format($row['max_rent']) ?></td>
<td>
<span class="status-badge
<?= $row['status']=='Active' ? '' : 'status-badge-muted' ?>">
<?= h($row['status']) ?>
</span>
</td>

<td><div class="table-actions">

<button
class="editBtn table-edit"
data-id="<?= h($row['id']) ?>"
data-name="<?= h($row['name']) ?>"
data-county="<?= h($row['county']) ?>"
data-town="<?= h($row['town']) ?>"
data-units="<?= h($row['units']) ?>"
data-minrent="<?= h($row['min_rent']) ?>"
data-maxrent="<?= h($row['max_rent']) ?>"
data-status="<?= h($row['status']) ?>"
data-description="<?= h($row['description']) ?>"
>
Edit
</button>

<button
class="deleteBtn table-delete"
data-id="<?= h($row['id']) ?>"
>
Delete
</button>
</div>
</td>

</tr>

<?php } ?>

</tbody>
</table>
