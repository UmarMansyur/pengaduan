<div class="row align-items-center">
  <div class="col-md-8">
    <h6 class="page-title">Kategori Tujuan Layanan</h6>
  </div>
  <div class="col-md-4 text-end">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalKategori">
      <i class='bx bx-plus'></i> Tambah Kategori
    </button>
  </div>
</div>

<div class="row mt-3">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered" id="dataTable">
            <thead>
              <tr>
                <th style="width: 50px;" class="text-center">No</th>
                <th>Nama Kategori</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody id="kategoriTbody">
              <!-- Data Kategori Akan di-Render di Sini -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Add/Edit -->
<div class="modal fade" id="modalKategori" tabindex="-1" aria-labelledby="modalKategoriLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalKategoriLabel">Tambah Kategori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="kategoriForm">
          <input type="hidden" id="kategoriId" name="id">
          <div class="mb-3">
            <label for="namaKategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="namaKategori" name="nama" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="submitKategori()">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script>
  let dataTable;

  // Fungsi untuk memuat kategori
  function loadKategori() {
    $.ajax({
      url: '/controller/kategori.php?action=read',
      type: 'GET',
      success: function(data) {
        document.getElementById('kategoriTbody').innerHTML = data.data;
        if (dataTable) {
          return;
        }
        dataTable = $('#dataTable').DataTable();
      }
    });
  }

  // Saat dokumen siap
  $(document).ready(function() {
    loadKategori(); // Muat kategori saat halaman pertama kali dimuat
  });

  function submitKategori() {
    const formData = $('#kategoriForm').serialize();

    $.ajax({
      url: '/controller/kategori.php?action=save',
      type: 'POST',
      data: formData,
      success: function(response) {
        if (response.status === 'success') {
          loadKategori(); // Muat ulang kategori setelah disimpan
          $('#modalKategori').modal('hide');
        } else {
          alert(response.message);
        }
      }
    });
  }

  function deleteKategori(data) {
    if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
      $.ajax({
        url: '/controller/kategori.php?action=delete&id=' + data,
        type: 'GET',
        success: function(response) {
          if (response.status === 'success') {
            alert(response.message);
            loadKategori(); // Muat ulang kategori setelah dihapus
          } else {
            alert(response.message);
          }
        }
      });
    }
  }


  function editKategori(data) {
    console.log(data);
    $.ajax({
      url: '/controller/kategori.php?action=edit&id=' + data,
      type: 'GET',
      success: function(data) {
        const kategori = data.data;
        $('#kategoriId').val(kategori.id);
        $('#namaKategori').val(kategori.nama);
        $('#modalKategoriLabel').text('Edit Kategori');
        $('#modalKategori').modal('show');
      }
    });
  }
</script>