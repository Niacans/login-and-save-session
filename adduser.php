<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full">
      <h2 class="text-2xl font-bold text-gray-700 mb-6">Add New User</h2>
      <form autocomplete="off" action="" method="post" class="space-y-4">
        <input type="hidden" id="id" value="<?php echo $rows['id']; ?>">

        <div>
          <label for="name" class="block text-gray-600">Name</label>
          <input type="text" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" value="">
        </div>

        <div>
          <label for="email" class="block text-gray-600">Email</label>
          <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" value="">
        </div>

        <div>
          <label for="status" class="block text-gray-600">Status</label>
          <input type="number" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" value="">
        </div>

        <div>
          <label for="gender" class="block text-gray-600">Gender</label>
          <select id="gender" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>

        <button type="button" onclick="submitData('insert');" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">Insert</button>
      </form>
      
      <div class="mt-6 text-center">
        <a href="list_user.php" class="text-blue-600 hover:text-blue-800">Go To Index</a>
      </div>
    </div>
    
    <?php require 'script.php'; ?>
  </body>
</html>
