<?php
include "koneksi.php";

if (isset($_GET['id_divisi'])) {
    $id_divisi = $_GET['id_divisi'];
    $query = mysqli_query($koneksi, "SELECT * FROM divisi WHERE id_divisi = $id_divisi");
    $divisi = [];

    while ($data = mysqli_fetch_array($query)) {
        $divisi[] = [
            'id_divisi' => $data['id_divisi'],
            'nama_divisi' => $data['nama_divisi']
        ];
    }

    echo json_encode($divisi);
}
?>