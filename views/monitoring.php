<main class="flex-grow-1 w-100">
  <section class="py-1" style="background-image: url(&quot;./views/assets/img/cover.svg&quot;); background-size: auto;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <h6 class="text-muted text-center">
                Cek status laporan yang telah anda buat. Masukkan kode unik yang diberikan ketika laporan berhasil dibuat.
              </h6>
              <div class="row justify-content-center mt-3">
                <div class="col-md-6">
                  <form action="" method="GET">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" placeholder="Masukkan kode unik laporan" name="kode_unik" id="kode_unik" required>
                      <button class="btn btn-brand" type="button" name="cek" onclick="check()">
                        <i class="bx bx-search-alt fs-18 align-middle"></i> <span class="align-middle"></span>
                      </button>
                      <script>
                        async function check() {
                          const value = document.getElementById('kode_unik').value;
                          const response = await fetch('./controller/ceklaporan.php?q=' + `${encodeURIComponent(value)}`);
                          const data = await response.json();
                          const html = `                <div class="col-md-12">
                  <h6>Nama Pelapor</h6>
                  <h6>Email: </h6>
                  <h6>No. Hp: </h6>
                  <h6>Nik: </h6>
                  <h6>Jenis Kelamin</h6>
                  <div class="table-responsive">
                    <table class="table table-hover table-stipped table-bodered">
                      <thead>
                        <tr>
                          <th>Deskripsi</th>
                          <th>#</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th>Judul</th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Nama Terlapor</th>
                          <th></th>
                        </tr>
                        <tr>
                          <th>Kategori Tujuan Layanan</th>
                          <th></th>
                        </tr>
                        <tr>
                          <th>Status Pengaduan</th>
                          <th></th>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>`
                        }
                      </script>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>