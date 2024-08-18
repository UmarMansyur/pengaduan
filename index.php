<?php
include './config/database.php';
$conn = Connection::getInstance()->getConnection();
if (!$conn) {
  die('Connection failed: ' . $conn->connect_error);
}
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./views/assets/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" />
  <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
</head>

<body>
  <div class="d-flex flex-column justify-content-between align-items-center w-100" style="min-height: 100vh;">
    <?php
    include './views/layouts/Header.php';
    $menu = 'home';
    if (isset($_GET['page']) == "") {
      include './views/home.php';
    } else if (isset($_GET['page']) && $_GET['page'] == 'lapor') {
      include './views/lapor.php';
    } else if (isset($_GET['page']) && $_GET['page'] == 'monitoring') {
      include './views/monitoring.php';
    } else if (isset($_GET['page']) && $_GET['page'] == 'about-us') {
      include './views/tentang-lapor.php';
    } else if (isset($_GET['page']) && $_GET['page'] == 'detail-monitoring') {
      if (isset($_GET['id'])) {
        include './views/detail-monitoring.php';
      } else {
        include './views/404.php';
      }
    } else {
      include './views/404.php';
    }
    include './views/layouts/Footer.php';
    ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>