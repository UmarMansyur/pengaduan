<?php
$id = 1;
$deskripsi = '';

if ($id) {
  $query = $conn->query("SELECT deskripsi FROM tentang_kami WHERE id = $id");
  $data = $query->fetch_assoc();
  $deskripsi = $data['deskripsi'];

  if (!$data) {
    echo '<script>alert("Data tidak ditemukan");window.location.href = "/admin/tentang-kami";</script>';
    exit;
  }
}
?>


<div class="row align-items-center">
  <div class="col-md-8">
    <h6 class="page-title">Tentang Lapor</h6>
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item"><a href="#">Administrator</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tentang Lapor</li>
    </ol>
  </div>
</div>
<div class="row mt-2">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Tentang Lapor</h4>
        <p class="card-title-desc">Halaman ini digunakan untuk mengelola deskripsi tentang Lapor.</p>
        <h4 class="card-title mb-3">Deskripsi: </h4>
        <form id="tentangKamiForm" action="/pengaduan/controller/tentangkami.php" method="POST">
          <textarea name="deskripsi" id="editor1"><?= htmlspecialchars($deskripsi) ?></textarea>
          <input type="hidden" name="id" value="<?= $id ?>">
          <div class="text-center">
            <button type="submit" class="btn btn-info py-2 px-3 mt-3 text-start">
              <i class="mdi mdi-content-save"></i> Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // UploadAdapter class definition
  class UploadAdapter {
    constructor(loader) {
      this.loader = loader;
    }

    upload() {
      return this.loader.file.then(file => {
        return new Promise((resolve, reject) => {
          const reader = new FileReader();
          reader.onload = () => {
            resolve({
              default: reader.result
            });
          };
          reader.onerror = (error) => {
            reject(error);
          };
          reader.readAsDataURL(file);
        });
      });
    }

    abort() {
      // Handle abort if needed
    }
  }

  // Initialize CKEditor with the UploadAdapter
  ClassicEditor
    .create(document.querySelector('#editor1'), {
      // ukuran 200px

      extraPlugins: [MyCustomUploadAdapterPlugin]
    })
    .then(editor => {
      editor.ui.view.editable.element.style.height = '450px';
    })
    .catch(error => {
      console.error('There was a problem initializing the editor.', error);
    });


  // Plugin to use UploadAdapter
  function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
      return new UploadAdapter(loader);
    };
  }
</script>