<?php
// Kode laporan
$kode_laporan = '#LP-2024-08-17-50';

// Menghapus '#' dari awal string
$kode_laporan = ltrim($kode_laporan, '#LP-');

// Memecah string berdasarkan tanda '-' menjadi array
$parts = explode('-', $kode_laporan);

// Mendapatkan tanggal dan ID
$tanggal_laporan = $parts[0] . '-' . $parts[1] . '-' . $parts[2];
$id = $parts[3];

// Menampilkan hasil
echo 'Tanggal Laporan: ' . $tanggal_laporan . '<br>';
echo 'ID: ' . $id;
?>