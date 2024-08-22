<?php
include "koneksi.php";
session_start();

$id_user = $_POST['id_user'];
$datetimeinput = $_POST['datetimeinput'];
$absensi = $_POST['absensi'];
$luas = $_POST['luas'];
$janjang = $_POST['janjang'];
$catatan = $_POST['catatan'];
$id_divisi = $_POST['id_divisi'];
$id_blok = $_POST['id_blok'];
$id_karyawan = $_POST['id_karyawan'];

error_log("Received data: id_user=$id_user, datetimeinput=$datetimeinput, absensi=$absensi, luas=$luas, janjang=$janjang, catatan=$catatan, id_divisi=$id_divisi, id_blok=$id_blok, id_karyawan=$id_karyawan");

$sql = "INSERT INTO laporan_harian (datetimeinput, absensi, luas, janjang, catatan, id_user, id_divisi, id_blok, id_karyawan)
VALUES ('$datetimeinput', '$absensi', '$luas', '$janjang', '$catatan', '$id_user', '$id_divisi', '$id_blok', '$id_karyawan')";

if ($koneksi->query($sql) === TRUE) {
    echo json_encode(array("message" => "Laporan berhasil ditambahkan"));
} else {
    echo json_encode(array("message" => "Error: " . $sql . "<br>" . $koneksi->error));
}

$koneksi->close();
?>