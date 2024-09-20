<?php
session_start();
include "config.php"; // Ensure config.php is properly set for MySQL and SQLite

// Initialize variables
$err = "";
$name = "";
$ingataku = "";

// Koneksi ke database SQLite
try {
    $sqlite_db = new PDO('sqlite:session.db');
    $sqlite_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Unable to connect to SQLite: " . $e->getMessage());
}

// Check if cookie is set
if (isset($_COOKIE['cookie_name'])) {
    $cookie_name = htmlspecialchars($_COOKIE['cookie_name']);

    // Check in MySQL for session data
    try {
        $sql1 = "SELECT * FROM sessions WHERE name = :name";
        $stmt1 = $mysql_db->prepare($sql1);
        $stmt1->bindParam(':name', $cookie_name, PDO::PARAM_STR);
        $stmt1->execute();
        $r1 = $stmt1->fetch(PDO::FETCH_ASSOC);

        if ($r1 && $r1['name'] === $cookie_name) {
            $_SESSION['users'] = json_decode($r1['data'], true);
            echo '<script>alert("Welcome");</script>';
            header("Location: https://yourlink");
            exit();
        }
    } catch (Exception $e) {
        $err .= "Error fetching session: " . $e->getMessage();
    }
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $ingataku = isset($_POST['ingataku']) ? $_POST['ingataku'] : '';

    if (empty($name)) {
        $err .= "<li>Silakan masukkan name.</li>";
    } else {
        try {
            // Check in MySQL for user data
            $sql2 = "SELECT * FROM users WHERE name = :name";
            $stmt2 = $mysql_db->prepare($sql2);
            $stmt2->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt2->execute();
            $r2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            if (!$r2) {
                $err .= "<li>Name <b>$name</b> tidak tersedia.</li>";
                echo "<script>alert('Maaf, username $name anda tidak ada di database, silahkan hubungi admin');</script>";
            } elseif (!$r2['status']) {
                // User is already logged in elsewhere
                echo "<script>alert('Maaf, username $name sudah dipakai.');</script>";
            } else {
                // Update user status to logged in in MySQL
                $sql_update = "UPDATE users SET status = 0 WHERE name = :name";
                $stmt_update = $mysql_db->prepare($sql_update);
                $stmt_update->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt_update->execute();

                $_SESSION['users'] = $r2;

                if ($ingataku == 1) {
                    // Save session data in MySQL
                    $sql_insert = "INSERT INTO sessions (name, data) VALUES (:name, :data)";
                    $stmt_insert = $mysql_db->prepare($sql_insert);
                    $session_data = json_encode($r2);
                    $stmt_insert->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt_insert->bindParam(':data', $session_data, PDO::PARAM_STR);
                    $stmt_insert->execute();

                    setcookie("cookie_name", $name, time() + (60 * 60 * 24 * 30), "/");
                }

                echo '<script>alert("Welcome");</script>';
                header("Location: https://yourlink");
                exit();
            }
        } catch (Exception $e) {
            $err .= "Error processing user data: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <script src="https://cdn.tailwindcss.com"></script>
   <style>
       body {
           background-color: black;
       }
   </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-black">

   <div class="w-full max-w-sm p-6 bg-gray-800 rounded-lg shadow-md">
       <h1 class="text-3xl text-center text-pink-500 font-bold mb-8">Login</h1>
       <form method="post">
           <div class="mb-6">
               <label for="name" class="block text-pink-400 font-semibold mb-2">Name</label>
               <input type="text" name="name" class="w-full px-4 py-2 bg-gray-700 text-white rounded-md focus:ring-2 focus:ring-pink-500 focus:outline-none" required>
           </div>
           
           <div class="flex items-center mb-6">
               <input id="login-remember" type="checkbox" name="ingataku" value="1" class="mr-2 focus:ring-pink-500 text-pink-500">
               <label for="login-remember" class="text-pink-400">Ingat Aku</label>
           </div>
           
           <div class="text-center">
               <button type="submit" class="w-full bg-pink-500 text-white font-semibold py-2 rounded-md hover:bg-pink-600 transition-colors">Login</button>
           </div>
       </form>
   </div>

</body>
</html>
