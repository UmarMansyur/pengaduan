<main class="flex-grow-1 w-100">
  <section class="py-1" style="background-image: url(&quot;./views/assets/img/cover.svg&quot;); background-size: auto;">
    <div class="d-flex flex-column justify-content-center" style="height: 80vh;">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card shadow-sm">
              <div class="card-body p-4">
                <h3 class="text-center text-brand">Monitoring Laporan</h3>
                <?php
                $data = "SELECT *, pengaduan.id as id_pengaduan, kategori_layanan.nama as nama_kategori FROM pengaduan JOIN pengguna ON pengaduan.pengguna_id = pengguna.id JOIN kategori_layanan ON pengaduan.kategori_layanan_id = kategori_layanan.id JOIN file_lampiran ON pengaduan.id = file_lampiran.pengaduan_id WHERE pengguna.id = " . $_SESSION['user']['id'];
                ?>
                <div class="table-responsive">
                  <table id="example" class="table" style="width:100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Judul Laporan</th>
                        <th>Nama Terlapor</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Detail</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $result = $conn->query($data);
                      if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                      ?>
                          <tr class="align-middle">
                            <td><?= $no++ ?></td>
                            <td><?= $row['judul_laporan'] ?></td>
                            <td>
                              <?= $row['nama_lengkap'] ?>
                            </td>
                            <td><?= $row['nama_kategori'] ?></td>
                            <td><?= $row['deskripsi'] ?></td>

                            <td>
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

                            </td>
                            <td>
                              <a href="?page=detail-monitoring&id=<?= $row['id_pengaduan'] ?>" class="btn btn-sm btn-brand">Detail</a>
                            </td>
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

  <script>
    $(document).ready(function() {
      $('#example').DataTable({
        "pagingType": "full_numbers",
        "language": {
          "sProcessing": "Sedang memproses...",
          "sLengthMenu": "Tampilkan _MENU_ entri",
          "sZeroRecords": "Tidak ditemukan data yang sesuai",
          "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
          "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
          "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
          "sInfoPostFix": "",
          "sSearch": "Cari:",
          "sUrl": "",
          "oPaginate": {
            "sFirst": "Pertama",
            "sPrevious": "Sebelumnya",
            "sNext": "Selanjutnya",
            "sLast": "Terakhir"
          }
        }
      });
    });
    document.title = 'Monitoring Laporan';
  </script>
</main>