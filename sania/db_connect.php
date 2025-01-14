<?php
$host = 'localhost';
$user = 'root'; // Ganti dengan username MySQL Anda
$pass = '';     // Ganti dengan password MySQL Anda
$db = 'admin_kendaraan';

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
