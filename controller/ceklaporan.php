<?php
include '../config/database.php';
$conn = Connection::getInstance()->getConnection();

function decodeKode($kode)
{
    $getKode = explode('#LP-', $kode);
    if (count($getKode) <= 1) {
        return [
            "error" => "Format Tidak Sesuai"
        ];
    }

    $getKode = ltrim($kode, '#LP-');

    // Memecah string berdasarkan tanda '-' menjadi array
    $parts = explode('-', $getKode);

    // Pastikan format tanggal dan ID benar
    if (count($parts) < 4) {
        return [
            "error" => "Format Tidak Sesuai"
        ];
    }

    $tanggal_laporan = $parts[0] . '-' . $parts[1] . '-' . $parts[2];
    $id = $parts[3];

    return [
        'tanggal' => $tanggal_laporan,
        "id" => $id
    ];
}

if (isset($_GET['q']) && !empty($_GET['q']) && $_GET['q'] !== '') {
    $query = $_GET['q'];
    $kode = decodeKode(mysqli_real_escape_string($conn, $query));

    if (isset($kode['error'])) {
        echo json_encode($kode);
        return;
    }

    $tanggal_laporan = $kode['tanggal'];
    $id = $kode['id'];

    // Menggunakan prepared statement untuk menghindari SQL Injection
    $sql = "SELECT * FROM pengaduan JOIN kategori_layanan ON pengaduan.kategori_layanan_id = kategori_layanan.id WHERE DATE(tanggal_dibuat) = ? AND pengaduan.id = ?";
    // $sql2 = "SELECT * FROM file_lampiran WHERE file_lampiran.pengaduan_id = $id";
    // $datas = $conn->query($sql2);
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode([
            'error' => 'Gagal mempersiapkan query'
        ]);
        exit();
    }

    $stmt->bind_param('si', $tanggal_laporan, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode([
            'data' => $data
        ]);
    } else {
        echo json_encode([
            'error' => 'Data tidak ditemukan'
        ]);
    }

    $stmt->close();
} else {
     echo json_encode([
        'error' => 'Parameter q tidak ada atau kosong'
    ]);
}

?>
