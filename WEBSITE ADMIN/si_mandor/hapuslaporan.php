<?php
include "koneksi.php";
session_start();

$id_laporan = $_POST['id_laporan'];

// Query untuk menghapus laporan
$sql = "DELETE FROM laporan_harian WHERE id_laporan = '$id_laporan'";

if ($koneksi->query($sql) === TRUE) {
    $response = array('message' => 'Laporan berhasil dihapus');
    echo json_encode($response);
} else {
    $response = array('message' => 'Gagal menghapus laporan: ' . $koneksi->error);
    echo json_encode($response);
}

$koneksi->close();
?>
