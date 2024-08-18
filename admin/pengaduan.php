<?php
$page = $_GET['page'];
$status = "";
switch ($page) {
  case 'pending':
    $status = 'Pending';
    break;
  case 'diproses':
    $status = 'Diproses';
    break;
  case 'selesai':
    $status = 'Selesai';
    break;
  case 'ditolak':
    $status = 'Ditolak';
    break;
  default:
    $status = 'Pending';
    break;
}
?>
<div class="row align-items-center">
  <div class="col-md-8">
    <h6 class="page-title">Laporan Pengaduan</h6>
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item"><a href="#">Administrator</a></li>
      <li class="breadcrumb-item active" aria-current="page">Laporan Pengaduan</li>
    </ol>
  </div>
</div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <table class="table table-bordered dt-responsive" id="datatable">
              <thead>
                <tr class="align-middle">
                  <th>No.</th>
                  <th>NIK</th>
                  <th class="text-start">Nama Pelapor</th>
                  <th>Jenis Kelamin</th>
                  <th>Email</th>
                  <th>Hp</th>
                  <th>Nama Terlapor</th>
                  <th>Judul Laporan</th>
                  <th>Kategori Tujuan Layanan</th>
                  <th>Tanggal Melapor</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $data = $conn->query("SELECT *, pengaduan.id as id_pengaduan FROM pengaduan JOIN kategori_layanan ON pengaduan.kategori_layanan_id = kategori_layanan.id WHERE status_pengaduan = '$status' ORDER BY pengaduan.id DESC");
                $index = 1;
                while ($d = mysqli_fetch_assoc($data)):
                ?>
                  <tr class="align-middle">
                    <td class="text-center">
                      <?= $index ?>
                    </td>
                    <td>
                      <?= $d['nik'] ?>
                    </td>
                    <td>
                      <?= $d['nama_pelapor'] ?>
                    </td>
                    <td>
                      <?= $d['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?>
                    </td>
                    <td>
                      <?= $d['email'] ?>
                    </td>
                    <td>
                      <?= $d['phone'] ?>
                    </td>
                    <td>
                      <?= $d['nama_terlapor'] ?>
                    </td>
                    <td>
                      <?= $d['judul_laporan'] ?>
                    </td>
                    <td>
                      <?= $d['nama'] ?>
                    </td>
                    <td>
                      <?= strtoupper(date('d-m-y H:i', strtotime($d['tanggal_dibuat']))) ?> WIB
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detail-pengaduan" onclick="detail('<?= htmlspecialchars(json_encode($d), ENT_QUOTES, 'UTF-8') ?>', '<?= $page ?>')">
                        Detail
                      </button>
                    </td>
                  </tr>
                <?php $index++;
                endwhile ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal untuk Alasan Penolakan -->
<div class="modal fade" id="alasanPenolakanModal" tabindex="-1" aria-labelledby="alasanPenolakanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alasanPenolakanLabel">Isi Alasan Penolakan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="alasanPenolakanForm">
          <div class="mb-3">
            <label for="alasanPenolakan" class="form-label">Alasan Penolakan</label>
            <textarea class="form-control" id="alasanPenolakan" rows="3" required></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" onclick="submitAlasanPenolakan()">Tolak Pengaduan</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detail-pengaduan" tabindex="-1" aria-labelledby="detail-pengaduan" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          Detail Pengaduan
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div id="data-modal"></div>
          <div class="col-md-12">

            <div id="tindakan"></div>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <script>
    $(document).ready(function() {
      $('#datatable').DataTable({
        // gunakan bahasa indonesia
        "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
        }

      });
    });

    async function detail(data, page) {
      data = JSON.parse(data);
      const repsonse = await fetch('/pengaduan/controller/lampiran.php?id=' + data.id_pengaduan);
      const result = await repsonse.json();
      data.lampiran = result.lampiran;
      const html = `
      <div class="col-md-12">
        <h4 class="font-size-18 mb-3">Identitas Pelapor: </h4>
        <h6 class="font-size-16">Nama Pelapor: ${data.nama_pelapor}</h6>
        <h6 class="font-size-16">Nik: ${data.nik}</h6>
        <h6 class="font-size-16">Email: ${data.email}</h6>
        <h6 class="font-size-16">No. Hp: ${data.phone}</h6>
        <h6 class="font-size-16">Jenis Kelamin : ${data.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}</h6>
        <h4 class="font-size-18 my-3">Detail Laporan: </h4>
        <div class="table-responsive">
          <table class="table table-hover table-stripped table-bordered">
            <tbody>
              <tr>
                <th>Judul</th>
                <td>${data.judul_laporan}</td>
              </tr>
              <tr>
                <th>Nama Terlapor</th>
                <td>${data.nama_terlapor}</td>
              </tr>
              <tr>
                <th>Kategori Tujuan Layanan</th>
                <td>${data.nama}</td>
              </tr>
              <tr>
                <th>Status Pengaduan</th>
                <td>${data.status_pengaduan}</td>
              </tr>
              <tr>
                <th>Deskripsi</th>
                <td>${data.deskripsi}</td>
              </tr>
              <tr>
                <th>Tanggal Dibuat</th>
                <td>${new Date(data.tanggal_dibuat).toLocaleDateString(
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
              data.status_pengaduan !== 'Ditolak' ? `<tr>
                <th>Tanggal Diproses</th>
                <td>${data.tanggal_diproses === null ? 'Belum diproses' : new
                  Date(data.tanggal_diproses).toLocaleDateString(
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
              ${data.status_pengaduan !== 'Ditolak' ? `<tr>
                <th>Tanggal Selesai</th>
                <td>${data.tanggal_selesai === null ? 'Belum selesai' : new
                  Date(data.tanggal_selesai).toLocaleDateString(
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

              ${data.status_pengaduan === 'Ditolak' ? `<tr>
                <th>Alasan Penolakan</th>
                <td>${data.alasan_penolakan}</td>
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
      const html2 = `
        ${data.status_pengaduan === 'Ditolak' ? `<h4 class="font-size-18 mb-3">Alasan Penolakan: </h4>
        <p>${data.alasan_penolakan}</p>` : ''}
        ${data.status_pengaduan === 'Pending' ? `
          <a href="/pengaduan/controller/lampiran.php?id=${data.id_pengaduan}&status=Diproses&page=${page}" class="btn btn-primary">Proses</a>
          <button class="btn btn-danger" onclick="openModalPenolakan(${data.id_pengaduan}, '${page}')" data-bs-dismiss="modal">Tolak</button>
        ` : ''}
        ${data.status_pengaduan === 'Diproses' ? `
          <a href="/pengaduan/controller/lampiran.php?id=${data.id_pengaduan}&status=Selesai&page=${page}" class="btn btn-success">Selesai</a>
          <button class="btn btn-danger" onclick="openModalPenolakan(${data.id_pengaduan}, '${page}')" data-bs-dismiss="modal">Tolak</button>
        ` : ''}
        ${data.status_pengaduan === 'Selesai' ? `
          <a href="/pengaduan/controller/lampiran.php?id=${data.id_pengaduan}&status=Pending&page=${page}" class="btn btn-primary">Pending</a>
        ` : ''}
      `;

      document.getElementById('tindakan').innerHTML = html2;
      document.getElementById('data-modal').innerHTML = html;
    }

    function openModalPenolakan(id, currentPage) {
      pengaduanId = id;
      page = currentPage;
      // Buka modal
      // tutup modal sebelumnya jika ada
      document.getElementById('detail-pengaduan').classList.remove('show');
      const modal = new bootstrap.Modal(document.getElementById('alasanPenolakanModal'));
      modal.show();
    }

    function submitAlasanPenolakan() {
      const alasan = document.getElementById('alasanPenolakan').value;

      if (!alasan) {
        alert('Alasan penolakan harus diisi.');
        return;
      }
      window.location.href = `/pengaduan/controller/lampiran.php?id=${pengaduanId}&status=Ditolak&alasan=${encodeURIComponent(alasan)}&page=${page}`;
    }
  </script>