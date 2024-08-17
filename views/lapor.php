<main class="flex-grow-1 w-100">
  <section class="py-1" style="background-image: url(&quot;./views/assets/img/cover.svg&quot;); background-size: auto;">
    <div class="container d-flex flex-column justify-content-center align-items-center" style="height: 80vh;">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow-sm">
            <div class="card-body p-4">
              <form action="./controller/lapor.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-12 mb-3  px-5">
                    <h5 class="text-center fw-bold text-uppercase text-brand mb-0 py-2">Laporkan Keluhan Anda</h5>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="title" class="form-label fw-bold"><sup class="text-danger">*</sup>Judul
                      Laporan: </label>
                    <input type="text" class="form-control" name="judul_laporan" placeholder="Ketik nama terlapor">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="nama-terlapor" class="form-label fw-bold"><sup class="text-danger">*</sup>Nama
                      Terlapor: </label>
                    <input type="text" class="form-control" name="nama_terlapor" placeholder="Ketik nama terlapor">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="alamat" class="form-label fw-bold"><sup class="text-danger">*</sup>Alamat: </label>
                    <textarea type="text" class="form-control" name="alamat" placeholder="Ketik alamat terlapor"
                      rows="5"></textarea>
                  </div>
                  <div class="col-12 mb-3">
                    <label for="nama-terlapor" class="form-label fw-bold"><sup class="text-danger">*</sup>Kategori
                      Tujuan Layanan: </label>
                    <select class="form-select" name="kategori">
                      <?php
                        $kategori = $conn->query("SELECT * FROM kategori_layanan");
                        foreach ($kategori as $item) :
                      ?>
                      <option value="<?= $item['id'] ?>">
                        <?= $item['nama'] ?>
                      </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="deskripsi" class="form-label fw-bold"><sup class="text-danger">*</sup>Deskripsi
                      Pengaduan: </label>
                    <textarea type="text" class="form-control" name="deskripsi" placeholder="Deskripsi Pengaduan"
                      rows="5"></textarea>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="lampiran" class="form-label fw-bold">Lampiran: </label>
                    <input type="file" class="form-control" name="lampiran[]" multiple>
                  </div>
                  <div class="col-md-12 mb-3 text-end">
                    <button class="btn btn-brand px-4" type="submit" name="simpan">
                      <i class="bx bx-send"></i> Kirim
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>