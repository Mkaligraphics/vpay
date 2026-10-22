<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">

<div class="bg-white p-6 rounded-xl w-96">

<h2 class="text-xl font-bold mb-4">Edit Property</h2>

<form id="editForm">
<input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">

<input type="hidden" id="edit_id" name="id">

<input type="text" id="edit_name" name="name" placeholder="Property Name" class="border w-full p-2 mb-2">

<input type="text" id="edit_county" name="county" placeholder="County" class="border w-full p-2 mb-2">

<input type="text" id="edit_town" name="town" placeholder="Town" class="border w-full p-2 mb-2">

<input type="number" id="edit_units" name="units" placeholder="Units" class="border w-full p-2 mb-2">

<input type="number" id="edit_minrent" name="min_rent" placeholder="Min Rent" class="border w-full p-2 mb-2">

<input type="number" id="edit_maxrent" name="max_rent" placeholder="Max Rent" class="border w-full p-2 mb-2">

<select id="edit_status" name="status" class="border w-full p-2 mb-2">
<option value="Active">Active</option>
<option value="Inactive">Inactive</option>
<option value="Under Construction">Under Construction</option>
</select>

<textarea id="edit_description" name="description" class="border w-full p-2 mb-3"></textarea>

<div class="flex justify-end gap-2">

<button type="button" id="closeModal" class="bg-gray-500 text-white px-3 py-1 rounded">
Cancel
</button>

<button type="submit" class="bg-green-600 text-white px-3 py-1 rounded">
Save
</button>

</div>

</form>
</div>
</div>
