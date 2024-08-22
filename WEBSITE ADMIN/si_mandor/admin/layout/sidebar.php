<?php
  $page = @$_GET['page'];
  if($page=="laporan") {
    $laporanaktif ='active';
  }
  if($page=="dashboard") {
    $dashboardaktif ='active';
  }
  if($page=="divisi") {
    $masteraktif1 ='menu-open';
    $masteraktif2 ='active';
    $divisiaktif ='active';
  }
  if($page=="mandor") {
    $masteraktif1 ='menu-open';
    $masteraktif2 ='active';
    $mandoraktif ='active';
  }
  if($page=="karyawan") {
    $masteraktif1 ='menu-open';
    $masteraktif2 ='active';
    $karyawanaktif ='active';
  }
  if($page=="blok") {
    $masteraktif1 ='menu-open';
    $masteraktif2 ='active';
    $blokaktif ='active';
  }

?>
    <!-- Brand Logo -->
    <a href="index.php?page=dashboard" class="brand-link">
      <img src="assets/bga.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SIMANDOR</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $_SESSION['foto']; ?>" class="img-circle elevation-2 " alt="User Image" style="width: 50px; height: 50px; object-fit: cover;">
        </div>
        <div class="info">
          <a href="?page=profil" class="d-block"> <?php echo $_SESSION['nama_lengkap']; ?></a>
        </div>
      </div> 
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="?page=dashboard" class="nav-link <?php echo $dashboardaktif ?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php if ($_SESSION['level']=="admin") {?>
          <li class="nav-item has-treeview <?php echo $masteraktif1?>">
            <a href="#" class="nav-link <?php echo $masteraktif2?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Master Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=mandor" class="nav-link <?php echo $mandoraktif ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Mandor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=karyawan" class="nav-link <?php echo $karyawanaktif ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Karyawan</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="?page=divisi" class="nav-link <?php echo $divisiaktif ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Divisi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=blok" class="nav-link <?php echo $blokaktif ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Blok</p>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a href="?page=laporan" class="nav-link <?php echo $laporanaktif;?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Laporan Harian
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->