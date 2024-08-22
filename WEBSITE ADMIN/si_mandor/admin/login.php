<?php
session_start();
include 'koneksi.php';

if ( isset($_POST["login"])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $login = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");

    if(mysqli_num_rows($login)>0){
      $user = mysqli_fetch_array($login);
      header("location: index.php?page=dashboard");
      $_SESSION['login'] = true;
      $_SESSION['id_user'] = $user['id_user'];
      $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['alamat'] = $user['alamat'];
      $_SESSION['password'] = $user['password'];
      $_SESSION['level'] = $user['level'];
      $_SESSION['foto'] = $user['foto'];
    }
    $error = true;
 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Simandor</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="app/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="app/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="app/dist/css/adminlte.min.css">
  <style>
        body {
            background-image: url('assets/background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            height: 100vh;
        }
    </style>
</head>
<body class="hold-transition login-page bg-">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    <div class="login-logo">
      <a href="">
      <img src="assets/bga.png" alt="Logo" style="width: 200px; height: auto;">
      </a>
    </div>
      <p class="login-box-msg"><h4>Selamat Datang! Silakan Login</h4></p>
      <?php if (isset($error)) : ?>
          <div class="alert alert-danger text-center">
            <b>username atau password salah</b>
          </div>
      <?php endif ?>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" id="username" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" id="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="login" value="login" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="app/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="app/dist/js/adminlte.min.js"></script>
</body>
</html>
