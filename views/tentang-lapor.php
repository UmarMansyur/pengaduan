<?php

$deskripsi = $conn->query("SELECT * FROM tentang_kami")->fetch_assoc()['deskripsi'];
?>
<main class="flex-grow-1 w-100">
  <section class="py-1" style="background-image: url('./views/assets/img/cover.svg'); background-size: auto;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card shadow-sm p-4">
            <div class="card-body">
              <?= $deskripsi ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
  document.title = 'Tentang Lapor | Dinas Pendidikan Kabupaten Pamekasan';
</script>