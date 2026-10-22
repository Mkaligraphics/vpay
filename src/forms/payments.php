<form id="paymentForm" class="space-y-6">
<input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">

<!-- TENANT -->
<div>
<label class="block text-sm text-gray-600 mb-1">Tenant</label>
<select id="tenant" name="tenant_id" required
class="w-full border p-3 rounded-lg select-search">
<option value="">Select Tenant</option>

<?php
$tenants = $db->con->query("SELECT id, name FROM tenants WHERE active = 1 ORDER BY name");
while($t = $tenants->fetch_assoc()){
echo '<option value="'.h($t['id']).'">'.h($t['name']).'</option>';
}
?>
</select>
</div>

<!-- INVOICE -->
<div>
    <label class="block text-sm text-gray-600 mb-1">Invoice</label>

    <select id="invoice" name="invoice_id" required
        class="w-full border p-3 rounded-lg select-search">

        <option value="">Select Invoice</option>
    </select>
</div>

<!-- GRID -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <!-- PROPERTY -->
    <div>
    <label class="block text-sm text-gray-600 mb-1">Property</label>
    <select id="property" name="property_id"
    class="w-full border p-3 rounded-lg bg-gray-100 select-search" readonly>
    <option value="">Auto-filled</option>
    </select>
    </div>

    <!-- UNIT -->
    <div>
    <label class="block text-sm text-gray-600 mb-1">Unit</label>
    <select id="unit" name="unit_id"
    class="w-full border p-3 rounded-lg select-search">
    <option value="">Select Unit</option>
    </select>
    </div>

    <!-- PAYMENT DATE -->
    <div>
    <label class="block text-sm text-gray-600 mb-1">Payment Date</label>
    <input type="text" name="payment_date" id="payment_date" required
    class="w-full border p-3 rounded-lg bg-white">
    </div>

    <!-- PAYMENT FOR -->
    <div>
    <label class="block text-sm text-gray-600 mb-1">Payment For</label>
    <input type="text" name="payment_for" id="payment_for" required readonly
    class="w-full border p-3 rounded-lg bg-white">
    </div>

    <!-- AMOUNT (FULL WIDTH) -->
    <div class="md:col-span-2">
    <label class="block text-sm text-gray-600 mb-1">Amount (KES)</label>
    <input type="number" name="amount" id="amount" min="0.01" step="0.01" required
    class="w-full border p-3 rounded-lg bg-gray-100" readonly>
    </div>

</div>


<!-- PAYMENT METHOD -->
<div>
<label class="block text-sm text-gray-600 mb-1">Payment Method</label>
<select name="method" required
class="w-full border p-3 rounded-lg">
<option value="M-Pesa">M-Pesa</option>
<option value="Cash">Cash</option>
<option value="Bank">Bank Transfer</option>
</select>
</div>



<!-- SUBMIT -->
<button type="submit"
class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
Submit Payment
</button>

</form>
