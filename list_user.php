<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List_Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-100 p-6">
    <h2 class="text-2xl font-bold text-gray-700 mb-6">List of Users</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead>
          <tr class="bg-gray-800 text-white">
            <th class="py-2 px-4">#</th>
            <th class="py-2 px-4">ID</th>
            <th class="py-2 px-4">Name</th>
            <th class="py-2 px-4">Email</th>
            <th class="py-2 px-4">Gender</th>
            <th class="py-2 px-4">Status</th>
            <th class="py-2 px-4">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            require 'config.php';
            $stmt = $mysql_db->query("SELECT * FROM users");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $i = 1;
          ?>
          <?php foreach($rows as $row) : ?>
          <tr id="<?php echo $row["id"]; ?>" class="border-b">
            <td class="py-2 px-4 text-center"><?php echo $i++; ?></td>
            <td class="py-2 px-4 text-center"><?php echo $row["id"]; ?></td>
            <td class="py-2 px-4"><?php echo $row["name"]; ?></td>
            <td class="py-2 px-4"><?php echo $row["email"]; ?></td>
            <td class="py-2 px-4 text-center"><?php echo $row["gender"]; ?></td>
            <td class="py-2 px-4 text-center">
              <span class="py-1 px-3 rounded-full text-white <?php echo $row['status'] == 1 ? 'bg-green-500' : 'bg-red-500'; ?>">
                <?php echo $row["status"] == 1 ? 'Active' : 'Inactive'; ?>
              </span>
            </td>
            <td class="py-2 px-4 text-center">
              <a href="edituser.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-800">Edit</a>
              <button type="button" onclick="submitData(<?php echo $row['id']; ?>);" class="ml-4 text-red-600 hover:text-red-800">Delete</button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <br>
    <a href="adduser.php" class="inline-block bg-blue-600 text-white py-2 px-4 rounded mt-4 hover:bg-blue-700">Add User</a>
    
    <?php require 'script.php'; ?>
  </body>
</html>
