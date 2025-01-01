<?php
session_start(); // Pastikan sesi aktif
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_tugas = $_POST['nama_tugas'];
    $tenggat_waktu = $_POST['tenggat_waktu'];
    $kategori = $_POST['kategori'];
    $user_id = $_SESSION['user_id']; // Ambil user_id dari sesi

    if (!empty($nama_tugas) && !empty($tenggat_waktu) && !empty($kategori)) {
        $insert_query = "INSERT INTO tugas (nama_tugas, tenggat_waktu, kategori, user_id) VALUES ('$nama_tugas', '$tenggat_waktu', '$kategori', $user_id)";
        if ($conn->query($insert_query) === TRUE) {
            echo "<script>alert('Tugas berhasil ditambahkan!');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Semua kolom harus diisi!');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Tugas</title>
</head>
<body>
    <h1>Kelola Tugas</h1>
    <form action="" method="POST">
        <label for="nama_tugas">Nama Tugas:</label><br>
        <input type="text" id="nama_tugas" name="nama_tugas" required><br><br>

        <label for="tenggat_waktu">Tenggat Waktu:</label><br>
        <input type="date" id="tenggat_waktu" name="tenggat_waktu" required><br><br>

        <label for="kategori">Kategori:</label><br>
        <select id="kategori" name="kategori" required>
            <option value="Akademi">Akademi</option>
            <option value="Organisasi">Organisasi</option>
            <option value="Lomba">Lomba</option>
        </select><br><br>

        <button type="submit">Simpan Tugas</button>
    </form>
</body>
</html>