<?php
include '../config/database.php';
$conn = Connection::getInstance()->getConnection();
session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>document.location.href = '/';</script>";
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Lapor | Dinas Pendidikan Kabupaten Pamekasan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Website laporan pengaduan masyarakat pamekasan, jawa timur" name="description">
    <meta content="Themesbrand" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="./views/assets/img/logo.png">
    <link href="/admin/assets/libs/chartist/chartist.min.css" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="/admin/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <script src="/admin/assets/libs/jquery/jquery.min.js"></script>

    <link href="/admin/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="/admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="/admin/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <!-- Responsive datatable examples -->
    <link href="/admin/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <!-- App Css-->
    <link href="/admin/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    <style>
.ck-editor__editable_inline {
    min-height: 450px;
}
</style>
</head>

<body data-sidebar="dark" data-topbar="light">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php
        include 'header.php';
        include 'sidebar.php';
        ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid" style="width: 100%;">
                    <div class="page-title-box">
                        <?php
                        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                        switch ($page) {
                            case 'dashboard':
                                include 'dashboard.php';
                                break;
                            case 'statistik':
                                include 'statistik.php';
                                break;
                            case 'pending':
                                include 'pengaduan.php';
                                break;
                            case 'diproses':
                                include 'pengaduan.php';
                                break;
                            case 'selesai':
                                include 'pengaduan.php';
                                break;
                            case 'ditolak':
                                include 'pengaduan.php';
                                break;
                            case 'kategori-layanan':
                                include 'kategori_layanan.php';
                                break;
                            case 'tentang-kami':
                                include 'tentangkami.php';
                                break;
                            default:
                                include 'dashboard.php';
                                break;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/admin/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="/admin/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/admin/assets/libs/node-waves/waves.min.js"></script>
    <!-- Peity chart-->
    <script src="/admin/assets/libs/peity/jquery.peity.min.js"></script>
    <script src="/admin/assets/js/app.js"></script>
    <script src="/admin/assets/libs/chartist/chartist.min.js"></script>
    <script src="/admin/assets/libs/chartist-plugin-tooltips/chartist-plugin-tooltip.min.js"></script>
    <script src="/admin/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/admin/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/admin/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/admin/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="/admin/assets/libs/morris.js/morris.min.js"></script>
    <script src="/admin/assets/libs/raphael/raphael.min.js"></script>
    <!-- Plugin Js-->
    <!-- <script src="/admin/assets/js/pages/dashboard.init.js"></script> -->
    <!-- Data Table -->
    <!-- <script src="/admin/assets/js/pages/datatables.init.js"></script> -->
    <!-- morris chart -->
    <!-- morris init js -->
    <!-- <script src="/admin/assets/js/pages/morris.init.js"></script> -->


</body>

</html>