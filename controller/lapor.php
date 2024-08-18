<?php
include '../config/database.php';
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$conn = Connection::getInstance()->getConnection();

function getFiles($fileInputName)
{
  $target_dir = "../uploads/";
  $maxSize = 5 * 1024 * 1024; // 5MB
  $uploadedFiles = [];

  if (empty($_FILES[$fileInputName])) {
    echo "<script>alert('Tidak ada file yang diunggah!')</script>";
    echo "<script>window.location.href = 'index.php?page=lapor'</script>";
    return null;
  }


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
    echo "<script>window.location.href = '/index.php?page=lapor'</script>";
    return null;
  }
}


if (isset($_POST['simpan'])) {
  $nama_pelapor = mysqli_real_escape_string($conn, $_POST['nama_pelapor']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $usia = mysqli_real_escape_string($conn, $_POST['usia']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $nik = mysqli_real_escape_string($conn, $_POST['nik']);
  $judul_laporan = mysqli_real_escape_string($conn, $_POST['judul_laporan']);
  $alamat_lengap = mysqli_real_escape_string($conn, $_POST['alamat_lengkap']);
  $nama_terlapor = mysqli_real_escape_string($conn, $_POST['nama_terlapor']);
  $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
  $alamat_lengap = mysqli_real_escape_string($conn, $_POST['alamat_lengkap']);
  $kategori = $_POST['kategori'];
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $query = "INSERT INTO pengaduan (nama_pelapor, email, jenis_kelamin, usia, phone, nik, judul_laporan, nama_terlapor, alamat, kategori_layanan_id, deskripsi, alamat_lengkap) VALUES ('$nama_pelapor', '$email', '$jenis_kelamin', '$usia', '$phone', '$nik', '$judul_laporan', '$nama_terlapor', '$alamat', $kategori, '$deskripsi', '$alamat_lengap')";
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

  $tanggal_laporan = date('Y-m-d');

  // echo "<script>alert('Laporan berhasil dikirim!')</script>";
  $dompdf = new Dompdf();
  $dompdf->loadHtml('<h1>Laporan Pengaduan</h1><p>Nama Pelapor: ' . $nama_pelapor . '</p><p>Email: ' . $email . '</p><p>Jenis Kelamin: ' . $jenis_kelamin . '</p><p>Usia: ' . $usia . '</p><p>Phone: ' . $phone . '</p><p>NIK: ' . $nik . '</p><p>Judul Laporan: ' . $judul_laporan . '</p><p>Nama Terlapor: ' . $nama_terlapor . '</p><p>Alamat: ' . $alamat . '</p><p>Kategori Layanan: ' . $kategori . '</p><p>Deskripsi: ' . $deskripsi . '</p><p> Kode Laporan: ' . '#LP-' . $tanggal_laporan . '-' . $conn->insert_id);
  $dompdf->setPaper('A4', 'portrait');
  $dompdf->render();

  $mail = new PHPMailer(true);
  $options["ssl"] = array(
    "verify_peer" => false,
    "verify_peer_name" => false,
    "allow_self_signed" => true,
  );

  
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply.disdikpamekasan@gmail.com';
    $mail->Password = 'jjmd gpbx pufu vfbo';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Enable verbose debug output
    $mail->SMTPDebug = 0;

    $mail->setFrom('noreply.disdikpamekasan@gmail.com', 'Official Dinas Pendidikan Kabupaten Pamekasan');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Formulir Pengaduan';
    $mail->Body = "
    Laporan Pengaduan Anda berhasil dikirim! Berikut adalah detail laporan Anda:
    <h1>Laporan Pengaduan</h1>
    <p>Nama Pelapor: $nama_pelapor</p>
    <p>Email: $email</p>
    <p>Jenis Kelamin: $jenis_kelamin</p>
    <p>Usia: $usia</p>
    <p>Nomor HP: $phone</p>
    <p>NIK: $nik</p>
    <p>Alamat Pelapor: $alamat_lengap</p>
    <p>Judul Laporan: $judul_laporan</p>
    <p>Nama Terlapor: $nama_terlapor</p>
    <p>Alamat: $alamat</p>
    <p>Kategori Layanan: $kategori</p>
    <p>Deskripsi: $deskripsi</p>
    <p>Kode Laporan: #LP-$tanggal_laporan-$conn->insert_id
    ";

    $mail->addStringAttachment($dompdf->output(), 'Laporan Pengaduan.pdf');


    $mail->send();
    echo "<script>alert('Laporan berhasil dikirim!')</script>";
    echo "<script>window.location.href = '/index.php?page=lapor'</script>";
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}







  // echo "<script>window.location.href = '/index.php?page=lapor'</script>";
} else {
  echo "<script>window.location.href = '/index.php?page=lapor'</script>";
}
