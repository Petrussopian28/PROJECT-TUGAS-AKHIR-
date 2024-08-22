<?php
session_start();

include_once "koneksi.php";

// Handle login request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan username dan password
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        // Jika ditemukan, set session ID
        $row = $result->fetch_assoc();
        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
        $_SESSION['alamat'] = $row['alamat'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['level'] = $row['level'];
        $_SESSION['foto'] = $row['foto'];
        echo json_encode(array(
            "status" => "success",
            "message" => "Login berhasil",
            "id_user" => $row['id_user'],
            "username" => $row['username'],
            "nama_lengkap" => $row['nama_lengkap'],
            "alamat" => $row['alamat'],
            "password" => $row['password'],
            "level" => $row['level'],
            "foto" => $row['foto']
        ));
    } else {
        echo json_encode(array("status" => "error", "message" => "Username atau password salah"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Metode tidak diizinkan"));
}

$koneksi->close();
?>
