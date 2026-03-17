<aside class="hidden md:flex flex-col w-72 bg-gradient-to-b from-red-900 to-red-700 text-white shadow-xl">

    <div class="p-6 border-b border-red-600">
      <h1 class="text-2xl font-bold tracking-wide">VPAY</h1>
      <p class="text-sm text-red-200">RealEstate Management</p>
    </div>

    <nav class="flex-1 p-5 space-y-2">

      <a href="dashboard" class="block px-4 py-3 rounded-lg bg-red-800 font-semibold">
        Dashboard
      </a>

<div>
<button id="propertyMenuBtn" class="w-full flex justify-between items-center px-4 py-3 rounded-lg hover:bg-red-800">
<span>Properties</span>
<svg id="propertyArrow" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform transition-transform"
fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round"
stroke-width="2" d="M19 9l-7 7-7-7" />
</svg>
</button>

<div id="propertySubmenu" class="hidden pl-6 mt-2 space-y-2">
        <a href="newproperty.php" class="block px-4 py-2 rounded-lg hover:bg-red-800 text-sm">Add New Property</a>
        <a href="property-units.php" class="block px-4 py-2 rounded-lg hover:bg-red-800 text-sm">Property Units</a>
        <a href="property-types.php" class="block px-4 py-2 rounded-lg hover:bg-red-800 text-sm">Property Types</a>
</div>

</div>

      <a href="tenants" class="block px-4 py-3 rounded-lg hover:bg-red-800">
        Tenants
      </a>

      <a href="payments" class="block px-4 py-3 rounded-lg hover:bg-red-800">
        Payments
      </a>

      <a href="maintenance" class="block px-4 py-3 rounded-lg hover:bg-red-800">
        Maintenance
      </a>

      <a href="reports" class="block px-4 py-3 rounded-lg hover:bg-red-800">
        Reports
      </a>

      <a href="settings" class="block px-4 py-3 rounded-lg hover:bg-red-800">
        Settings
      </a>

    </nav>

</aside>