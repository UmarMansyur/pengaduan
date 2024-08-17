<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
    rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="./views/assets/style.css">

</head>

<body>
  <div id="app">
    <div class="container-fluid" style="background-image: url(&quot;./views/assets/img/cover.svg&quot;); background-size: auto; height: 100vh;">
      <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body p-5">
                  <h3 class="text-center">DAFTAR</h3>
                  <p class="text-center">Silahkan daftar untuk membuat akun baru</p>
                  <hr>
                  <form action="./controller/register.php" method="POST">
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label for="nama_lengkap" class="form-label fw-semibold"><sup class="text-danger">*</sup>Nama Lengkap:</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Ketik nama lengkap anda" required>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="nik" class="form-label fw-semibold"><sup class="text-danger">*</sup>NIK:</label>
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="Ketik NIK anda" required>
                      </div>

                      <div class="col-md-4 mb-3">
                        <label for="nomor_hp" class="form-label fw-semibold"><sup class="text-danger">*</sup>Nomor HP:</label>
                        <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Ketik nomor hp anda" required>
                      </div>
                      <div class="col-md-4 mb-3">
                        <label for="usia" class="form-label fw-semibold"><sup class="text-danger">*</sup>Usia:</label>
                        <input type="text" class="form-control" id="usia" name="usia" placeholder="Ketik usia anda" required>
                      </div>
                      <div class="col-md-4 mb-3">
                        <label for="username" class="form-label fw-semibold"><sup class="text-danger">*</sup>Jenis Kelamin:</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                          <option value="">Pilih Jenis Kelamin</option>
                          <option value="L">Laki-laki</option>
                          <option value="P">Perempuan</option>
                        </select>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-semibold"><sup class="text-danger">*</sup>Email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ketik email anda" required>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="username" class="form-label fw-semibold"><sup class="text-danger">*</sup>Username:</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Ketik username anda" required>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="password" class="form-label fw-semibold"><sup class="text-danger">*</sup>Password:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ketik password anda" required>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="password" class="form-label fw-semibold"><sup class="text-danger">*</sup>Konfirmasi Password:</label>
                        <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" placeholder="Ketik password anda" required>
                      </div>
                      <!-- alamt -->
                      <div class="col-md-12 mb-3">
                        <label for="alamat" class="form-label fw-semibold"><sup class="text-danger">*</sup>Alamat:</label>
                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Ketik alamat anda" rows="10" required></textarea>
                      </div>
                      <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-brand w-100" id="simpan" name="simpan">Daftar</button>
                        <span class="d-block text-center mt-3">Sudah punya akun? <a href="/" class="text-decoration-none fw-semibold text-brand">Kembali ke beranda</a></span>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.title = 'Daftar - Lapor';
  </script>
</body>

</html>