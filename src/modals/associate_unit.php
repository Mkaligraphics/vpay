<div id="associateModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">

<div class="bg-white p-6 rounded-xl w-full max-w-md space-y-4">

<h2 class="text-lg font-bold">Assign Unit to Tenant</h2>

<form id="associateForm" class="space-y-3">
<input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">

<!-- TENANT -->
<select name="tenant_id" id="assoc_tenant" class="w-full border p-2 rounded" required>
<option value="">Select Tenant</option>

<?php
$tenantList = $db->con->query("SELECT id, name FROM tenants ORDER BY name ASC");
while($t = $tenantList->fetch_assoc()){
?>
<option value="<?= h($t['id']) ?>"><?= h($t['name']) ?></option>
<?php } ?>

</select>

<!-- PROPERTY -->
<select id="assoc_property" name="property_id" class="w-full border p-2 rounded" required>
<option value="">Select Property</option>

<?php
$properties->data_seek(0); // reset pointer
while($p = $properties->fetch_assoc()){
?>
<option value="<?= h($p['id']) ?>"><?= h($p['name']) ?></option>
<?php } ?>

</select>

<!-- UNIT -->
<select id="assoc_unit" name="unit_id" class="w-full border p-2 rounded" required>
<option value="">Select Unit</option>
</select>

<!-- AMOUNT -->
<input type="number" name="amount" id="assoc_amount"
placeholder="Rent Amount"
class="w-full border p-2 rounded" required>

<!-- ACTIONS -->
<div class="flex justify-end gap-2">
<button type="button" onclick="closeAssociateModal()" class="px-3 py-1 bg-gray-300 rounded">
Cancel
</button>

<button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded">
Save
</button>
</div>

</form>

</div>
</div>
