<?php
include '../config/database.php'; // Include file koneksi database

// Mendapatkan koneksi database
$conn = Connection::getInstance()->getConnection();

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $kuisionerId = $conn->real_escape_string($_POST['kuisionerId']);
    $soalId = $conn->real_escape_string($_POST['soalId']);
    $soal = $conn->real_escape_string($_POST['soal']);
    $jumlah_jawaban = intval($_POST['jumlah_jawaban']);

    if (!empty($soalId)) {
        $stmt = $conn->prepare("UPDATE soal SET soal = ? WHERE id = ?");
        $stmt->bind_param('si', $soal, $soalId);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert soal baru
        $stmt = $conn->prepare("INSERT INTO soal(soal, kuisioner_id) VALUES (?, ?)");
        $stmt->bind_param('si', $soal, $kuisionerId);
        $stmt->execute();
        $stmt->close();
        $soalId = $conn->insert_id;
    }

    // Simpan jawaban dan bobot
    for ($i = 1; $i <= $jumlah_jawaban; $i++) {
        $jawabanId = $conn->real_escape_string($_POST["jawabanId$i"]);
        $jawaban = $conn->real_escape_string($_POST["jawaban$i"]);
        $bobot = $conn->real_escape_string($_POST["bobot$i"]);
        
        if (!empty($jawabanId)) {
            // Update jawaban dan bobot yang sudah ada
            $stmt = $conn->prepare("UPDATE jawaban SET jawaban = ?, bobot = ? WHERE id = ?");
            $stmt->bind_param('ssi', $jawaban, $bobot, $jawabanId);
            $stmt->execute();
            $stmt->close();
        } else {
            // Insert jawaban dan bobot baru
            $stmt = $conn->prepare("INSERT INTO jawaban (soal_id, jawaban, bobot) VALUES (?, ?, ?)");
            $stmt->bind_param('iss', $soalId, $jawaban, $bobot);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Redirect ke halaman yang diinginkan setelah menyimpan data
    header('Location: /pengaduan/admin?page=kuisioner&id=' . $kuisionerId);
    exit;
}

// buat logika untuk menghapus data
if ($_GET['action'] === 'delete') {
    $kuisionerId = $conn->real_escape_string($_GET['id']);
    $soalId = $conn->real_escape_string($_GET['soalId']);
    $stmt = $conn->prepare("DELETE FROM soal WHERE id = ?");
    $stmt->bind_param('i', $soalId);
    $stmt->execute();
    $stmt->close();

    // Redirect ke halaman yang diinginkan setelah menghapus data
    header('Location: /pengaduan/admin?page=kuisioner&id=' . $kuisionerId);
    exit;
}

// Jika tidak ada data yang dikirimkan, maka tampilkan halaman error
echo 'Data tidak ditemukan';


// Tutup koneksi database
$conn->close();
?>
