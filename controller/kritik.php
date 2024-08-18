<?php
include '../config/database.php';
$conn = Connection::getInstance()->getConnection();

if (isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $dibaca = false;
  $sql = "INSERT INTO kritik_saran (email, nama, deskripsi, dibaca) VALUES ('$email', '$nama', '$deskripsi', '$dibaca')";
  $result = $conn->query($sql);
  if ($result) {
    echo "<script>alert('Kritik dan saran berhasil dikirim!');</script>";
    echo "<script>window.location.href='/pengaduan/index.php';</script>";
  } else {
    echo "<script>alert('Kritik dan saran gagal dikirim!');</script>";
    echo "<script>window.location.href='/pengaduan/index.php';</script>";
  }
}


if (isset($_GET['action']) && $_GET['action'] == 'show') {
  $data = "SELECT * FROM kritik_saran ORDER BY createdAt DESC";
  $result = $conn->query($data);

  $response = ''; // Variabel untuk menyimpan hasil HTML
  $no = 1; // Variabel untuk nomor urut

  while ($row = $result->fetch_assoc()) {
    $statusBadge = $row['dibaca'] == 0 ? 'danger' : 'success';
    $statusText = $row['dibaca'] == 0 ? 'Belum Dibaca' : 'Sudah Dibaca';
    $tanggal = date('d-m-Y', strtotime($row['createdAt']));
    // Tambahkan baris HTML ke variabel response
    $response .= "
            <tr>
              <td class='text-center'>{$no}</td>
              <td>{$tanggal}</td>
              <td>{$row['nama']}</td>
              <td>{$row['email']}</td>
              <td class='text-center'>
                <span class='badge bg-{$statusBadge}'>{$statusText}</span>
              </td>
              <td class='text-center'>
                <button class='btn btn-sm btn-primary' onclick='viewKritik({$row['id']}, \"{$row['deskripsi']}\")' data-bs-toggle='modal' data-bs-target='#modalKritik'>
                  <i class='bx bx-search-alt'></i>
                </button>

                <button class='btn btn-sm btn-danger' onclick='deleteKritik({$row['id']})'>
                  <i class='bx bx-trash'></i>
                </button>
              </td>
            </tr>";
    $no++;
  }

  // Kirimkan respons sebagai JSON jika Anda mengirimkan data dari server ke klien
  echo json_encode(['html' => $response]);
}


if(isset($_GET['action']) && $_GET['action'] == 'read') {
  $id = $_GET['id'];
  $sql = $conn->query("SELECT * FROM kritik_saran WHERE id = $id");
  $row = $sql->fetch_assoc();
  $update = $conn->query("UPDATE kritik_saran SET dibaca = true WHERE id = $id");
  $data = "SELECT * FROM kritik_saran";
  $result = $conn->query($data);
  $response = array();
  while ($row = $result->fetch_assoc()) {
    $response[] = $row;
  }
  echo json_encode($response);
}

if(isset($_GET['action']) && $_GET['action'] == 'delete') {
  $id = $_GET['id'];
  $sql = $conn->query("DELETE FROM kritik_saran WHERE id = $id");
  if ($sql) {
    echo "<script>alert('Kritik dan saran berhasil dihapus!');</script>";
    echo "<script>window.location.href='/pengaduan/admin?page=kritik-saran';</script>";
  } else {
    echo "<script>alert('Kritik dan saran gagal dihapus!');</script>";
    echo "<script>window.location.href='/pengaduan/admin?page=kritik-saran';</script>";
  }
}