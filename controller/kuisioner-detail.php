<?php
include '../config/database.php'; // Include file koneksi database
$conn = Connection::getInstance()->getConnection();

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'detail') {
  $id = $_GET['id'];
  $query = $conn->query("SELECT * FROM soal WHERE kuisioner_id = $id");
  $no = 1;
  $result = $query->fetch_all(MYSQLI_ASSOC);
  $jawaban = $conn->query("SELECT * FROM jawaban WHERE soal_id IN (SELECT id FROM soal WHERE kuisioner_id = $id)");


  echo json_encode([
    'status' => 'success',
    'data' => $result,
  ]);
  
}