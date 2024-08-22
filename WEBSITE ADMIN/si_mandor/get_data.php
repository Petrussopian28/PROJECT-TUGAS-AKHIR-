<?php
include "koneksi.php";

$response = array();

$sqlDivisi = "SELECT * FROM divisi";
$resultDivisi = $koneksi->query($sqlDivisi);
$response['divisi'] = $resultDivisi->fetch_all(MYSQLI_ASSOC);

$sqlBlok = "SELECT * FROM blok";
$resultBlok = $koneksi->query($sqlBlok);
$response['blok'] = $resultBlok->fetch_all(MYSQLI_ASSOC);

$sqlKaryawan = "SELECT * FROM karyawan";
$resultKaryawan = $koneksi->query($sqlKaryawan);
$response['karyawan'] = $resultKaryawan->fetch_all(MYSQLI_ASSOC);

echo json_encode($response);

$koneksi->close();
?>
