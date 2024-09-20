<?php
try {
    $mysql_db = new PDO('mysql:host=localhost;dbname=lala', 'root', '');
    $mysql_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Unable to connect to MySQL: " . $e->getMessage());
}
?>
