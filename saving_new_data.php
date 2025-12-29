<?php
header('Content-Type: application/json');

require_once 'config.php';

$raw_json = file_get_contents('php://input');
$data = json_decode($raw_json, true);

if (isset($data['nama'])) {
    
    $nama   = mysqli_real_escape_string($conn, $data['nama']);
    $alamat = mysqli_real_escape_string($conn, $data['alamat']);
    $email  = mysqli_real_escape_string($conn, $data['email']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $data['jenis_kelamin']);
    $status = mysqli_real_escape_string($conn, $data['status']);
    $id_kelas = mysqli_real_escape_string($conn, $data['id_kelas']);
    $telpon_raw = $data['telpon'];
    $telpon_clean = str_replace([' ', '-', '.'], '', $telpon_raw);

    if (substr($telpon_clean, 0, 3) == '+62') {
        $telpon_fix = '0' . substr($telpon_clean, 3);
    } elseif (substr($telpon_clean, 0, 2) == '62') {
        $telpon_fix = '0' . substr($telpon_clean, 2);
    } else {
        $telpon_fix = $telpon_clean;
    }
    $telpon = mysqli_real_escape_string($conn, $telpon_fix);

    $sql = "INSERT INTO anggota (nama, alamat, telpon, email, jenis_kelamin, id_kelas, status) 
            VALUES ('$nama', '$alamat', '$telpon', '$email', '$jenis_kelamin', '$id_kelas', '$status')";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            "status" => "success",
            "message" => "Data anggota berhasil disimpan"
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Gagal menyimpan ke database: " . mysqli_error($conn)
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak lengkap atau format salah"
    ]);
}
?>

<?php
// require_once 'config.php';

// if (isset($_POST['nama'])) {
//     $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
//     $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
//     $email  = mysqli_real_escape_string($conn, $_POST['email']);
//     $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
//     $status = mysqli_real_escape_string($conn, $_POST['status']);
//     $id_kelas = mysqli_real_escape_string($conn, $_POST['id_kelas']);

//     $telpon_raw = $_POST['telpon'];
//     $telpon_clean = str_replace([' ', '-', '.'], '', $telpon_raw);

//     if (substr($telpon_clean, 0, 3) == '+62') {
//         $telpon_fix = '0' . substr($telpon_clean, 3);
//     } elseif (substr($telpon_clean, 0, 2) == '62') {
//         $telpon_fix = '0' . substr($telpon_clean, 2);
//     } else {
//         $telpon_fix = $telpon_clean;
//     }
//     $telpon = mysqli_real_escape_string($conn, $telpon_fix);

//     $sql = "INSERT INTO anggota (nama, alamat, telpon, email, jenis_kelamin, id_kelas, status) 
//             VALUES ('$nama', '$alamat', '$telpon', '$email', '$jenis_kelamin', '$id_kelas', '$status')";
    
//     if (mysqli_query($conn, $sql)) {
//         echo "sukses";
//     } else {
//         echo "gagal: " . mysqli_error($conn);
//     }
// }
?>