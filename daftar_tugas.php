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

// Menangani perubahan status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    $status = isset($_POST['status']) ? 1 : 0;  // Status menjadi 1 jika dicentang, 0 jika tidak
    
    // Update status tugas di database
    $update_query = "UPDATE tugas SET status = $status WHERE id = $task_id AND user_id = $user_id";
    if ($conn->query($update_query) === TRUE) {
        echo "<script>alert('Status tugas berhasil diperbarui!');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
    }
}

$result = $conn->query("SELECT * FROM tugas WHERE user_id = $user_id");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Tugas</title>
</head>
<body>
    <h1>Daftar Tugas</h1>
    <table border="1">
        <tr>
            <th>Nama Tugas</th>
            <th>Tenggat Waktu</th>
            <th>Kategori</th>
            <th>Status</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nama_tugas']); ?></td>
                    <td><?php echo htmlspecialchars($row['tenggat_waktu']); ?></td>
                    <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                    <td>
                        <form action="" method="POST">
                            <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                            <input type="checkbox" name="status" value="1" <?php echo $row['status'] ? 'checked' : ''; ?> onchange="this.form.submit()">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Tidak ada tugas.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
