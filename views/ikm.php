<?php
$data = "SELECT * FROM kuisioner WHERE status = true";
$data = $conn->query($data);
$data = $data->fetch_assoc();

?>
<main class="flex-grow-1 w-100">
  <section class="py-1" style="background-image: url(&quot;./views/assets/img/cover.svg&quot;); background-size: auto;">
    <div class="container">
      <?php
      // jika data tidak ditemukan
      if (!$data):
      ?>
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card shadow-sm">
              <div class="card-body">
                <h4 class="text-muted text-center py-4">
                  <p class="text-brand mb-0 fs-18">#Index Kepuasan Masyarakat</p>
                  Administrator belum menambahkan kuisioner untuk saat ini!
                </h4>
              </div>
            </div>
          </div>
        </div>
      <?php else:
      ?>
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card shadow-sm">
              <div class="card-body p-4">
                <h4 class="text-muted text-center py-4">
                  <p class="text-brand mb-0 fs-18">#Index Kepuasan Masyarakat</p>
                  <?= $data['nama']; ?>
                </h4>
                <form action="/pengaduan/controller/ikm.php" method="POST">
                  <h5 class="mb-3 text-uppercase">Identitas Responden: </h5>
                  <p class="text-muted">
                    <i class="bx bx-info-circle"></i> Isi data diri anda dengan benar dan jujur.
                  </p>
                  <div class="row">
                    <div class="col-md-6 mb-2">
                      <label for="responden" class="form-label"><sup class="text-danger">*</sup>Nama Responden: </label>
                      <input type="text" class="form-control" id="responden" name="responden" required autofocus placeholder="Ketik nama anda">
                      <input type="hidden" name="kuisioner_id" value="<?= $data['id']; ?>">
                    </div>
                    <div class="col-md-6">
                      <label for="umur" class="form-label"><sup class="text-danger">*</sup>Usia: </label>
                      <input type="text" class="form-control" id="umur" name="umur" required placeholder="Ketik usia anda" inputmode="numeric" pattern="[0-9]*" maxlength="2" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                    </div>
                    <div class="col-md-4 mb-2">
                      <label for="jenis_kelamin" class="form-label"><sup class="text-danger">*</sup>Jenis Kelamin: </label>
                      <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="" disabled>Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                      </select>
                    </div>
                    <div class="col-md-4 mb-2">
                      <label for="pendidikan" class="form-label"><sup class="text-danger">*</sup>Pendidikan: </label>
                      <select class="form-select" id="pendidikan" name="pendidikan" required>
                        <option value="" disabled>Pilih Pendidikan</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                      </select>
                    </div>
                    <div class="col-md-4 mb-2">
                      <label for="pekerjaan" class="form-label"><sup class="text-danger">*</sup>Pekerjaan: </label>
                      <select class="form-select" id="pekerjaan" name="pekerjaan" required>
                        <option value="" disabled>Pilih Jenis Pekerjaan</option>
                        <option value="PNS">PNS</option>
                        <option value="TNI/POLRI">TNI/POLRI</option>
                        <option value="SWASTA">Swasta</option>
                        <option value="WIRAUSAHA">Wirausaha</option>
                        <option value="LAINNYA">Lainnya</option>
                      </select>
                    </div>
                  </div>
                  <h5 class="mt-3 text-uppercase">Pertanyaan: </h5>
                  <p class="text-muted">
                    <i class="bx bx-info-circle"></i> Berikan penilaian anda dengan memilih salah satu jawaban yang tersedia pada setiap pertanyaan berikut ini:
                  </p>
                  <?php
                  $soal = "SELECT * FROM soal WHERE kuisioner_id = $data[id]";
                  $soal = $conn->query($soal);
                  $soal = $soal->fetch_all(MYSQLI_ASSOC);
                  $jawaban = "SELECT * FROM jawaban WHERE soal_id IN (SELECT id FROM soal WHERE kuisioner_id = $data[id])";
                  $jawaban = $conn->query($jawaban);
                  $jawaban = $jawaban->fetch_all(MYSQLI_ASSOC);
                  foreach ($soal as $key => $value):
                  ?>
                    <h6 class="text-muted mb-3"><?= $key + 1 ?>. <?= $value['soal']; ?></h6>
                    <div class="row">
                      <?php
                      $item = [];
                      foreach ($jawaban as $k => $v) {
                        if ($v['soal_id'] == $value['id']) {
                          $item[] = $v;
                        }
                      }
                      foreach ($item as $k => $v):
                      ?>
                        <div class="col-md-3 mb-3">

                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jawaban[<?= $value['id']; ?>]" id="jawaban<?= $value['id']; ?><?= $v['id']; ?>" value="<?= $v['id']; ?>">
                            <label class="form-check-label" for="jawaban<?= $value['id']; ?><?= $v['id']; ?>"><?= $v['jawaban']; ?>(<?= $v['bobot']; ?>)</label>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  <?php endforeach; ?>
                  <div class="text-end">
                    <button type="submit" class="btn btn-brand mt-3">
                      <i class="bx bx-send"></i> Kirim
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      <?php endif; ?>
    </div>
  </section>
</main>

<script>
  document.title = 'Monitoring Pengaduan | Dinas Pendidikan Kota Pamekasan';
</script>