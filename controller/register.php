<?php
include '../config/database.php';
$submit = isset($_POST['simpan']) ? $_POST['simpan'] : null;
$conn = Connection::getInstance()->getConnection();


function checkEmail($email)
{
  $exist = Connection::getInstance()->getConnection()->query("SELECT * FROM pengguna WHERE email = '$email'");
  if ($exist->num_rows > 0) {
    return true;
  } else {
    return false;
  }
}

function checkUsername($username)
{
  $exist = Connection::getInstance()->getConnection()->query("SELECT * FROM pengguna WHERE username = '$username'");
  if ($exist->num_rows > 0) {
    return true;
  } else {
    return false;
  }
}


if (isset($_POST['simpan'])) {
  $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
  $nik = mysqli_real_escape_string($conn, $_POST['nik']);
  $nomor_hp = mysqli_real_escape_string($conn, $_POST['nomor_hp']);
  $usia = mysqli_real_escape_string($conn, $_POST['usia']);
  $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $konfirmasi_password = mysqli_real_escape_string($conn, $_POST['konfirmasi_password']);
  $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

  if ($password == $konfirmasi_password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $existUser = checkEmail($email);
    if ($existUser == true) {
      echo "<script>alert('Email sudah terdaftar!')</script>";
      echo "<script>location.href = '/register.php'</script>";
      return;
    }

    $existUsername = checkUsername($username);
    if ($existUsername == true) {
      echo "<script>alert('Username sudah terdaftar!')</script>";
      echo "<script>location.href = '/register.php'</script>";
      return;
    }

    $query = "INSERT INTO pengguna (nama_lengkap, nik, phone, usia, jenis_kelamin, email, username, password, alamat, type, thumbnail) VALUES ('$nama_lengkap', '$nik', '$nomor_hp', '$usia', '$jenis_kelamin', '$email', '$username', '$password', '$alamat', 'user', 'https://ik.imagekit.io/8zmr0xxik/blob_c2rRi4vdU?updatedAt=1709077347010')";
    $result = Connection::getInstance()->getConnection()->query($query);

    if ($result) {
      echo "<script>alert('Registrasi berhasil! Silahkan login.')</script>";
      echo "<script>location.href = '/pengaduan/index.php'</script>";
    } else {
      echo "<script>alert('Registrasi gagal! Silahkan coba lagi.')</script>";
      echo "<script>location.href = '/register.php'</script>";
    }
  } else {
    echo "<script>alert('Konfirmasi password tidak sesuai!')</script>";
    echo "<script>location.href = '/register.php'</script>";
  }
}

?>
