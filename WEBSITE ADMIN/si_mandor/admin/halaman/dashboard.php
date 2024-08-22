 <?php
 include "koneksi.php";
 $id_user = $_SESSION['id_user'];
 $level = $_SESSION['level'];

 $get1 = mysqli_query($koneksi,"SELECT * FROM laporan_harian WHERE id_user=$id_user");
 if ($level == "admin") {
  $get1 = mysqli_query($koneksi,"SELECT * FROM laporan_harian");
  }
 $count1 = mysqli_num_rows($get1);

 $get2 = mysqli_query($koneksi,"SELECT * FROM user WHERE level = 'mandor'");
 $count2 = mysqli_num_rows($get2);

 $get3 = mysqli_query($koneksi,"SELECT * FROM divisi");
 $count3 = mysqli_num_rows($get3);

 $get4 = mysqli_query($koneksi,"SELECT * FROM blok");
 $count4 = mysqli_num_rows($get4);

 $get5 = mysqli_query($koneksi,"SELECT * FROM karyawan");
 $count5 = mysqli_num_rows($get5);

 
 ?>
 <div class="row col-md-12">
 <section class="content-header">
      <div class="container-fluid">
        <div class="row ">
            <h4>Selamat Datang, <?php echo $_SESSION['nama_lengkap']; ?> </h4>
        </div>
      </div><!-- /.container-fluid -->
</section>
</div>

<?php if ($_SESSION['level']=="mandor"|| $_SESSION['level']=="admin") {?>
 <div class="col-10 col-sm-6 col-md-3">
        <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-file"></i></span>
                <div class="info-box-content">
                <span class="info-box-text"><h4>Laporan Harian</h4></span>
                <span class="info-box-number">
                  <?=$count1;?>
                </span>
              </div>
              <!-- /.info-box-content -->
        </div>
  </div> 
  <?php } ?>
           


    <?php if ($_SESSION['level']=="admin") {?>
      <div class="col-8 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><h4>Jumlah Mandor</h4></span>
                <span class="info-box-number"><?=$count2;?></span>
              </div>
              <!-- /.info-box-content -->
        </div>
            <!-- /.info-box -->
  </div>
  <div class="col-8 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-chart-pie"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><h4>Jumlah divisi</h4></span>
                <span class="info-box-number"><?=$count3;?></span>
              </div>
              <!-- /.info-box-content -->
        </div>
            <!-- /.info-box -->
  </div>


  <div class="col-8 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-square"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><h4>Jumlah Blok</h4></span>
                <span class="info-box-number"><?=$count4;?></span>
              </div>
              <!-- /.info-box-content -->
        </div>
            <!-- /.info-box -->
  </div>
  <div class="col-10 col-sm-3 col-md-">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><h4>Jumlah Karyawan</h4></span>
                <span class="info-box-number"><?=$count5;?></span>
              </div>
              <!-- /.info-box-content -->
        </div>
        <?php } ?>
            <!-- /.info-box -->
</div> 


