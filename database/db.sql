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

DROP TABLE IF EXISTS tentang_kami;

DROP TABLE IF EXISTS kritik_saran;

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
    email VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    alamat_lengkap VARCHAR(255) NULL,
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
    CONSTRAINT fk_kategori_pengaduan FOREIGN KEY (kategori_layanan_id) REFERENCES kategori_layanan(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE kuisioner (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    jumlah_soal INTEGER NOT NULL,
    jumlah_jawaban INTEGER NOT NULL,
    status BOOLEAN DEFAULT FALSE
);

CREATE TABLE soal (
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    kuisioner_id INTEGER NOT NULL,
    soal VARCHAR(255) NOT NULL,
    CONSTRAINT fk_kuisioner_soal FOREIGN KEY (kuisioner_id) REFERENCES kuisioner(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE jawaban (
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    soal_id BIGINT NOT NULL,
    jawaban VARCHAR(255) NOT NULL,
    bobot INTEGER NOT NULL,
    CONSTRAINT fk_kuisioner_jawaban FOREIGN KEY (soal_id) REFERENCES soal(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE jawaban_pengguna (
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    usia INTEGER NOT NULL,
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
    CONSTRAINT fk_jawaban_pengguna_detail_jawaban_pengguna FOREIGN KEY (jawaban_pengguna_id) REFERENCES jawaban_pengguna(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_soal_detail_jawaban_pengguna FOREIGN KEY (soal_id) REFERENCES soal(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE file_lampiran (
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    pengaduan_id BIGINT NOT NULL,
    nama VARCHAR(255) NOT NULL,
    path VARCHAR(255) NOT NULL,
    CONSTRAINT fk_pengaduan_file_lampiran FOREIGN KEY (pengaduan_id) REFERENCES pengaduan(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tentang_kami (
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    deskripsi TEXT NOT NULL
);

CREATE TABLE kritik_saran (
    id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    nama VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    dibaca BOOLEAN DEFAULT FALSE,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO kategori_layanan (nama) VALUES 
('Pelayanan Publik'), 
('Pelayanan Kesehatan'), 
('Pelayanan Pendidikan'), 
('Pelayanan Keamanan'), 
('Pelayanan Sosial'), 
('Pelayanan Transportasi'), 
('Pelayanan Pariwisata'), 
('Pelayanan Perizinan'), 
('Pelayanan Lainnya');


INSERT INTO pengguna (nama_lengkap, email, username, password, type, thumbnail) VALUES 
('Admin', 'admin@gmail.com', 'admin', '$2y$10$uoS.DRftiBx.4N0.yVurHesGv8h6JY4eE.0xFr0qvKd3U4lR1U9lC', 'admin', 'https://ik.imagekit.io/8zmr0xxik/blob_c2rRi4vdU?updatedAt=1709077347010');

INSERT INTO tentang_kami (deskripsi) VALUES ('Tentang Kami');

INSERT INTO kuisioner (nama, jumlah_soal, jumlah_jawaban, status) VALUES ('Kuisioner Kepuasan Layanan Publik', 9, 4, TRUE);


INSERT INTO soal (kuisioner_id, soal) VALUES
(1, 'Bagaimana pendapat anda tentang kesesuaian persyaratan pelayanan dengan jenis pelayanan yang diberikan?'),
(1, 'Bagaimana pemahaman anda tentang kemudahan prosedur pelayanan di unit ini?'),
(1, 'Bagaimana pendapat anda tentang kecepatan waktu dalam memberikan pelayanan?'),
(1, 'Bagaimana pendapat anda tentang kewajaran biaya?'),
(1, 'Bagaimana pendapat anda tentang kesesuaian produk pelayanan antara yang tercantum dalam standar pelayanan dengan hasil yang diberikan?'),
(1, 'Bagaimana pendapat anda tentang kompetensi/ kemampuan petugas dalam pelayanan (improvisasi)?'),
(1, 'Bagaimana pendapat anda tentang perilaku petugas dalam pelayanan terkait kesopanan dan keramahan?'),
(1, 'Bagaimana pendapat anda tentang kualitas sarana dan prasarana?'),
(1, 'Bagaimana pendapat anda tentang penanganan pengaduan pelayanan?');


-- Jawaban untuk soal 1
INSERT INTO jawaban (soal_id, jawaban, bobot) VALUES
(1, 'Tidak Sesuai', 1),
(1, 'Kurang Sesuai', 2),
(1, 'Sesuai', 3),
(1, 'Sangat Sesuai', 4);

-- Jawaban untuk soal 2
INSERT INTO jawaban (soal_id, jawaban, bobot) VALUES
(2, 'Tidak Mudah', 1),
(2, 'Kurang Mudah', 2),
(2, 'Mudah', 3),
(2, 'Sangat Mudah', 4);

-- Jawaban untuk soal 3
INSERT INTO jawaban (soal_id, jawaban, bobot) VALUES
(3, 'Tidak Cepat', 1),
(3, 'Kurang Cepat', 2),
(3, 'Cepat', 3),
(3, 'Sangat Cepat', 4);

-- Jawaban untuk soal 4
INSERT INTO jawaban (soal_id, jawaban, bobot) VALUES
(4, 'Sangat Mahal', 1),
(4, 'Cukup Mahal', 2),
(4, 'Murah', 3),
(4, 'Gratis', 4);

-- Jawaban untuk soal 5
INSERT INTO jawaban (soal_id, jawaban, bobot) VALUES
(5, 'Tidak sesuai', 1),
(5, 'Kurang sesuai', 2),
(5, 'Sesuai', 3),
(5, 'Sangat sesuai', 4);

-- Jawaban untuk soal 6
INSERT INTO jawaban (soal_id, jawaban, bobot) VALUES
(6, 'Tidak Kompeten', 1),
(6, 'Kurang Kompeten', 2),
(6, 'Kompeten', 3),
(6, 'Sangat Kompeten', 4);

-- Jawaban untuk soal 7
INSERT INTO jawaban (soal_id, jawaban, bobot) VALUES
(7, 'Tidak sopan & ramah', 1),
(7, 'Kurang sopan & ramah', 2),
(7, 'sopan & ramah', 3),
(7, 'Sangat sopan & ramah', 4);

-- Jawaban untuk soal 8
INSERT INTO jawaban (soal_id, jawaban, bobot) VALUES
(8, 'Buruk', 1),
(8, 'Cukup', 2),
(8, 'Baik', 3),
(8, 'Sangat Baik', 4);

-- Jawaban untuk soal 9
INSERT INTO jawaban (soal_id, jawaban, bobot) VALUES
(9, 'Tidak Ada', 1),
(9, 'Ada tapi tidak berfungsi', 2),
(9, 'Berfungsi Kurang maksimal', 3),
(9, 'Dikelola dengan baik', 4);

