<?php
$isDetail = isset($_GET['id']);
if ($isDetail) {
  $id = $_GET['id'];
  $query = $conn->query("SELECT * FROM kuisioner WHERE id = $id");
  $kuisioner = $query->fetch_assoc();
}
if (empty($isDetail)):
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
      <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#kuisionerModal">
        <i class="bx bx-plus"></i> Tambah Kuisioner
      </button>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Kuisioner</h4>
          <p class="card-title-desc">Halaman ini digunakan untuk mengelola kuisioner.</p>
          <div class="table-responsive">
            <table class="table table-hover" id="dataTable">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th class="text-start">Nama Kuisioner</th>
                  <th>Jumlah Soal</th>
                  <th>Jumlah Jawaban/Persoal</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="kuisionerBody" class="align-middle">
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="kuisionerModal" tabindex="-1" aria-labelledby="kuisionerLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="kuisionerLabel">Tambah/Ubah Kuisioner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="kuisionerForm">
            <div class="row">
              <div class="col-12">
                <div class="mb-3">
                  <label for="kuisioner" class="form-label">Nama Kuisioner:</label>
                  <input type="text" class="form-control" id="kuisioner" name="kuisioner" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="jumlah-soal" class="form-label">Jumlah Soal:</label>
                  <input type="text" class="form-control" id="jumlah-soal" name="jumlah_soal" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="jumlah-jawaban" class="form-label">Jumlah Jawaban/Persoal:</label>
                  <input type="text" class="form-control" id="jumlah-jawaban" name="jumlah_jawaban" required>
                </div>
              </div>
            </div>
            <div class="row d-none">
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="status" class="form-label">Status:</label>
                  <select class="form-select" id="status" name="status" required>
                    <option value="0">Tidak Aktif</option>
                    <option value="1">Aktif</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bx bx-x"></i> Batal
          </button>
          <button type="button" class="btn btn-primary" onclick="submitKuisioner()" data-bs-dismiss="modal">
            <i class="bx bx-save"></i> Simpan
          </button>
        </div>
      </div>
    </div>
  </div>
  <script>
  // Fungsi untuk memuat kategori
  var dataTable;

  function loadKuisioner() {
    $.ajax({
      url: '/pengaduan/controller/kuisioner.php?action=read',
      type: 'GET',
      success: function(data) {
        if (dataTable) {
          (async () => {
            await dataTable.clear().destroy();
          })();
        }
        document.getElementById('kuisionerBody').innerHTML = data.data;
        (async () => {
          dataTable = $('#dataTable').DataTable({
            "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
          });
        })();
      }
    });
  }

  // Saat dokumen siap
  $(document).ready(function() {
    loadKuisioner(); // Muat kategori saat halaman pertama kali dimuat
  });

  function submitKuisioner() {
    const formData = $('#kuisionerForm').serialize();
    $.ajax({
      url: '/pengaduan/controller/kuisioner.php?action=save',
      type: 'POST',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          loadKuisioner(); // Muat ulang kategori setelah disimpan
          $('#modalKategori').modal('hide');
        } else {
          alert(response.message);
        }
      }
    });
  }

  function deleteKuisioner(data) {
    if (confirm('Apakah Anda yakin ingin menghapus kuisioner ini?')) {
      $.ajax({
        url: '/pengaduan/controller/kuisioner.php?action=delete&id=' + data,
        type: 'GET',
        success: function(response) {
          if (response.status === 'success') {
            alert(response.message);
            loadKuisioner();
          } else {
            alert(response.message);
          }
        }
      });
    }
  }

  function editKuisioner(data) {
    console.log(data);
    $.ajax({
      url: '/pengaduan/controller/kuisioner.php?action=edit&id=' + data,
      type: 'GET',
      success: function(data) {
        const kategori = data.data;
        $('#kuisioner').val(kategori.nama);
        $('#jumlah-soal').val(kategori.jumlah_soal);
        $('#jumlah-jawaban').val(kategori.jumlah_jawaban);
        $('#status').val(kategori.status);
        $('#kuisionerModal').modal('show');
      }
    });
  }

  function changeStatus(data) {
    $.ajax({
      url: '/pengaduan/controller/kuisioner.php?action=changeStatus&id=' + data,
      type: 'GET',
      success: function(response) {
        if (response.status === 'success') {
          loadKuisioner();
        } else {
          alert(response.message);
        }
      }
    });
  }
</script>

<?php else: ?>
  <?php
  include './detailKuisioner.php';
  ?>

  <script>
    function submitSoalKuisioner() {
      const formData = $('#kuisionerForm').serialize();
      $.ajax({
        url: '/pengaduan/controller/kuisioner.php?action=saveSoal&id=<?= $id ?>',
        type: 'POST',
        data: formData,
        success: function(response) {
          if (response.status === 'success') {
            alert(response.message);
            window.location.href = '/pengaduan/admin?page=kuisioner';
          } else {
            alert(response.message);
          }
        }
      });
    }
  </script>

<?php endif; ?>


