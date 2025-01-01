<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Anda harus login terlebih dahulu!");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_users";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Cek jika sudah ada pengaturan notifikasi untuk pengguna ini
$query = "SELECT * FROM pengaturan_notifikasi WHERE user_id = $user_id";
$result = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $waktu_notifikasi = $_POST['waktu_notifikasi'];

    if ($result->num_rows > 0) {
        // Jika sudah ada pengaturan, update
        $update_query = "UPDATE pengaturan_notifikasi SET waktu_notifikasi = $waktu_notifikasi WHERE user_id = $user_id";
        $conn->query($update_query);
    } else {
        // Jika belum ada pengaturan, insert
        $insert_query = "INSERT INTO pengaturan_notifikasi (user_id, waktu_notifikasi) VALUES ($user_id, $waktu_notifikasi)";
        $conn->query($insert_query);
    }

    echo "<script>alert('Pengaturan notifikasi berhasil disimpan!');</script>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Notifikasi</title>
</head>
<body>
    <h1>Kelola Notifikasi</h1>
    <form action="" method="POST">
        <label for="waktu_notifikasi">Atur Notifikasi untuk Semua Tugas (dalam hari sebelum tenggat):</label><br>
        <input type="number" name="waktu_notifikasi" value="1" min="1" required><br><br>
        <button type="submit">Simpan Pengaturan Notifikasi</button>
    </form>
</body>
</html>
