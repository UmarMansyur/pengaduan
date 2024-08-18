<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistik Pengaduan</title>
  <!-- Include ApexCharts Library -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
  <div class="row align-items-center">
    <div class="col-md-8">
      <h6 class="page-title">Statistik Pengaduan</h6>
      <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="#">Administrator</a></li>
        <li class="breadcrumb-item active" aria-current="page">Statistik Pengaduan</li>
      </ol>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 mb-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Total Pengaduan</h5>
          <div id="kategori-1" style="height: 400px; width: 100%"></div>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Frekuensi Pengaduan Perbulan</h5>
          <div id="frekuensi-perbulan" style="height: 400px; width: 100%"></div>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Frekuensi Pengaduan Perkategori</h5>
          <div id="frekuensi-pengaduan" style="height: 400px; width: 100%"></div>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Frekuensi Pengaduan Perstatus</h5>
          <div id="frekuensi-perstatus" style="height: 400px; width: 100%"></div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Fetch data from PHP
    <?php
    $total_pengaduan = "SELECT COUNT(*) as total FROM pengaduan";
    $frekuensi_perbulan = "SELECT COUNT(*) as total, MONTH(tanggal_dibuat) as bulan FROM pengaduan GROUP BY MONTH(tanggal_dibuat)";
    $frekuensi_pengaduan = "SELECT COUNT(*) as total, nama as kategori FROM pengaduan JOIN kategori_layanan ON pengaduan.kategori_layanan_id = kategori_layanan.id GROUP BY kategori_layanan.id";
    $frekuensi_perstatus = "SELECT COUNT(*) as total, status_pengaduan as status FROM pengaduan GROUP BY status_pengaduan";

    $data = [
      'total_pengaduan' => $conn->query($total_pengaduan)->fetch_assoc(),
      'frekuensi_perbulan' => $conn->query($frekuensi_perbulan)->fetch_all(MYSQLI_ASSOC),
      'frekuensi_pengaduan' => $conn->query($frekuensi_pengaduan)->fetch_all(MYSQLI_ASSOC),
      'frekuensi_perstatus' => $conn->query($frekuensi_perstatus)->fetch_all(MYSQLI_ASSOC),
    ];

    $data = json_encode($data);
    ?>;

    let data = <?php echo $data; ?>;

    // Total Pengaduan Chart
    new ApexCharts(document.querySelector("#kategori-1"), {
      chart: {
        type: 'donut',
      },
      series: [data.total_pengaduan.total],
      labels: ['Total Pengaduan'],
    }).render();

    // Frekuensi Pengaduan Perbulan Chart
    new ApexCharts(document.querySelector("#frekuensi-perbulan"), {
      chart: {
        type: 'line',
      },
      series: [{
        name: 'Frekuensi Pengaduan',
        data: data.frekuensi_perbulan.map(item => item.total),
      }],
      xaxis: {
        categories: data.frekuensi_perbulan.map(item => `Bulan ${item.bulan}`),
      },
    }).render();

    // Frekuensi Pengaduan Perkategori Chart
    new ApexCharts(document.querySelector("#frekuensi-pengaduan"), {
      chart: {
        type: 'bar',
      },
      series: [{
        name: 'Frekuensi Pengaduan',
        data: data.frekuensi_pengaduan.map(item => item.total),
      }],
      xaxis: {
        categories: data.frekuensi_pengaduan.map(item => item.kategori),
      },
    }).render();

    // Frekuensi Pengaduan Perstatus Chart
    new ApexCharts(document.querySelector("#frekuensi-perstatus"), {
      chart: {
        type: 'donut',
      },
      series: data.frekuensi_perstatus.map(item => item.total),
      labels: data.frekuensi_perstatus.map(item => item.status),
    }).render();
  </script>
</body>
</html>
