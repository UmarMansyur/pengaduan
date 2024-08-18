<div class="vertical-menu">
  <div data-simplebar class="h-100">
    <!--- Sidemenu -->
    <div id="sidebar-menu">
      <!-- Left Menu Start -->
      <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title">Main</li>
        <li class="<?= @($_GET['page']) == 'dashboard' ? 'mm-active' : ''; ?>">
          <a href="/admin?page=dashboard" class="waves-effect">
            <i class="ti-home"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="menu-title">Data</li>
        <li class="<?= @($_GET['page']) == 'pending' ? 'mm-active' : ''; ?>">
          <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
            <i class="ti-notepad"></i>
            <span>Pengaduan</span>
          </a>
          <ul class="sub-menu mm-collapse <?= @($_GET['page']) == 'pending'  || @($_GET['page']) == 'diproses' || @($_GET['page']) == 'selesai' || @($_GET['page']) == 'ditolak' ? 'mm-show' : ''; ?>" aria-expanded="false">
            <li>
              <a href="/admin?page=pending" class="<?= @($_GET['page']) == 'pending' ? 'mm-active' : ''; ?>">
                Pending
              </a>
            </li>
            <li>
              <a href="/admin?page=diproses" class="<?= @($_GET['page']) == 'diproses' ? 'mm-active' : ''; ?>">
                Diproses
              </a>
            </li>
            <li>
              <a href="/admin?page=selesai" class="<?= @($_GET['page']) == 'selesai' ? 'mm-active' : ''; ?>">
                Selesai
              </a>
            </li>
            <li>
              <a href="/admin?page=ditolak" class="<?= @($_GET['page']) == 'ditolak' ? 'mm-active' : ''; ?>">
                Ditolak
              </a>
            </li>
          </ul>
        </li>
        <li>
          <a href="index.php?page=statistik" class="waves-effect">
            <i class="ti-pie-chart"></i>
            <span>Statistik Pengaduan</span>
          </a>
        </li>
        <li>
          <a href="index.php?page=statistik" class="waves-effect">
            <i class="ti-bar-chart"></i>
            <span>Statistik Kuisioner</span>
          </a>
        </li>
        <li>
          <a href="index.php?page=statistik" class="waves-effect">
            <i class="ti-comment-alt"></i>
            <span>Kritik dan Saran</span>
          </a>
        </li>
        <li class="menu-title">Pengaturan</li>
        <li class="<?= @($_GET['page']) == 'kategori-layanan' ? 'mm-active' : ''; ?>">
          <a href="javascript: void(0);" class="has-arrow waves-effect" aria-expanded="false">
            <i class="ti-settings"></i>
            <span>Pengaturan</span>
          </a>
          <ul class="sub-menu mm-collapse <?= @($_GET['page']) == 'kategori-layanan'  || @($_GET['page']) == 'kuisioner' || @($_GET['page']) == 'tentang-kami' ? 'mm-show' : ''; ?>" aria-expanded="false" style="height: 0px;">
            <li class="<?= @($_GET['page']) == 'kategori-layanan' ? 'mm-active' : ''; ?>">
              <a href="/admin?page=kategori-layanan">Kategori Tujuan Layanan</a>
            </li>
            <li class="<?= @($_GET['page']) == 'kuisioner' ? 'mm-active' : ''; ?>">
              <a href="/admin?page=kuisioner">Kuisioner</a>
            </li>
            <li class="<?= @($_GET['page']) == 'tentang-kami' ? 'mm-active' : ''; ?>">
              <a href="/admin?page=tentang-kami">Tentang Lapor</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- Sidebar -->
  </div>
</div>