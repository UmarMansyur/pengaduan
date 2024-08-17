DROP TABLE IF EXISTS detail_jawaban_pengguna;
DROP TABLE IF EXISTS jawaban_pengguna;
DROP TABLE IF EXISTS jawaban;
DROP TABLE IF EXISTS soal;
DROP TABLE IF EXISTS kuisioner;
DROP TABLE IF EXISTS file_lampiran;
DROP TABLE IF EXISTS tanggapan;
DROP TABLE IF EXISTS pengaduan;
DROP TABLE IF EXISTS kategori_layanan;
DROP TABLE IF EXISTS pengguna;

CREATE TABLE pengguna (
    id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nama_lengkap VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    thumbnail VARCHAR(255) NULL,
    type ENUM('admin') NOT NULL
);

CREATE TABLE kategori_layanan (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL
);

CREATE TABLE pengaduan (
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nama_pelapor VARCHAR(255) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    usia INTEGER NULL,
    phone VARCHAR(15) NULL,
    nik VARCHAR(16) NULL,
    judul_laporan VARCHAR(255) NOT NULL,
    nama_terlapor VARCHAR(255) NOT NULL,
    alamat VARCHAR(255) NULL,
    kategori_layanan_id INTEGER NOT NULL,
    deskripsi TEXT NULL,
    status_pengaduan ENUM('Pending', 'Diproses', 'Selesai', 'Ditolak') NOT NULL,
    alasan_penolakan TEXT NULL,
    tanggal_dibuat DATETIME DEFAULT CURRENT_TIMESTAMP,
    tanggal_diproses DATETIME NULL,
    tanggal_selesai DATETIME NULL,
    CONSTRAINT fk_kategori_pengaduan FOREIGN KEY (kategori_layanan_id) REFERENCES kategori_layanan(id)
);

CREATE TABLE kuisioner (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    status ENUM('Aktif', 'Tidak Aktif') NOT NULL
);

CREATE TABLE soal (
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    kuisioner_id INTEGER NOT NULL,
    soal VARCHAR(255) NOT NULL,
    CONSTRAINT fk_kuisioner_soal FOREIGN KEY (kuisioner_id) REFERENCES kuisioner(id)
);

CREATE TABLE jawaban (
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    soal_id BIGINT NOT NULL,
    jawaban VARCHAR(255) NOT NULL,
    bobot INTEGER NOT NULL,
    CONSTRAINT fk_kuisioner_jawaban FOREIGN KEY (soal_id) REFERENCES soal(id)
);



CREATE TABLE jawaban_pengguna (
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nama BIGINT NOT NULL,
    kuisioner_id BIGINT NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    pendidikan ENUM('SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3') NOT NULL,
    pekerjaan ENUM('PNS', 'TNI/POLRI', 'SWASTA', 'WIRAUSAHA', 'PELAJAR/MAHASISWA', 'LAINNYA') NOT NULL
);

CREATE TABLE detail_jawaban_pengguna (
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    jawaban_pengguna_id BIGINT NOT NULL,
    soal_id BIGINT NOT NULL,
    jawaban_id BIGINT NOT NULL,
    CONSTRAINT fk_jawaban_pengguna_detail_jawaban_pengguna FOREIGN KEY (jawaban_pengguna_id) REFERENCES jawaban_pengguna(id),
    CONSTRAINT fk_soal_detail_jawaban_pengguna FOREIGN KEY (soal_id) REFERENCES soal(id)
);

CREATE TABLE file_lampiran (
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    pengaduan_id BIGINT NOT NULL,
    nama VARCHAR(255) NOT NULL,
    path VARCHAR(255) NOT NULL,
    CONSTRAINT fk_pengaduan_file_lampiran FOREIGN KEY (pengaduan_id) REFERENCES pengaduan(id)
);

INSERT INTO kategori_layanan (nama) VALUES ('Pelayanan Publik'), ('Pelayanan Kesehatan'), ('Pelayanan Pendidikan'), ('Pelayanan Keamanan'), ('Pelayanan Sosial'), ('Pelayanan Transportasi'), ('Pelayanan Pariwisata'), ('Pelayanan Perizinan'), ('Pelayanan Lainnya');


INSERT INTO pengguna (nama_lengkap, email, username, password, type, thumbnail) VALUES ('Admin', 'admin@gmail.com', 'admin', '$2y$10$uoS.DRftiBx.4N0.yVurHesGv8h6JY4eE.0xFr0qvKd3U4lR1U9lC', 'admin', 'https://ik.imagekit.io/8zmr0xxik/blob_c2rRi4vdU?updatedAt=1709077347010');
