<?php
require_once('koneksi.php');

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data from Flutter app
    $data = json_decode(file_get_contents("php://input"), true);

    // Assign values
    $datetimeinput = $data['datetimeinput'];
    $absensi = $data['absensi'];
    $luas = $data['luas'];
    $janjang = $data['janjang'];
    $catatan = $data['catatan'];
    $id_user = $data['id_user'];
    $id_divisi = $data['id_divisi'];
    $id_blok = $data['id_blok'];
    $id_karyawan = $data['id_karyawan'];

    // Insert into laporan_harian table
    $sql = "INSERT INTO laporan_harian (datetimeinput, absensi, luas, janjang, catatan, id_user, id_divisi, id_blok, id_karyawan)
            VALUES ('$datetimeinput', '$absensi', '$luas', '$janjang', '$catatan', '$id_user', '$id_divisi', '$id_blok', '$id_karyawan')";

    if ($koneksi->query($sql) === TRUE) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "error", "message" => $conn->error));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}

$conn->close();
?>
