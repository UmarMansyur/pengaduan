<?php
include '../config/database.php'; // Include file koneksi database

$conn = Connection::getInstance()->getConnection();
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$deskripsi = $_POST['deskripsi'];

if ($id) {
    // Update
    $stmt = $conn->prepare("UPDATE tentang_kami SET deskripsi = ? WHERE id = ?");
    $stmt->bind_param('si', $deskripsi, $id);
} else {
    // Insert
    $stmt = $conn->prepare("INSERT INTO tentang_kami (deskripsi) VALUES (?)");
    $stmt->bind_param('s', $deskripsi);
}

if ($stmt->execute()) {
    echo "<script>alert('Data berhasil disimpan!'); window.location.href = '/admin?page=tentang-kami';</script>";
} else {
    echo "<script>alert('Terjadi kesalahan saat menyimpan data.'); window.location.href = '/admin?page=tentang-kami';</script>";
}
?>
