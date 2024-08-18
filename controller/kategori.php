<?php
include '../config/database.php'; // Include file koneksi database

$action = isset($_GET['action']) ? $_GET['action'] : '';
$conn = Connection::getInstance()->getConnection();

header('Content-Type: application/json');

if ($action == 'read') {
  $query = $conn->query("SELECT * FROM kategori_layanan ORDER BY id DESC");
  $no = 1;
  $result = '';

  while ($kategori = $query->fetch_assoc()) {
    $result .= "
        <tr>
          <td class='text-center'>{$no}</td>
          <td>{$kategori['nama']}</td>
          <td class='text-center'>
            <button class='btn btn-sm btn-warning' onclick='editKategori({$kategori['id']})'>
              <i class='bx bx-pencil'></i> Edit
            </button>
            <button class='btn btn-sm btn-danger' onclick='deleteKategori({$kategori['id']})'>
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
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  if ($id) {
    $stmt = $conn->prepare("UPDATE kategori_layanan SET nama = ? WHERE id = ?");
    $stmt->bind_param('si', $nama, $id);
  } else {
    $stmt = $conn->prepare("INSERT INTO kategori_layanan (nama) VALUES (?)");
    $stmt->bind_param('s', $nama);
  }

  if ($stmt->execute()) {
    echo json_encode([
      'status' => 'success',
      'message' => 'Kategori berhasil disimpan.'
    ]);
  } else {
    echo json_encode([
      'status' => 'error',
      'message' => 'Terjadi kesalahan saat menyimpan kategori.'
    ]);
  }
} elseif ($action == 'edit') {
  $id = $_GET['id'];
  $query = $conn->query("SELECT * FROM kategori_layanan WHERE id = $id");

  if ($kategori = $query->fetch_assoc()) {
    echo json_encode([
      'status' => 'success',
      'data' => $kategori
    ]);
  } else {
    echo json_encode([
      'status' => 'error',
      'message' => 'Kategori tidak ditemukan.'
    ]);
  }
} elseif ($action == 'delete') {
  $id = $_GET['id'];
  $query = $conn->query("DELETE FROM kategori_layanan WHERE id = $id");

  if ($query) {
    echo json_encode([
      'status' => 'success',
      'message' => 'Kategori berhasil dihapus.'
    ]);
  } else {
    echo json_encode([
      'status' => 'error',
      'message' => 'Terjadi kesalahan saat menghapus kategori.'
    ]);
  }
} else {
  echo json_encode([
    'status' => 'error',
    'message' => 'Aksi tidak valid.'
  ]);
}
