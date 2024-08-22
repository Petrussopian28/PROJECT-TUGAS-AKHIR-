<?php
include "koneksi.php";
session_start();

$id_user = $_GET['id_user'];
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Periksa apakah id_user ada
if (empty($id_user)) {
    echo json_encode(array("message" => "id_user tidak ditemukan"));
    exit;
}

// Persiapkan SQL Query
$sql = "SELECT laporan_harian.id_laporan, laporan_harian.datetimeinput, laporan_harian.absensi, 
        laporan_harian.luas, laporan_harian.janjang, laporan_harian.catatan, 
        divisi.nama_divisi, blok.nama_blok, karyawan.nama_karyawan 
        FROM laporan_harian
        JOIN divisi ON laporan_harian.id_divisi = divisi.id_divisi
        JOIN blok ON laporan_harian.id_blok = blok.id_blok
        JOIN karyawan ON laporan_harian.id_karyawan = karyawan.id_karyawan
        WHERE laporan_harian.id_user = ? ";

if (!empty($search_query)) {
    $sql .= "AND (karyawan.nama_karyawan LIKE ? 
            OR divisi.nama_divisi LIKE ? 
            OR laporan_harian.datetimeinput LIKE ?)";
}
$sql .= " ORDER BY laporan_harian.created_at DESC";

// Gunakan prepared statements untuk keamanan
$stmt = $koneksi->prepare($sql);

if (!empty($search_query)) {
    $search_param = '%' . $search_query . '%';
    $stmt->bind_param("ssss", $id_user, $search_param, $search_param, $search_param);
} else {
    $stmt->bind_param("s", $id_user);
}

$stmt->execute();
$result = $stmt->get_result();

$laporanList = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $laporanList[] = $row;
    }
} else {
    echo json_encode(array("message" => "Tidak ada laporan ditemukan"));
    exit;
}

echo json_encode($laporanList);

$stmt->close();
$koneksi->close();
?>
