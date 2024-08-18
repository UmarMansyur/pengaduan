<main class="flex-grow-1 w-100">
  <section class="py-1" style="background-image: url(&quot;./views/assets/img/cover.svg&quot;); background-size: auto;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <h4 class="text-muted text-center py-4">
                <p class="text-brand mb-0 fs-18">#Tracking Your Report</p>
                Tracking Laporan
              </h4>
              <div class="row justify-content-center mt-3">
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Masukkan kode unik laporan" name="kode_unik" id="kode_unik" required autocomplete="off" autofocus onchange="check()">
                    <button class="btn btn-brand rounded-end-2" type="button" name="cek" onclick="check()">
                      <i class="bx bx-search-alt fs-18 align-middle"></i> <span class="align-middle"></span>
                    </button>
                    <script>
                      async function check() {
                        const value = document.getElementById('kode_unik').value;
                        const response = await fetch('/pengaduan/controller/ceklaporan.php?q=' + `${encodeURIComponent(value)}`);
                        const data = await response.json();
                        if (data.error) {
                          document.getElementById('id-search').innerHTML = `
                          <div class="text-center">
                          <p class="text-muted fs-18 my-3 fw-bold
                          ">${data.error}</p>
                                  <img src="./views/assets/img/track.jpg" alt="monitoring" class="img-fluid" style="width: 400px;">
                                </div>

                          `;
                          return;
                        }
                        if (data.data.length === 0) {
                          document.getElementById('id-search').innerHTML = `
                                <div class="text-center">
                      <img src="./views/assets/img/track.jpg" alt="monitoring" class="img-fluid" style="width: 400px;">
                      <p class="text-muted">Masukkan kode unik laporan untuk melihat detail laporan</p>
                    </div>
                            `;
                          return;
                        }
                        const html = `
                            <div class="col-md-12">
                              <h4 class="fs-18 my-3">Identitas Pelapor: </h4>
                              <h6 class="fs-14 mb-1 fw-bold">Nama Pelapor:</h6>
                              <p class="mb-1">${data.data.nama_pelapor}</p>
                              <h6 class="fs-14 mb-1 fw-bold">NIK:</h6>
                              <p class="mb-1">${data.data.nik}</p>
                              <h6 class="fs-14 mb-1 fw-bold">Email:</h6>
                              <p class="mb-1">${data.data.email}</p>
                              <h6 class="fs-14 mb-1 fw-bold">No. Hp:</h6>
                              <p class="mb-1">${data.data.phone}</p>
                              <h6 class="fs-14 mb-1 fw-bold">Jenis Kelamin:</h6>
                              <p class="mb-1">${data.data.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}</p>
                              <h6 class="fs-14 mb-1 fw-bold">Alamat Pelapor:</h6>
                              <p class="mb-1">${data.data.alamat_lengkap}</p>
                              <h4 class="fs-18 my-3">Detail Laporan: </h4>
                              <div class="table-responsive">
                                <table class="table table-hover table-stripped table-bordered">
                                  <tbody>
                                    <tr>
                                      <th>Judul</th>
                                      <td>${data.data.judul_laporan}</td>
                                    </tr>
                                    <tr>
                                      <th>Nama Terlapor</th>
                                      <td>${data.data.nama_terlapor}</td>
                                    </tr>
                                    <tr>
                                      <th>Kategori Tujuan Layanan</th>
                                      <td>${data.data.nama_kategori}</td>
                                    </tr>
                                    <tr>
                                      <th>Status Pengaduan</th>
                                      <td>${data.data.status_pengaduan}</td>
                                    </tr>
                                    <tr>
                                      <th>Deskripsi</th>
                                      <td>${data.data.deskripsi}</td>
                                    </tr>
                                    <tr>
                                      <th>Tanggal Dibuat</th>
                                      <td>${new Date(data.data.tanggal_dibuat).toLocaleDateString(
                                        'id-ID', {
                                        weekday: 'long',
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                        hour: 'numeric',
                                        minute: 'numeric'
                                        }
                                        )} WIB </td>
                                    </tr>
                                    ${
                                    data.data.status_pengaduan !== 'Ditolak' ? `<tr>
                                      <th>Tanggal Diproses</th>
                                      <td>${data.data.tanggal_diproses === null ? 'Belum diproses' : new
                                        Date(data.data.tanggal_diproses).toLocaleDateString(
                                        'id-ID', {
                                        weekday: 'long',
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                        hour: 'numeric',
                                        minute: 'numeric'
                                        }
                                        ) + 'WIB'} </td>
                                    </tr>
                                    ${data.data.status_pengaduan !== 'Ditolak' ? `<tr>
                                      <th>Tanggal Selesai</th>
                                      <td>${data.data.tanggal_selesai === null ? 'Belum selesai' : new
                                        Date(data.data.tanggal_selesai).toLocaleDateString(
                                        'id-ID', {
                                        weekday: 'long',
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                        hour: 'numeric',
                                        minute: 'numeric'
                                        }
                                        ) + 'WIB'} </td>
                                    </tr>` : ''}
                                    ` : ''}

                                    ${data.data.status_pengaduan === 'Ditolak' ? `<tr>
                                      <th>Alasan Penolakan</th>
                                      <td>${data.data.alasan_penolakan}</td>
                                    </tr>` : ''}

                                    ${data.lampiran.map((lampiran, index) => {
                                    return `<tr>
                                      <th>Lampiran ${index + 1}</th>
                                      <td><a href="${lampiran.path}" target="_blank" class="text-decoration-none text-brand">
                                          Download Lampiran ${index + 1}
                                        </a></td>
                                    </tr>`
                                    }).join('')}

                                  </tbody>
                                </table>
                              </div>
                            </div>
                          `;
                        document.getElementById('id-search').innerHTML = html;
                      }
                    </script>
                  </div>
                </div>
                <div class="col-md-12">
                  <div id="id-search">
                    <div class="text-center">
                      <img src="./views/assets/img/track.jpg" alt="monitoring" class="img-fluid" style="width: 400px;">
                      <p class="text-muted">Masukkan kode unik laporan untuk melihat detail laporan</p>
                    </div>
                  </div>
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
  document.title = 'Monitoring Pengaduan | Dinas Pendidikan Kota Pamekasan';
</script>