<header id="page-topbar">
  <div class="navbar-header">
    <div class="d-flex">
      <!-- LOGO -->
      <div class="navbar-brand-box">
        <a href="/pengaduan/admin/index.php" class="logo logo-light">
          <span class="logo-sm">
            <img src="/pengaduan/views/assets/img/logo.png" alt="" height="25">
          </span>
          <span class="logo-lg">
            <div class="d-flex align-items-center mt-2">
              <img src="/pengaduan/views/assets/img/logo.png" alt="" height="44">
              <div class="text-start">
                <h6 class="text-white mb-0 text-uppercase" style="font-size: 10px;">Dinas Pendidikan  & Kebudayaan</h6>
                <h5 class="text-white mb-0 text-uppercase" style="font-size: 10px;">Kabupaten Pamekasan</h5>
              </div>
            </div>
          </span>
        </a>
      </div>

      <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
        <i class="mdi mdi-menu"></i>
      </button>
    </div>

    <div class="d-flex">
      <div class="dropdown d-inline-block bg-light ms-2">
        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="rounded-circle avatar-sm" src="<?= $_SESSION['user']['thumbnail']; ?>" alt="Header Avatar" style="border: 3px solid white;">
          <span class="d-none d-lg-inline-block font-size-16 ms-3">
            <?= $_SESSION['user']['nama_lengkap']; ?>
          </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="/pengaduan/index.php">
            <i class="ti-home font-size-16 align-middle me-1 text-muted"></i>
            <span class="align-middle">Website Utama</span>
          </a>
        </div>
      </div>
      <div class="dropdown d-inline-block">
        <button type="button" class="btn header-item noti-icon waves-effect" onclick="window.location.href = '/pengaduan/controller/logout.php'">
          <i class="mdi mdi-power"></i>
        </button>
      </div>
    </div>
  </div>
</header>