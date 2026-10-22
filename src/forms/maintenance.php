<form id="maintenanceForm" class="space-y-4">
<input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">

<!-- TENANT -->
<div>
<label class="block text-sm text-gray-600 mb-1">Tenant</label>
<select id="tenant" name="tenant_id" required
class="w-full border p-3 rounded-lg">
<option value="">Select Tenant</option>

<?php
$tenants = $db->con->query("SELECT id, name FROM tenants");
while($t = $tenants->fetch_assoc()){
echo "<option value='{$t['id']}'>{$t['name']}</option>";
}
?>
</select>
</div>

<!-- PROPERTY -->
<div>
<label class="block text-sm text-gray-600 mb-1">Property</label>
<select id="property" name="property_id"
class="w-full border p-3 rounded-lg bg-gray-100" readonly>
<option value="">Auto-filled</option>
</select>
</div>

<!-- UNIT -->
<div>
<label class="block text-sm text-gray-600 mb-1">Unit</label>
<select id="unit" name="unit_id"
class="w-full border p-3 rounded-lg bg-gray-100">
<option value="">Select Unit</option>
</select>
</div>

<!-- ISSUE TITLE -->
<div>
<label class="block text-sm text-gray-600 mb-1">Issue Title</label>
<input type="text" name="title" required
class="w-full border p-3 rounded-lg"
placeholder="e.g. Water leakage, broken door">
</div>

<!-- DESCRIPTION -->
<div>
<label class="block text-sm text-gray-600 mb-1">Description</label>
<textarea name="description" rows="4" required
class="w-full border p-3 rounded-lg"
placeholder="Describe the issue in detail..."></textarea>
</div>

<!-- PRIORITY -->
<div>
<label class="block text-sm text-gray-600 mb-1">Priority</label>
<select name="priority" required
class="w-full border p-3 rounded-lg">
<option value="Low">Low</option>
<option value="Medium">Medium</option>
<option value="High">High</option>
</select>
</div>

<!-- STATUS -->
<div>
<label class="block text-sm text-gray-600 mb-1">Status</label>
<select name="status" required
class="w-full border p-3 rounded-lg">
<option value="Pending">Pending</option>
<option value="In Progress">In Progress</option>
<option value="Completed">Completed</option>
</select>
</div>

<!-- DATE -->
<div>
<label class="block text-sm text-gray-600 mb-1">Request Date</label>
<input type="date" name="request_date" id="request_date" required
class="w-full border p-3 rounded-lg">
</div>

<!-- SUBMIT -->
<button type="submit"
class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
Submit Request
</button>

</form>
