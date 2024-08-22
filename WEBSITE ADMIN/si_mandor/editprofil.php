<?php
include 'koneksi.php'; // Masukkan konfigurasi database Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    $sql = "UPDATE user SET username='$username', nama_lengkap='$nama_lengkap', alamat='$alamat', password='$password', level='$level' WHERE id_user='$id_user'";

    if (mysqli_query($koneksi, $sql)) {
        $response['status'] = 'success';
        $response['message'] = 'Profil berhasil diperbarui';
        $response['user'] = [
            'username' => $username,
            'nama_lengkap' => $nama_lengkap,
            'alamat' => $alamat,
            'password' => $password,
            'level' => $level,
        ];
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Gagal memperbarui profil';
    }

    echo json_encode($response);
    mysqli_close($koneksi);
}
?>
