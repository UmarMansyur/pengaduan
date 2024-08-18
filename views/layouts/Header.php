<nav class="navbar navbar-expand-lg py-3 bg-white shadow-sm flex-shrink-0 d-flex w-100 justify-content-between align-items-center position-fixed top-0 start-0 end-0 z-index-1000 d-none d-sm-block">
  <div class="container">
    <div class="d-flex align-items-center w-100">
      <a class="navbar-brand d-flex flex-row align-items-center" href="/pengaduan/index.php">
        <img src="./views/assets/img/logo.png" alt="logo" class="logo" width="50">
        <div class="d-flex flex-column">
          <h5 class="fw-bold mb-0">Dinas Pendidikan</h5>
          <h6 class="mb-0">Kabupaten Pamekasan</h6>
        </div>

      </a>
      <div>
        <a href="/pengaduan/index.php" class="text-decoration-none text-muted ms-5 <?= empty($_GET['page']) || $_GET['page'] == 'home' ? 'active' : '' ?>">
          Beranda
        </a>
        <a href="?page=lapor" class="text-decoration-none text-muted ms-5 <?= isset($_GET['page']) && $_GET['page'] == 'lapor' ? 'active' : '' ?>">
          Lapor
        </a>
        <a href="?page=monitoring" class="text-decoration-none text-muted ms-5 <?= isset($_GET['page']) && $_GET['page'] == 'monitoring' ? 'active' : '' ?>">
          Monitoring Laporan
        </a>
        <a href="?page=about-us" class="text-decoration-none text-muted ms-5 <?= isset($_GET['page']) && $_GET['page'] == 'about-us' ? 'active' : '' ?>">
          Tentang Lapor
        </a>
      </div>
      <div class="d-flex align-items-center ms-auto">
        <?php if (isset($_SESSION['user'])) : ?>
         <a href="/pengaduan/admin/index.php" class="btn px-3 py-2 btn-brand text-white">
          Administrasi Situs
        </a>
        <?php else: ?>    
        <button type="button" class="btn px-3 py-2 btn-brand text-white" data-bs-toggle="modal" data-bs-target="#login-modal">
          <i class="bx bx-user align-middle"></i> <span class="align-middle">Login</span>
        </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="login-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="login-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title d-flex align-items-center fs-5" id="login-modalLabel">
          <img src="./views/assets/img/logo.png" alt="logo" class="logo" width="50">
          <div>
            <h5 class="fw-bold mb-0 fs-14">Dinas Pendidikan</h5>
            <h6 class=" mb-0 fs-14">Kabupaten Pamekasan</h6>

          </div>
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/pengaduan/controller/login.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label fw-bold">Username:</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Ketik username anda" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Ketik password anda" required>
          </div>
          <div class="mb-3 d-flex justify-content-between gap-2">
            <button type="reset" class="btn btn-sm px-3 w-50 py-2 btn-light">
              <i class="bx bx-revision fs-14 align-middle"></i> <span class="align-middle">Reset</span>
            </button>
            <button type="submit" name="login" class="btn btn-sm px-3 w-50 py-2 btn-brand">
              <i class="bx bx-send fs-14 align-middle"></i> <span class="align-middle">Login</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>