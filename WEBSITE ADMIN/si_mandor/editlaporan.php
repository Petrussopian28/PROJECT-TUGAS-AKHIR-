<?php
include "koneksi.php";
session_start();
header('Content-Type: application/json');

// Ambil data dari request POST
$id_laporan = $_GET['id_laporan']; // menggunakan GET karena dikirim via URL
$datetimeinput = $_POST['datetimeinput'];
$absensi = $_POST['absensi'];
$luas = $_POST['luas'];
$janjang = $_POST['janjang'];
$catatan = $_POST['catatan'];
$id_divisi = $_POST['id_divisi'];
$id_blok = $_POST['id_blok'];
$id_karyawan = $_POST['id_karyawan'];

// Query update
$sql = "UPDATE laporan_harian
        SET datetimeinput = '$datetimeinput',
            absensi = '$absensi',
            luas = '$luas',
            janjang = '$janjang',
            catatan = '$catatan',
            id_divisi = '$id_divisi',
            id_blok = '$id_blok',
            id_karyawan = '$id_karyawan'
        WHERE id_laporan = '$id_laporan'";

$response = array();

if ($koneksi->query($sql) === TRUE) {
    $response['message'] = "Laporan berhasil diperbarui";
} else {
    $response['message'] = "Error: " . $sql . "<br>" . $koneksi->error;
}

echo json_encode($response);

$koneksi->close();
?>
