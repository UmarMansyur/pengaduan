<?php
$id = $_GET['id'];
$pengguna_id = $_SESSION['user']['id'];
if ($_SESSION['user']['type'] == 'admin') {
  $data = "SELECT *, kategori_layanan.nama as nama_kategori, pengaduan.alamat as alamat_terlapor FROM pengaduan JOIN pengguna ON pengaduan.pengguna_id = pengguna.id JOIN kategori_layanan ON pengaduan.kategori_layanan_id = kategori_layanan.id WHERE pengaduan.id = $id";
} else {
  $data = "SELECT *, kategori_layanan.nama as nama_kategori, pengaduan.alamat as alamat_terlapor FROM pengaduan JOIN pengguna ON pengaduan.pengguna_id = pengguna.id JOIN kategori_layanan ON pengaduan.kategori_layanan_id = kategori_layanan.id WHERE pengguna.id = $pengguna_id AND pengaduan.id = $id";
}
$result = $conn->query($data);
$row = $result->fetch_assoc();
if ($result->num_rows == 0) {
  echo "<script>window.location = '?page=monitoring'</script>";
}
?>
<main class="flex-grow-1 w-100">
  <section id="bg-home" style="background-image: url(&quot;./views/assets/img/cover.svg&quot;);">
    <div class="container" style="height: 50vh;">
      <div class="row justify-content-between pt-3">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-between mb-3 align-items-center">
                <div class="col-auto">
                  <h6 class="text-brand">Detail Laporan</h6>
                </div>
                <div class="col-auto text-end">
                  <div class="d-flex gap-2">
                    <a href="?page=monitoring" class="btn btn-sm btn-brand">Kembali</a>
                    <?php
                    if ($row['status_pengaduan'] == 'Pending') {
                      echo '<a href="?page=edit-laporan&id=' . $id . '" class="btn btn-sm btn-light">
                      <i class="bx bx-pencil"></i>
                      </a>';
                      echo '<a href="?page=hapus-laporan&id=' . $id . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus laporan ini?\')">
                      <i class="bx bx-trash"></i>
                      </a>';
                    }
                    ?>
                  </div>
                  <br>
                  <?php
                  if ($row['status_pengaduan'] == 'Pending') {
                    echo '<span class="badge bg-warning text-white">Menunggu Konfirmasi</span>';
                  } else if ($row['status_pengaduan'] == 'Diproses') {
                    echo '<span class="badge bg-info text-white">Dalam Proses</span>';
                  } else if ($row['status_pengaduan'] == 'Selesai') {
                    echo '<span class="badge bg-success text-white">Selesai</span>';
                  } else {
                    echo '<span class="badge bg-danger text-white">Ditolak</span>';
                  }
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h6>Identitas Pelapor: </h6>
                  <p class="fs-14 mb-1">
                    Judul Laporan: <?= $row['judul_laporan'] ?>
                  </p>
                  <p class="fs-14 mb-1">
                    Pelapor: <?= $row['nama_lengkap'] ?>
                  </p>
                  <p class="fs-14 mb-1">
                    NIK: <?= $row['nik'] ?>
                  </p>
                  <p class="fs-14 mb-1">
                    Jenis Kelamin: <?= $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                  </p>
                  <p class="fs-14 mb-1">
                    Usia: <?= $row['usia'] ?>
                  </p>
                  <p class="fs-14 mb-1">
                    Email: <?= $row['email'] ?>
                  </p>
                  <p class="fs-14 mb-1">
                    Nomor Telepon/HP: <?= $row['phone'] ?>
                  </p>
                  <p class="fs-14 mb-3">
                    Alamat: <?= $row['alamat'] ?>
                  </p>
                  <h6>
                    Identitas Terlapor:
                  </h6>
                  <p class="fs-14 mb-1">
                    Nama Terlapor: <?= $row['nama_terlapor'] ?>
                  </p>
                  <p class="fs-14 mb-1">
                    Alamat Terlapor: <?= $row['alamat_terlapor'] ?>
                  </p>
                  <p class="fs-14 mb-1">
                    Kategori Tujuan Layanan: <?= $row['nama_kategori'] ?>
                  </p>
                  <p class="fs-14 mb-1">
                    Deskripsi Pengaduang:
                  </p>
                  <p class="fs-14 mb-1">
                    <?= $row['deskripsi'] ?>
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <h6>Lampiran: </h6>
                  <div class="table-responsive">
                    <div class="text-end my-3">
                      <button type="button" class="btn btn-sm btn-brand" data-bs-toggle="modal" data-bs-target="#modalTambahLampiran">
                        <i class="bx bx-plus"></i> Tambah Lampiran
                      </button>
                    </div>
                    <table class="table table-boderless">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Lampiran</th>
                          <?php
                          if ($row['status_pengaduan'] == 'Pending') {
                          ?>
                            <th>Aksi</th>
                          <?php
                          }
                          ?>
                        </tr>
                      </thead>
                      <tbody class="align-middle">
                        <?php
                        $lampiran = $conn->query("SELECT * FROM file_lampiran WHERE pengaduan_id = $id");
                        if ($lampiran->num_rows > 0) {
                          $no = 1;
                          while ($rowLampiran = $lampiran->fetch_assoc()) {
                        ?>
                            <tr>
                              <td><?= $no++ ?></td>
                              <td>
                                <a href="<?= $rowLampiran['path'] ?>" target="_blank"><?= $rowLampiran['nama'] ?></a>
                              </td>
                              <?php
                              if ($row['status_pengaduan'] == 'Pending') {
                              ?>
                                <td>
                                  <a href="?page=hapus-lampiran&id=<?= $rowLampiran['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus lampiran ini?')">
                                    <i class="bx bx-trash"></i>
                                  </a>
                                </td>
                              <?php
                              }
                              ?>
                            </tr>
                        <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
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
  document.title = "Beranda - Lapor";
</script>