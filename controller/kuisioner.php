<?php
include '../config/database.php'; // Include file koneksi database

$action = isset($_GET['action']) ? $_GET['action'] : '';
$conn = Connection::getInstance()->getConnection();

header('Content-Type: application/json');

if ($action == 'read') {
  $query = $conn->query("SELECT * FROM kuisioner ORDER BY id DESC");
  $no = 1;
  $result = '';

  while ($kuisioner = $query->fetch_assoc()) {
    $result .= "
    <tr class='text-center'>
      <td class='text-center' style='width: 5%;'>{$no}</td>
      <td class='text-start'>{$kuisioner['nama']}</td>
      <td style='width: 15%;'>{$kuisioner['jumlah_soal']}</td>
      <td style='width: 15%;'>{$kuisioner['jumlah_jawaban']}</td>
      <td class='text-center' style='width: 15%;'>
        <a href='javascript:void(0);' class='badge bg-" . ($kuisioner['status'] == 0 ? 'danger' : 'success') . "' onclick='changeStatus({$kuisioner['id']})'>
          " . ($kuisioner['status'] == 0 ? 'Tidak Aktif' : 'Aktif') . "
        </a>
      </td>
      <td class='text-center' style='width: 25%;'>
        <a href='/pengaduan/admin?page=kuisioner&id={$kuisioner['id']}' class='btn btn-sm btn-primary'>
          <i class='bx bx-show'></i> Lihat
        </a>
        <button class='btn btn-sm btn-warning' onclick='editKuisioner({$kuisioner['id']})'>
          <i class='bx bx-pencil'></i> Edit
        </button>
        <button class='btn btn-sm btn-danger' onclick='deleteKuisioner({$kuisioner['id']})'>
          <i class='bx bx-trash'></i> Hapus
        </button>
      </td>
    </tr>";
    $no++;
  }

  echo json_encode([
    'status' => 'success',
    'data' => $result
  ]);
} elseif ($action == 'save') {
  $id = isset($_POST['id']) ? $_POST['id'] : '';
  $nama = mysqli_real_escape_string($conn, $_POST['kuisioner']);
  $jumlah_soal = mysqli_real_escape_string($conn, $_POST['jumlah_soal']);
  $jumlah_jawaban = mysqli_real_escape_string($conn, $_POST['jumlah_jawaban']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);

  if ($id) {
    // Update
    $stmt = $conn->prepare("UPDATE kuisioner SET nama = ?, jumlah_soal = ?, jumlah_jawaban = ?, status = ? WHERE id = ?");
    $stmt->bind_param('siiii', $nama, $jumlah_soal, $jumlah_jawaban, $status, $id);
  } else {
    // Insert
    $stmt = $conn->prepare("INSERT INTO kuisioner (nama, jumlah_soal, jumlah_jawaban, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('siii', $nama, $jumlah_soal, $jumlah_jawaban, $status);
  }

  if ($stmt->execute()) {
    echo json_encode([
      'status' => 'success',
      'message' => 'Kuisioner berhasil disimpan.'
    ]);
  } else {
    echo json_encode([
      'status' => 'error',
      'message' => 'Terjadi kesalahan saat menyimpan kuisioner.'
    ]);
  }
} elseif ($action == 'edit') {
  $id = $_GET['id'];
  $query = $conn->query("SELECT * FROM kuisioner WHERE id = $id");

  if ($kuisioner = $query->fetch_assoc()) {
    echo json_encode([
      'status' => 'success',
      'data' => $kuisioner
    ]);
  } else {
    echo json_encode([
      'status' => 'error',
      'message' => 'Kuisioner tidak ditemukan.'
    ]);
  }
} elseif ($action == 'delete') {
  $id = $_GET['id'];
  $query = $conn->query("DELETE FROM kuisioner WHERE id = $id");

  if ($query) {
    echo json_encode([
      'status' => 'success',
      'message' => 'Kuisioner berhasil dihapus.'
    ]);
  } else {
    echo json_encode([
      'status' => 'error',
      'message' => 'Terjadi kesalahan saat menghapus kuisioner.'
    ]);
  }
} elseif ($action == 'changeStatus') {
  $sql = "UPDATE kuisioner set status = IF(status = 0, 1, 0) WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $_GET['id']);
  $stmt->execute();
  $sql2 = "UPDATE kuisioner set status = 0 WHERE id != ?";
  $stmt2 = $conn->prepare($sql2);
  $stmt2->bind_param('i', $_GET['id']);
  $stmt2->execute();
  echo json_encode([
    'status' => 'success',
    'message' => 'Status kuisioner berhasil diubah.'
  ]);
} else {
  echo json_encode([
    'status' => 'error',
    'message' => 'Aksi tidak valid.'
  ]);
}
