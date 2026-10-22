
<div id="addTenantModal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center">

<div class="bg-white rounded-xl p-6 w-96">

<h3 class="text-lg font-semibold mb-4">Add Tenant</h3>

<form id="addTenantForm">
<input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">

<input type="text" name="name" placeholder="Tenant Name"
class="w-full border p-2 mb-3 rounded" required>

<input type="text" name="phone" placeholder="Phone"
class="w-full border p-2 mb-3 rounded">

<input type="email" name="email" placeholder="Email"
class="w-full border p-2 mb-3 rounded">

<label class="text-sm">Lease Start</label>
<input type="date" name="lease_start"
class="w-full border p-2 mb-3 rounded">


<div class="flex justify-end gap-3">

<button type="button" onclick="closeModal()"
class="px-4 py-2 bg-gray-300 rounded">
Cancel
</button>

<button type="submit"
class="px-4 py-2 bg-blue-600 text-white rounded">
Save
</button>

</div>

</form>

</div>

</div>
