   <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">

      <div>
        <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
        <p class="text-sm text-gray-500">Welcome back, 
          <?php if ($data->loggedin()) { ?>          
              <?php echo strtoupper($data->getfield('name')); ?>
            <?php } else { ?>    
              <script>location.href='logout.php';</script>
            <?php } ?>
        </p>
      </div>

      <div class="flex items-center space-x-6">

        <input type="text" placeholder="Search..."
          class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">

        <div class="relative">
          <button onclick="toggleProfile()" class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-blue-700 text-white rounded-full flex items-center justify-center">
              VP
            </div>
          </button>

          <div id="profileMenu" class="hidden absolute right-0 mt-2 w-44 bg-white shadow-xl rounded-lg">
            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
            <a href="logout" class="block px-4 py-2 hover:bg-gray-100 text-red-500">Logout</a>
          </div>
        </div>

      </div>

    </header>