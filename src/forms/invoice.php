<form id="invoiceForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">
<input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">

<!-- TENANT -->
<div>
<label class="block text-sm text-gray-600 mb-1">Tenant</label>
<select id="tenant" name="tenant_id"
class="w-full border p-3 rounded-lg select-search cursor-pointer">
<option value="">Select Tenant</option>

<?php
$tenants = $db->con->query("
SELECT
    t.id,
    t.name,
    pu.unit_number,
    p.name AS property, ti.amount AS rent
FROM tenant_info ti
JOIN tenants t ON ti.tenant_id = t.id
JOIN property_units pu ON ti.unit_id = pu.id
JOIN properties p ON ti.property_id = p.id
WHERE ti.active = 1 AND t.active = 1
");

while($row = $tenants->fetch_assoc()){
    echo '<option value="'.h($row['id']).'" data-property="'.h($row['property']).'" data-unit="'.h($row['unit_number']).'" data-rent="'.h($row['rent']).'">'.h($row['name'].' - '.$row['unit_number'].' ('.$row['property'].')').'</option>';
}
?>
</select>
</div>

<!-- PROPERTY -->
<div>
<label class="block text-sm text-gray-600 mb-1">Property</label>
<input type="text" id="property_display"
class="w-full border p-3 rounded-lg bg-gray-100" readonly>
<input type="hidden" name="property" id="property">
</div>

<!-- UNIT -->
<div>
<label class="block text-sm text-gray-600 mb-1">Unit</label>
<input type="text" id="unit_display"
class="w-full border p-3 rounded-lg bg-gray-100" readonly>
<input type="hidden" name="unit" id="unit">
</div>

<!-- RENT -->
<div>
<label class="block text-sm text-gray-600 mb-1">Monthly Rent</label>
<input type="number" id="amount" name="amount" required
class="w-full border p-3 rounded-lg">
</div>

<!-- NEXT DUE -->
<div>
<label class="block text-sm text-gray-600 mb-1">Next Due Date</label>
<input type="text" id="due_date" name="due_date" placeholder="Select date"
class="w-full border p-3 rounded-lg datepicker cursor-pointer">
</div>

<!-- PERIOD TO -->
<div>
<label class="block text-sm text-gray-600 mb-1">Billing Period To</label>
<input type="text" id="period_to" name="period_to" placeholder="Select date"
class="w-full border p-3 rounded-lg datepicker cursor-pointer">
</div>

<!-- MONTHS -->
<div>
<label class="block text-sm text-gray-600 mb-1">Months</label>
<input type="text" id="months_display"
class="w-full border p-3 rounded-lg bg-gray-100" readonly>
<input type="hidden" name="months" id="months">
</div>

<!-- TOTAL -->
<div>
<label class="block text-sm text-gray-600 mb-1">Total Amount</label>
<input type="text" id="total_display"
class="w-full border p-3 rounded-lg bg-gray-100" readonly>
<input type="hidden" name="total" id="total">
</div>

<!-- DESCRIPTION -->
<div class="md:col-span-2">
<label class="block text-sm text-gray-600 mb-1">Description</label>
<textarea name="description" id="description"
class="w-full border p-3 rounded-lg"></textarea>
</div>

<!-- SUBMIT -->
<div class="md:col-span-2">
<button type="submit"
class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
Create Invoice
</button>
</div>

</form>
