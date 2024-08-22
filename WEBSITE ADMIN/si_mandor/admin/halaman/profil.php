<?php

include 'koneksi.php';

// Pastikan user telah login
if (!isset($_SESSION['login'])) {
    header("location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$foto = $_SESSION['foto'];

if (isset($_POST['editprofil'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $foto = $_FILES['foto']['name'];
    $target_dir = "assets/";

    if ($foto) {
        $target_file = $target_dir . basename($foto);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_file_types = ['jpg', 'jpeg', 'png', 'gif'];
        
        // Check if file type is allowed
        if (in_array($imageFileType, $allowed_file_types)) {
            $new_file_name = $target_dir . uniqid('', true) . '.' . $imageFileType;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $new_file_name)) {
                $foto_path = $new_file_name;
            } else {
                $foto_path = $_SESSION['foto'];
            }
        } else {
            $foto_path = $_SESSION['foto'];
        }
    } else {
        $foto_path = $_SESSION['foto'];
    }

    $id_user = $_SESSION['id_user'];

    $sql = "UPDATE user SET 
            nama_lengkap = '$nama_lengkap',
            alamat = '$alamat',
            username = '$username',
            password = '$password',
            foto = '$foto_path'
            WHERE id_user = '$id_user'";

    if (mysqli_query($koneksi, $sql)) {
        $_SESSION['nama_lengkap'] = $nama_lengkap;
        $_SESSION['alamat'] = $alamat;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['foto'] = $foto_path;
        echo "<script>
            alert('Profil berhasil diperbarui');
            window.location.href='index.php?page=profil';
          </script>"; // Ganti 'index.php?page=profil' dengan halaman profil Anda
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}
?>

    <div class="card-body col-12">
        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="card">
                        <div class="profile-img">
                            <img src="<?php echo $_SESSION['foto']; ?>" alt="Profile Picture"  class="img-fluid profile-pic-container" style="width: 100%; height: 500px;"/>
                            <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    <i class="fa fa-folder-open"></i> <input type="file" class="profile-pic" name="foto" value="" accept=".jpg, .png">
                                </span>
                            </span>
                            <input type="text" class="form-control" readonly="">
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header">
                        <div class="card-title" style="font-size: 25px;">DATA PROFIL</div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" value="<?php echo $_SESSION['nama_lengkap']; ?>" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="alamat" value="<?php echo $_SESSION['alamat']; ?>" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" name="password" value="<?php echo $_SESSION['password']; ?>" class="form-control"/>
                            </div>
                            <input type="submit" class="btn btn-primary" name="editprofil" value="Simpan"/>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </div>
