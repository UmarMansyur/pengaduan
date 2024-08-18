<?php
$jumlah_soal = $kuisioner['jumlah_soal'];
$jumlah_jawaban = $kuisioner['jumlah_jawaban'];
$jumlah_soalDB = $conn->query("SELECT COUNT(*) as jumlah FROM soal WHERE kuisioner_id = $kuisioner[id]")->fetch_assoc()['jumlah'];
?>
<div class="row align-items-center">
  <div class="col-md-8">
    <h6 class="page-title">Kuisioner</h6>
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item"><a href="#">Administrator</a></li>
      <li class="breadcrumb-item active" aria-current="page">Kuisioner</li>
    </ol>
  </div>
  <div class="col-md-4">
    <?php

    if ($jumlah_soalDB < $jumlah_soal):
    ?>
      <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#soalModal" onclick="$('#soalId').val(''); $('#soal').val(''); <?php for ($i = 1; $i <= $jumlah_jawaban; $i++): ?>$('#jawaban<?= $i ?>').val(''); $('#jawabanId<?= $i ?>').val(''); $('#bobot<?= $i ?>').val(''); $('#bobotId<?= $i ?>').val('');<?php endfor; ?>">
        <i class="bx bx-plus"></i> Tambah Soal
      </button>
    <?php endif; ?>
  </div>
  <div class="col-md-12">
    <div class="modal fade" id="soalModal" tabindex="-1" aria-labelledby="kuisionerLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="kuisionerLabel">Tambah/Ubah Kuisioner</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="post" action="/pengaduan/controller/kuisioner-detail.php?action=save" id="kuisionerForm">
            <div class="modal-body">
              <input type="hidden" id="soalId" name="soalId" value="">
              <input type="hidden" id="jumlah_jawaban" name="jumlah_jawaban" value="<?= $jumlah_jawaban ?>">
              <div class="row">
                <div class="col-12">
                  <input type="hidden" id="kuisionerId" name="kuisionerId" value="<?= $_GET['id'] ?>">
                  <div class="mb-3">
                    <label for="soal" class="form-label">Soal:</label>
                    <textarea class="form-control" id="soal" name="soal" rows="5" required></textarea>
                  </div>
                </div>
                <?php
                for ($i = 1; $i <= $jumlah_jawaban; $i++) {
                ?>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="jawaban<?= $i ?>" class="form-label">Jawaban <?= $i ?>:</label>
                      <input type="text" class="form-control" id="jawaban<?= $i ?>" name="jawaban<?= $i ?>" required>
                      <input type="hidden" id="jawabanId<?= $i ?>" name="jawabanId<?= $i ?>" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="bobot<?= $i ?>" class="form-label">Bobot <?= $i ?>:</label>
                      <input type="text" class="form-control" id="bobot<?= $i ?>" name="bobot<?= $i ?>" required>
                      <input type="hidden" id="bobotId<?= $i ?>" name="bobotId<?= $i ?>" value="">
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="bx bx-x"></i> Batal
              </button>
              <button type="submit" class="btn btn-primary">
                <i class="bx bx-save"></i> Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row my-3">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <h4 class="card-title">Detail Kuisioner</h4>
            <p class="card-title-desc">Halaman ini digunakan untuk melihat detail kuisioner.</p>
          </div>
          <div class="col-md-6">
            <a href="/pengaduan/admin?page=kuisioner" class="btn btn-secondary float-end">
              <i class="bx bx-arrow-back"></i> Kembali
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            Nama Kuisioner: <?= $kuisioner['nama'] ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            Jumlah Soal: <?= $jumlah_soal ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            Jumlah Jawaban/Persoal: <?= $jumlah_jawaban ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-striped table-hover" id="dtTable">
              <thead>
                <tr>
                  <th class="text-center" style="width: 50px;">No</th>
                  <th class="text-start">Soal</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody class="align-middle">
                <?php
                $soalQuery = $conn->prepare("SELECT * FROM soal WHERE kuisioner_id = ?");
                $soalQuery->bind_param('i', $kuisioner['id']);
                $soalQuery->execute();
                $soalResult = $soalQuery->get_result();
                $soalData = $soalResult->fetch_all(MYSQLI_ASSOC);

                $jawaban = [];
                $sql = "SELECT * FROM jawaban WHERE soal_id IN (" . implode(",", array_fill(0, count($soalData), "?")) . ")";
                $jawabanQuery = $conn->prepare($sql);
                $jawabanQuery->bind_param(str_repeat('i', count($soalData)), ...array_column($soalData, 'id'));
                $jawabanQuery->execute();
                $jawabanResult = $jawabanQuery->get_result();
                $jawabanData = $jawabanResult->fetch_all(MYSQLI_ASSOC);
                $jawabanQuery->close();

                $result = [];
                foreach ($jawabanData as $jawaban) {
                  $soal_id = $jawaban['soal_id'];
                  if (!isset($result[$soal_id])) {
                    $result[$soal_id] = $soalData[array_search($soal_id, array_column($soalData, 'id'))];
                    $result[$soal_id]['jawaban'] = [];
                  }
                  $result[$soal_id]['jawaban'][] = $jawaban;
                }
                $soalQuery->close();
                ?>
                <?php
                foreach ($result as $index => $soal):
                ?>
                  <tr>
                    <td class="text-center"><?= $index ?></td>
                    <td>
                      <h6>
                        <?= $soal['soal'] ?>
                        <ul>
                          <?php
                          foreach ($soal['jawaban'] as $jawaban):
                          ?>
                            <li><?= $jawaban['jawaban'] ?> (<?= $jawaban['bobot'] ?>)</li>
                          <?php
                          endforeach;
                          ?>
                        </ul>
                      </h6>
                    </td>
                    <td class="text-center">
                      <?php
                      $soalDataJson = json_encode($soal);
                      ?>
                      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#soalModal" onclick='editSoal(<?= json_encode($soal) ?>)'>
                        <i class="bx bx-pencil"></i> Ubah
                      </button>
                      <a class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" href="/pengaduan/controller/kuisioner-detail.php?action=delete&id=<?= $kuisioner['id'] ?>&soalId=<?= $soal['id'] ?>">
                        <i class="bx bx-trash"></i> Hapus
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#dtTable').DataTable();
  });

  function editSoal(soal) {
    $('#soalId').val(soal.id);
    $('#soal').val(soal.soal);
    <?php for ($i = 1; $i <= $jumlah_jawaban; $i++): ?>
      $('#jawaban<?= $i ?>').val(soal.jawaban[<?= $i - 1 ?>]?.jawaban || '');
      $('#jawabanId<?= $i ?>').val(soal.jawaban[<?= $i - 1 ?>]?.id || '');
      $('#bobot<?= $i ?>').val(soal.jawaban[<?= $i - 1 ?>]?.bobot || '');
      $('#bobotId<?= $i ?>').val(soal.jawaban[<?= $i - 1 ?>]?.id || '');
    <?php endfor; ?>
  }

  function submitSoal() {
    var formData = $('#kuisionerForm').serialize();
    console.log(formData);
    //
  }
</script>