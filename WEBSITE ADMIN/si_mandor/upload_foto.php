<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $target_dir = "assets/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Periksa apakah file adalah gambar
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Periksa apakah file sudah ada
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Periksa ukuran file
    if ($_FILES["foto"]["size"] > 500000) {
        $uploadOk = 0;
    }

    // Perbolehkan format file tertentu
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }

    // Periksa apakah $uploadOk disetel ke 0 oleh kesalahan
    if ($uploadOk == 0) {
        $response = array(
            'status' => 'fail',
            'message' => 'Sorry, your file was not uploaded.'
        );
    } else {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Simpan URL gambar ke database
            $sql = "UPDATE user SET foto='$target_file' WHERE id_user='$id_user'";
            if ($conn->query($sql) === TRUE) {
                $response = array(
                    'status' => 'success',
                    'message' => 'The file '. basename( $_FILES["foto"]["name"]). ' has been uploaded.',
                    'foto' => $target_file
                );
            } else {
                $response = array(
                    'status' => 'fail',
                    'message' => 'Sorry, there was an error updating your profile picture.'
                );
            }
        } else {
            $response = array(
                'status' => 'fail',
                'message' => 'Sorry, there was an error uploading your file.'
            );
        }
    }

    echo json_encode($response);
    $conn->close();
}
?>
