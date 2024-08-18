<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$deskripsi = '';

if ($id) {
  $query = $conn->query("SELECT deskripsi FROM tentang_kami WHERE id = $id");
  $data = $query->fetch_assoc();
  $deskripsi = $data['deskripsi'];
}
?>


<div class="row align-items-center">
  <div class="col-md-12">
    <h6 class="page-title">Dashboard</h6>
  </div>
</div>

<form id="tentangKamiForm" action="/controller/tentangkami.php" method="POST">
  <textarea name="deskripsi" id="editor1"><?= htmlspecialchars($deskripsi) ?></textarea>
  <input type="hidden" name="id" value="<?= $id ?>">
  <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>

<script>
  // Initialize CKEditor
  CKEDITOR.replace('editor1');
</script>