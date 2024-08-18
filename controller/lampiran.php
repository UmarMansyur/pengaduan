<?php
include '../config/database.php';
$conn = Connection::getInstance()->getConnection();
if (!isset($_GET['id']) || empty($_GET['id']) && !isset($_GET['status'])) {
  echo json_encode([
    'error' => 'ID Pengaduan tidak ditemukan'
  ]);
  return;
}

if (isset($_GET['id']) && empty($_GET['status'])) {
  $lampiran = $conn->query("SELECT * FROM file_lampiran WHERE pengaduan_id = $_GET[id]");
  $lampiran = $lampiran->fetch_all(MYSQLI_ASSOC);
  echo json_encode([
    'lampiran' => $lampiran
  ]);
  return;
}


if (isset($_GET['id']) && isset($_GET['status']) && $_GET['status'] !== 'Ditolak') {
  $id = $_GET['id'];
  $status = $_GET['status'];
  $sql = "UPDATE pengaduan SET status_pengaduan = '$status'";
  if ($status === 'Diproses') {
    $sql .= ", tanggal_diproses = NOW()";
  } else if ($status === 'Selesai') {
    $sql .= ", tanggal_selesai = NOW()";
  } else if ($status === 'Pending') {
    $sql .= ", tanggal_diproses = NULL, tanggal_selesai = NULL";
  }
  $sql .= " WHERE id = $id";
  $update = $conn->query($sql);
  if ($update) {
    // buat status menjadi huruf kecil
    $status = strtolower($status);
    echo "<script>alert('Berhasil mengubah status pengaduan menjadi $status')</script>";
    echo "<script>document.location.href = '/admin?page=$_GET[page]';</script>";
  } else {
    echo json_encode([
      'error' => 'Gagal mengubah status pengaduan'
    ]);
    return;
  }
}

if (isset($_GET['status']) && $_GET['status'] === 'Ditolak' && isset($_GET['alasan'])) {
  $id_pengaduan = $_GET['id'];
  $alasan = $_GET['alasan'];
  
  // Lakukan update status pengaduan dan simpan alasan penolakan
  $stmt = $conn->prepare("UPDATE pengaduan SET status_pengaduan = ?, alasan_penolakan = ? WHERE id = ?");
  $stmt->bind_param("ssi", $_GET['status'], $alasan, $id_pengaduan);
  $stmt->execute();

  // Redirect setelah update
  echo "<script>alert('Berhasil menolak pengaduan')</script>";
  echo "<script>document.location.href = '/admin?page=$_GET[page]';</script>";
  exit;
}

