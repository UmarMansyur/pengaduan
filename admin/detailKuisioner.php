<?php
  $jumlah_soal = $kuisioner['jumlah_soal'];
  $jumlah_jawaban = $kuisioner['jumlah_jawaban'];
  ?>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Detail Kuisioner</h4>
          <p class="card-title-desc">Halaman ini digunakan untuk melihat detail kuisioner.</p>
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
                    <th class="text-center">No</th>
                    <th class="text-start">Soal</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#dtTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url": "/pengaduan/controller/kuisioner-detail.php?action=detail&id=<?= $kuisioner['id'] ?>",
          "type": "POST",
          "data": {
            "id": <?= $kuisioner['id'] ?>
          }
        },
        "columns": [{
            "data": "no",
            "className": "text-center"
          },
          {
            "data": "soal",
            "className": "text-start"
          },
          {
            "data": "aksi",
            "className": "text-center"
          }
        ]
      });
    });
  </script>
