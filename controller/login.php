<?php
include '../config/database.php';
$submit = isset($_POST['login']) ? $_POST['login'] : null;
$conn = Connection::getInstance()->getConnection();

function checkUser($username, $password)
{
  $exist = Connection::getInstance()->getConnection()->query("SELECT * FROM pengguna WHERE username = '$username'");
  if ($exist->num_rows > 0) {
    $user = $exist->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      return $user;
    } else {
      return null;
    }
  } else {
    return null;
  }
}

if (isset($_POST['login'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $existUser = checkUser($username, $password);
  if ($existUser) {
    session_start();
    $_SESSION['user'] = $existUser;
    echo "<script>location.href = '/pengaduan/index.php'</script>";
  } else {
    echo "<script>alert('Username atau password salah!')</script>";
    echo "<script>location.href = '/pengaduan/index.php'</script>";
  }
} else {
  echo "<script>location.href = '/pengaduan/index.php'</script>";
}

?>
