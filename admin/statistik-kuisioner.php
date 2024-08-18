<div class="row align-items-center">
  <div class="col-md-8">
    <h6 class="page-title">Statistik Kuisioner</h6>
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item"><a href="#">Administrator</a></li>
      <li class="breadcrumb-item active" aria-current="page">Statistik Kuisioner</li>
    </ol>
  </div>
</div>
<?php
$sql = "SELECT * FROM kuisioner";
$kuisioner = $conn->query($sql);

if ($kuisioner && $kuisioner->num_rows > 0) {
  $kuisioner = $kuisioner->fetch_all(MYSQLI_ASSOC);
}
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0 && !in_array($id, array_column($kuisioner, 'id'))) {
  echo "<script>window.location.href = '/pengaduan/admin/index.php?page=statistik-kuisioner';</script>";
}

if ($id < 1):
?>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="dataTable">
              <thead>
                <tr>
                  <th style="width: 50px;" class="text-center">No</th>
                  <th>Nama Kuisioner</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($kuisioner as $key => $value) : ?>
                  <tr>
                    <td class="text-center"><?= $key + 1; ?></td>
                    <td><?= $value['nama']; ?></td>
                    <td class="text-center">
                      <a href="/pengaduan/admin/index.php?page=statistik-kuisioner&id=<?= $value['id']; ?>" class="btn btn-sm btn-primary">
                        <i class='bx bx-bar-chart-alt-2'></i> Lihat Statistik
                        </button>
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
  <script>
    $(document).ready(function() {
      $('#dataTable').DataTable({
        // buat bahasa indonesia
        "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
        }
      });
    });
  </script>

<?php else: ?>
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-center">
        Statistik Kuisioner:
        <?php
        $sql = "SELECT nama FROM kuisioner WHERE id = $id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo $row['nama'];

        ?>
      </h4>
      <div id="bar-chart"></div>
    </div>
    <div class="col-md-12">
      <div id="pie-chart"></div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      <?php
      // Lakukan query ke database
      $sql = "SELECT AVG(bobot) as 'NRR_per_unsur' 
              FROM `detail_jawaban_pengguna` 
              JOIN jawaban ON detail_jawaban_pengguna.jawaban_id = jawaban.id 
              WHERE detail_jawaban_pengguna.soal_id IN (SELECT id FROM soal WHERE kuisioner_id = $id) 
              GROUP BY detail_jawaban_pengguna.soal_id ORDER BY detail_jawaban_pengguna.soal_id";
      $result = $conn->query($sql);
      $data = [];
      $total = 0;
      while ($row = $result->fetch_assoc()) {
        $data[] = $row['NRR_per_unsur'];
        $total += $row['NRR_per_unsur'];
      }

      $banyak = "SELECT COUNT(*) as jumlah FROM jawaban_pengguna WHERE kuisioner_id = $id";
      $banyak = $conn->query($banyak);
      $banyak = $banyak->fetch_assoc();
      $rata_rata = ($total / $banyak['jumlah'] * 0.111) * 25;

      ?>

      // gunakan apexchart
      var options = {
        series: [{
          name: 'NRR per Unsur',
          data: <?= json_encode($data); ?>
        }],
        chart: {
          height: 450,
          type: 'bar', // Make sure the chart type is 'bar'
        },
        plotOptions: {
          bar: {
            horizontal: true, // Change this to true to make the bars horizontal
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: [
            <?php
            $sql = "SELECT COUNT(*) as 'jumlah' FROM soal WHERE kuisioner_id = $id ORDER BY id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            for ($i = 1; $i <= $row['jumlah']; $i++) {
              echo "'Unsur $i',";
            }
            ?>
          ],
          labels: {
            style: {
              fontStyle: 'italic' // This will make the x-axis labels italic
            }
          }
        },
        yaxis: {
          title: {
            text: 'NRR per Unsur'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return val
            }
          }
        }
      };

      const barChart = new ApexCharts(document.querySelector("#bar-chart"), options);
      barChart.render();


      const options2 = {
        series: [<?= $rata_rata; ?>],
        chart: {
          height: 350,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            hollow: {
              size: '70%',
            }
          },
        },
        labels: ['Rata-rata NRR'],
      };

      const pieChart = new ApexCharts(document.querySelector("#pie-chart"), options2);
      pieChart.render();
    });
  </script>
<?php endif; ?>