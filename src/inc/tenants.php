<table id="tenantTable" class="display w-full">

<thead>
<tr>
<th>Apartment</th>
<th>Unit</th>
<th>Name</th>
<th>Phone</th>
<th>Email</th>
<th>Lease Start</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($tenants)){ ?>

<tr id="row_<?= h($row['id']) ?>">

<td><?= h($row['property_name']) ?></td>
<td><?= h($row['unit_number']) ?></td>
<td><?= h($row['name']) ?></td>
<td><?= h($row['phone']) ?></td>
<td><?= h($row['email']) ?></td>
<td><?= h($row['lease_start']) ?></td>

<td>
<button onclick="deleteTenant(<?= h($row['id']) ?>)"
class="bg-red-500 text-white px-3 py-1 rounded text-sm">
Delete
</button>
</td>

</tr>

<?php } ?>

</tbody>

</table>
