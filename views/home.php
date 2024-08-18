<main class="flex-grow-1 w-100">
  <section id="bg-home" style="background-image: url(&quot;./views/assets/img/cover.svg&quot;);">
    <div class="container d-flex flex-column justify-content-center align-items-center" style="height: 50vh;">
      <div class="row justify-content-between align-items-center pt-3">
        <div class="col-md-5 justify-content-between">
          <h1 class="fw-bold text-brand text-uppercase display-5 mb-3">Layanan Pengaduan Masyarakat</h1>
          <p style="font-size: 1.2rem;" class="text-muted mb-3">
            Keluhan anda merupakan upaya penting dalam membangun kota yang lebih baik. Laporkan keluhan anda
            sekarang
            dan kami akan segera menanganinya.
          </p>
          <div class="d-flex align-items-center my-3">
            <a href="?page=lapor" class="btn btn-lg p-3 btn-brand px-4 text-uppercase rounded-pill fw-semibold fs-18">Lapor Sekarang!</a>
          </div>
        </div>
        <div class="col-md-7 text-end d-none d-md-block">
          <img src="./views/assets/img/image.png" alt="report" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

  <section class="mb-5 pb-5">
    <div class="container my-0">
      <h2 class="text-center mb-5 text-uppercase fw-bold text-brand">
        Proses Pengaduan
      </h2>
      <div class="row justify-content-center mb-0">
        <div class="col-md-2 bs-wizard-step">
          <span class="bg-danger align-items-center d-flex justify-content-center mx-auto"
            style="width: 50px; height: 50px; border-radius: 50%;">
            <i class="bx bx-edit text-white fs-24"></i>
          </span>
          <h6 class="text-dark mb-0 fw-bold my-3 text-center">Tulis Laporan</h6>
          <p class="text-muted mt-3 text-center fs-14 mb-0">Tulis laporan keluhan anda dengan jelas dan lengkap</p>
        </div>
        <div class="col-md-2 bs-wizard-step">
          <span class="bg-brand align-items-center d-flex justify-content-center mx-auto"
            style="width: 50px; height: 50px; border-radius: 50%;">
            <i class="bx bx-share text-white fs-24"></i>
          </span>
          <h6 class="text-dark mb-0 fw-bold my-3 text-center">Proses Verifikasi</h6>
          <p class="text-muted mt-3 text-center fs-14 mb-0">Laporan anda akan diverifikasi oleh pihak terkait dalam
            waktu 3x24 jam</p>
        </div>
        <div class="col-md-2 bs-wizard-step">
          <span class="bg-brand align-items-center d-flex justify-content-center mx-auto"
            style="width: 50px; height: 50px; border-radius: 50%;">
            <i class="bx bx-chat text-white fs-24"></i>
          </span>
          <h6 class="text-dark mb-0 fw-bold my-3 text-center">Proses Tindak Lanjut</h6>
          <p class="text-muted mt-3 text-center fs-14 mb-0">Dalam waktu 5x24 jam laporan anda akan ditindak lanjuti
          </p>
        </div>
        <div class="col-md-2 bs-wizard-step">
          <span class="bg-brand align-items-center d-flex justify-content-center mx-auto"
            style="width: 50px; height: 50px; border-radius: 50%;">
            <i class="bx bx-conversation text-white fs-24"></i>
          </span>
          <h6 class="text-dark mb-0 fw-bold my-3 text-center">Beri Tanggapan</h6>
          <p class="text-muted mt-3 text-center fs-14 mb-0">Anda dapat melihat tanggapan dari instansi terkait</p>
        </div>
        <div class="col-md-2 bs-wizard-step">
          <span class="bg-brand align-items-center d-flex justify-content-center mx-auto"
            style="width: 50px; height: 50px; border-radius: 50%;">
            <i class="bx bx-check-double text-white fs-24"></i>
          </span>
          <h6 class="text-dark mb-0 fw-bold my-3 text-center">Selesai</h6>
          <p class="text-muted mt-3 text-center fs-14 mb-0">Laporan anda telah selesai ditangani</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center mt-3">
          <a href="/pengaduan/index.php?page=about-us" class="btn btn-outline-brand px-4 rounded-1">
            Pelajari Lebih Lanjut
          </a>
        </div>
      </div>
    </div>
  </section>
  <?php
  $pengaduang = $conn->query("SELECT COUNT(*) as total FROM pengaduan")->fetch_assoc();
  if ($pengaduang['total'] > 0) :
  ?>
    <section class="bg-brand text-white py-5">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h3 class="text-center fs-48 text-uppercase mb-3">
              Jumlah Laporan Sekarang
            </h3>
            <h1 class="text-center display-3 fw-bold text-uppercase">
              <?= $pengaduang['total'] ?>
            </h1>
          </div>
        </div>
      </div>
    </section>


    <section>
      <div class="container">
        <div class="row py-5">
          <div class="col-12">
            <h3 class="text-center text-brand fs-28 fw-bold text-uppercase my-4">
              Kategori Laporan
            </h3>
          </div>
        </div>
        <div class="row mb-5 pb-5">
          <?php
          $sql = "SELECT COUNT(*) as total, nama FROM pengaduan JOIN kategori_layanan ON pengaduan.kategori_layanan_id = kategori_layanan.id GROUP BY nama ORDER BY total DESC LIMIT 4";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) :
          ?>
            <div class="col-md-3">
              <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                  <h3 class="fs-24 fw-bold text-uppercase"><?= $row['nama'] ?></h3>
                  <h1 class="fs-28 fw-bold text-uppercase"><?= $row['total'] ?></h1>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <section class="bg-white">
    <div class="container" id="saran">
      <form action="/pengaduan/controller/kritik.php" method="post">
        <div class="container">
          <div class="row">
            <div class="row">
              <div class="col-lg-6 py-5 my-auto">
                <h1 class="fw-bold">Kritik Dan Saran</h1>
              </div>
              <div class="col-lg-6 py-5 p-lg-6">
                <div class="col-12 mb-3">
                  <label for="nama" class="form-label">Nama</label>
                  <input type="text" class="form-control" name="nama" placeholder="Ketik nama anda" required>
                </div>
                <div class="col-12 mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" placeholder="Ketik email anda" required>
                </div>
                <div class="col-12 mb-3">
                  <label for="deskripsi" class="form-label ">Sampaikan Saran &amp; Kritik Anda</label>
                  <textarea class="form-control" name="deskripsi" rows="5" required
                    placeholder="Ketikkan kritik anda ..."></textarea>
                </div>
                <div class="d-grid gap-2 mb-3 pb-5">
                  <button class="btn btn-brand" name="submit" type="submit">KIRIM</button>
                </div>
              </div>


            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
  <section class="bg-light py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <h3 class="text-center text-brand fw-bold text-uppercase my-4 display-5">
            Pertanyaan Umum (FAQ)
          </h3>
          <div class="accordion mt-5" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Bagaimana saya bisa memantau status pengaduan saya?
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  Setelah pengaduan diajukan, pengguna dapat memantau status pengaduan mereka melalui dashboard
                  pengaduan di akun mereka. Setiap perubahan status akan diberitahukan melalui email atau notifikasi
                  di
                  platform
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Apakah pengaduan saya akan ditanggapi?
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  Ya, setiap pengaduan yang diajukan akan diperiksa oleh tim kami. Pengguna akan menerima notifikasi
                  tentang status pengaduan mereka dan akan mendapatkan tanggapan resmi setelah pengaduan diproses.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Bisakah saya menarik atau mengubah pengaduan setelah diajukan?
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  Pengaduan tidak dapat diubah, namun pengguna dapat menarik pengaduan mereka sebelum diproses oleh
                  tim
                  kami. Setelah pengaduan diproses, pengguna tidak dapat menarik pengaduan mereka.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  Apakah pengaduan saya bersifat rahasia?
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  Ya, semua pengaduan yang diajukan bersifat rahasia. Kami memastikan bahwa informasi pengguna dan
                  isi
                  pengaduan dilindungi sesuai dengan kebijakan privasi kami.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                  Bagaimana jika pengaduan saya tidak mendapatkan solusi yang memuaskan?
                </button>
              </h2>
              <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  Jika anda merasa bahwa pengaduan anda tidak ditanggapi dengan baik, anda dapat menghubungi kami
                  melalui email atau telepon yang tertera di website ini. Kami akan segera menindaklanjuti pengaduan
                  anda.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
  document.title = "Beranda - Lapor";
</script>