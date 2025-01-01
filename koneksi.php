<?php
$host = "localhost";
$user = "root"; // Default username untuk XAMPP/WAMP
$pass = "";     // Default password untuk XAMPP/WAMP
$db   = "db_users"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    echo "Koneksi Berhasil";
}
?>
