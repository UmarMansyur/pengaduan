<?php
// Koneksi database
include '../config/database.php';
$conn = Connection::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = mysqli_real_escape_string($conn, $_POST['responden']);
  $usia = $_POST['umur'];
  $kuisioner_id = $_POST['kuisioner_id'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $pendidikan = $_POST['pendidikan'];
  $pekerjaan = $_POST['pekerjaan'];
  $jawaban = $_POST['jawaban'];

  $conn->begin_transaction();

  try {
    $stmt = $conn->prepare("
            INSERT INTO jawaban_pengguna (nama, usia, kuisioner_id, jenis_kelamin, pendidikan, pekerjaan) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
    $stmt->bind_param("siisss", $nama, $usia, $kuisioner_id, $jenis_kelamin, $pendidikan, $pekerjaan);
    $stmt->execute();
    $jawaban_pengguna_id = $conn->insert_id;
    $stmtDetail = $conn->prepare("
            INSERT INTO detail_jawaban_pengguna (jawaban_pengguna_id, soal_id, jawaban_id) 
            VALUES (?, ?, ?)
        ");
    foreach ($jawaban as $soal_id => $jawaban_id) {
      $stmtDetail->bind_param("iii", $jawaban_pengguna_id, $soal_id, $jawaban_id);
      $stmtDetail->execute();
    }
    $conn->commit();
    echo "<script>alert('Data berhasil disimpan!');</script>";
    echo "<script>window.location.href = '/pengaduan/index.php?page=ikm';</script>";
  } catch (Exception $e) {
    $conn->rollback();
    echo "Terjadi kesalahan: " . $e->getMessage();
  }
}
