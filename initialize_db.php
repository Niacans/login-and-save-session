<?php
// Koneksi ke database SQLite
try {
    $db = new PDO('sqlite:session.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Membaca isi file SQL
    $sql = file_get_contents('create_table.sql');
    
    // Menjalankan perintah SQL untuk membuat tabel
    $db->exec($sql);
    
    echo "Tabel 'users' berhasil dibuat.";
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
