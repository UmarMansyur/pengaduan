<?php
include '../config/database.php';
session_start();
$conn = Connection::getInstance()->getConnection();
$user = $_SESSION['user'];

function getFiles($fileInputName) {
  $target_dir = "../uploads/";
  $maxSize = 5 * 1024 * 1024; // 5MB
  $uploadedFiles = [];



  // Memeriksa apakah ada file yang diunggah
  if (isset($_FILES[$fileInputName]) && count($_FILES[$fileInputName]['name']) > 0) {
    $totalFiles = count($_FILES[$fileInputName]['name']);
    
    for ($i = 0; $i < $totalFiles; $i++) {
      // Memeriksa ukuran file
      if ($_FILES[$fileInputName]["size"][$i] > $maxSize) {
        echo "<script>alert('Ukuran file " . $_FILES[$fileInputName]['name'][$i] . " terlalu besar!')</script>";
        echo "<script>window.location.href = 'index.php?page=lapor'</script>";
        return null;
      }

      $target_file = $target_dir . basename($_FILES[$fileInputName]["name"][$i]);
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      $newFileName = uniqid() . '.' . $imageFileType;
      $newTargetFile = $target_dir . $newFileName;

      // Mengunggah file
      if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"][$i], $newTargetFile)) {
        // Menyimpan nama file yang berhasil diunggah
        $uploadedFiles[] = $newFileName;
      } else {
        // Jika terjadi kesalahan saat unggah file
        echo "<script>alert('Gagal mengunggah file " . $_FILES[$fileInputName]['name'][$i] . "')</script>";
        echo "<script>window.location.href = 'index.php?page=lapor'</script>";
        return null;
      }
    }
    
    // Mengembalikan daftar file yang diunggah
    return $uploadedFiles;
  } else {
    echo "<script>alert('Tidak ada file yang diunggah!')</script>";
    echo "<script>window.location.href = 'index.php?page=lapor'</script>";
    return null;
  }
}


if (isset($_POST['simpan'])) {
  $judul_laporan = mysqli_real_escape_string($conn, $_POST['judul_laporan']);
  $nama_terlapor = mysqli_real_escape_string($conn, $_POST['nama_terlapor']);
  $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
  $kategori = $_POST['kategori'];
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  // $lampiran = getFile('lampiran');
  $pengguna_id = $_SESSION['user']['id'];

  $query = "INSERT INTO pengaduan (judul_laporan, nama_terlapor, alamat, kategori_layanan_id, deskripsi, pengguna_id, status_pengaduan, tanggal_dibuat) VALUES ('$judul_laporan', '$nama_terlapor', '$alamat', $kategori, '$deskripsi', $pengguna_id, 'Pending', NOW())";
  $conn->query($query);

  $lampirans = getFiles('lampiran');
  $query = "";
  if ($lampirans) {
    $pengaduan_id = $conn->insert_id;
    foreach ($lampirans as $lampiran) {
      $query .= "INSERT INTO file_lampiran (nama, path, pengaduan_id) VALUES ('$lampiran', '/uploads/$lampiran', $pengaduan_id);";
    }
    $result = $conn->multi_query($query);
    if (!$result) {
      echo "<script>alert('Gagal mengunggah lampiran!')</script>";
      echo "<script>window.location.href = 'index.php?page=lapor'</script>";
    }

  }

  echo "<script>alert('Laporan berhasil dikirim!')</script>";
  echo "<script>window.location.href = '/index.php?page=lapor'</script>";
} else {
  echo "<script>window.location.href = '/index.php?page=lapor'</script>";
}


?>
