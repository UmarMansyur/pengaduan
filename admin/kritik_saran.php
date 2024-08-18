<div class="row align-items-center">
  <div class="col-md-8">
    <h6 class="page-title">Kritik dan Saran</h6>
  </div>
  <div class="col-md-4 text-end">
    
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
                <th>
                  Tanggal
                </th>
                <th>Nama</th>
                <th>Email</th>
                <th class="text-center">
                  Status
                </th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody id="tableBody">
             
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Add/Edit -->
<div class="modal fade" id="modalKritik" tabindex="-1" aria-labelledby="modalKritikLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalKritikLabel">Kritik dan Saran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="kategoriForm">
          <input type="hidden" id="kritikId" name="id">
          <div class="mb-3">
            <label for="namaKategori" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" required rows="5"></textarea>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>

  var dataTable;

  function loadDataTable() {
    $.ajax({
      url: '/pengaduan/controller/kritik.php?action=show',
      type: 'GET',
      success: function(response) {
        if (dataTable) {
          dataTable.destroy();
        }
        var data = JSON.parse(response);
        $('#tableBody').html(data.html);
        dataTable = $('#dataTable').DataTable({
          "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
          }
        });
      }
    })
  }

  $(document).ready(async function() {
    loadDataTable();
  });

  function viewKritik(id, deskripsi) {
    $.ajax({
      url: '/pengaduan/controller/kritik.php?action=read',
      type: 'GET',
      data: {
        id: id
      },
      success: function(response) {
        console.log(deskripsi);
        $('#kritikId').val(id);
        $('#deskripsi').val(deskripsi);
        loadDataTable();
      }
    });
  }

  function deleteKritik(id) {
    if (confirm('Apakah Anda yakin ingin menghapus kritik dan saran ini?')) {
      $.ajax({
        url: '/pengaduan/controller/kritik.php?action=delete&id=' + id,
        type: 'POST',
        data: {
          id: id
        },
        success: function(response) {
          location.reload();
        }
      });
    }
  }

</script>