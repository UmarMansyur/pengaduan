<div class="row align-items-center">
  <div class="col-md-12">
    <h6 class="page-title">Dashboard</h6>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="alert alert-warning" role="alert">
      <strong>Selamat datang !</strong> Semoga harimu menyenangkan.
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xl-4 col-md-4">
    <div class="card mini-stat text-dark">
      <div class="card-body rounded-circle">
        <div class="mb-4">
          <div class="float-start mini-stat-img me-4">
            <i class="display-5 bx bx-file"></i>
          </div>
          <h5 class="font-size-16 text-uppercase text-dark">Total Pengaduan</h5>
          <h4 class="fw-medium font-size-24">
            <?php
            $total_pengaduan = $conn->query("SELECT COUNT(*) as total FROM pengaduan");
            $total_pengaduan = $total_pengaduan->fetch_assoc();
            echo $total_pengaduan['total'];
            ?>
          </h4>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-md-4">
    <div class="card mini-stat text-dark">
      <div class="card-body rounded-circle">
        <div class="mb-4">
          <div class="float-start mini-stat-img me-4">
            <i class="display-5 bx bx-info-circle"></i>
          </div>
          <h5 class="font-size-16 text-uppercase text-dark">Pengaduan Diproses</h5>
          <h4 class="fw-medium font-size-24">
            <?php
            $diproses = $conn->query("SELECT COUNT(*) as total FROM pengaduan WHERE status_pengaduan = 'Diproses'");
            $diproses = $diproses->fetch_assoc();
            echo $diproses['total'];
            ?>
          </h4>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-md-4">
    <div class="card mini-stat text-dark">
      <div class="card-body rounded-circle">
        <div class="mb-4">
          <div class="float-start mini-stat-img me-4">
            <i class="display-5 bx bx-check-circle"></i>
          </div>
          <h5 class="font-size-16 text-uppercase text-dark">Pengaduan Selesai</h5>
          <h4 class="fw-medium font-size-24">
            <?php
            $selesai = $conn->query("SELECT COUNT(*) as total FROM pengaduan WHERE status_pengaduan = 'Selesai'");
            $selesai = $selesai->fetch_assoc();
            echo $selesai['total'];
            ?>
          </h4>
        </div>
      </div>
    </div>
  </div>
</div>