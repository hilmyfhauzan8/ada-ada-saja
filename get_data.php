<?php
header('Content-Type: application/json');
require_once 'config.php';

$limit  = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

$sql = "SELECT a.*, k.nama_kelas FROM anggota as a
        LEFT JOIN kelas as k ON a.id_kelas = k.id_kelas
        GROUP BY a.id_anggota
        ORDER BY a.id_anggota ASC
        LIMIT $limit OFFSET $offset";

$query = mysqli_query($conn, $sql);
$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode($data);
?>