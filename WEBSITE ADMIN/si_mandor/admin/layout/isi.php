<?php
   $page = $_GET['page'];
   if ($page=="dashboard") {
      include "halaman/dashboard.php";
   }
   if ($page=="dashboardmandor") {
      include "halaman/dashboardmandor.php";
   }
    if ($page=="divisi") {
       include "halaman/divisi/divisi.php";
    }
    if ($page=="mandor") {
       include "halaman/mandor/mandor.php";
    }
    if ($page=="laporan") {
      include "halaman/laporan/laporan.php";
   }
   if ($page=="karyawan") {
      include "halaman/karyawan/karyawan.php";
   }
   if ($page=="blok") {
      include "halaman/blok/blok.php";
   }
   if ($page=="profil") {
      include "halaman/profil.php";
   }
?>