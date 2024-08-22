<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'laporan';

// Your existing code
?>
<div class="col-12">
  <div class="card">
      <div class="card-header">
          <div class="card-title" style="font-size: 25px;">LAPORAN HARIAN MANDOR PANEN</div>
          <?php if ($_SESSION['level']=="mandor") {?>
          <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-tambah_laporan">
              Tambah Data
          </button>
          <?php } ?>
          <?php if ($_SESSION['level']=="admin") {?>
          <div class="float-right mr-1">
            <form method="GET" action="">
                <input type="hidden" name="page" value="laporan">
                <select name="filter_user" id="filter_user" class="form-control" onchange="this.form.submit()">
                    <option value="">Semua Mandor</option>
                    <?php
                    include "koneksi.php";
                    $query_users = mysqli_query($koneksi, "SELECT * FROM user WHERE level = 'mandor'");
                    while ($user = mysqli_fetch_array($query_users)) {
                        $selected = (isset($_GET['filter_user']) && $_GET['filter_user'] == $user['id_user']) ? 'selected' : '';
                        echo "<option value='{$user['id_user']}' $selected>{$user['nama_lengkap']}</option>";
                    }
                    ?>
                </select>
            </form>
          </div>
          <?php } ?>
      </div>
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Aksi</th>
            <th>Tanggal</th>
            <?php if ($_SESSION['level']=="admin") {?><th>Nama Mandor</th><?php } ?>
            <th>Nama Karyawan</th>
            <th>Absensi</th>
            <th>Divisi</th>
            <th>Blok Panen</th>
            <th>Luas Panen</th>
            <th>Jumlah Janjang</th>
            <th>Catatan</th>
            <th>Tanggal Input</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          include "koneksi.php";
          $no = 1;
          $id_user = $_SESSION['id_user'];
          $level = $_SESSION['level'];
          $filter_user = isset($_GET['filter_user']) ? $_GET['filter_user'] : '';

          $condition = ($level == "admin") ? "1" : "laporan_harian.id_user = $id_user";
          if (!empty($filter_user)) {
            $condition .= " AND laporan_harian.id_user = $filter_user";
          }
          if ($level == "admin") {
          $laporan = mysqli_query($koneksi, "SELECT * FROM laporan_harian INNER JOIN user ON laporan_harian.id_user = user.id_user INNER JOIN divisi ON laporan_harian.id_divisi = divisi.id_divisi INNER JOIN blok ON laporan_harian.id_blok = blok.id_blok INNER JOIN karyawan ON laporan_harian.id_karyawan = karyawan.id_karyawan WHERE $condition ORDER BY id_laporan DESC");
          } else {
            $laporan = mysqli_query($koneksi, "SELECT * FROM laporan_harian INNER JOIN divisi ON laporan_harian.id_divisi = divisi.id_divisi INNER JOIN blok ON laporan_harian.id_blok = blok.id_blok INNER JOIN karyawan ON laporan_harian.id_karyawan = karyawan.id_karyawan WHERE id_user = $id_user ORDER BY id_laporan DESC");
          }
          
          while($data = mysqli_fetch_array($laporan)){
          ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalDetail<?php echo $data['id_laporan']?>">
                Detail
              </button>
                    <div class="modal fade" id="modalDetail<?php echo $data['id_laporan']?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header bg-primary">
                              <h4 class="modal-title fw-bold">Detail Laporan Harian Mandor Panen</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col sm-5">
                                  <h5>Tanggal <br/></h5>
                                  <?php if ($_SESSION['level']=="admin") {?> <h5> Nama Mandor <br/><?php } ?></h5>
                                  <h5>Nama Karyawan <br/></h5>
                                  <h5>Absensi <br/></h5>
                                  <h5>Divisi <br/></h5>
                                  <h5>Blok Panen <br/></h5>
                                  <h5>Luas Panen <br/></h5>
                                  <h5>Jumlah Janjang <br/></h5>
                                  <h5>Catatan <br/></h5>
                                  <h5>Tanggal Input <br/></h5>
                                </div>
                                <div class="col-sm-8">
                                  <h5>: <?php echo $data['datetimeinput'] ?> <br/></h5>
                                   <?php if ($_SESSION['level']=="admin") {?><h5>: <?php echo $data['nama_lengkap']; ?> <br/> <?php } ?><h5> 
                                  <h5>: <?php echo $data['nama_karyawan'] ?> <br/></h5>
                                  <h5>: <?php echo $data['absensi'] ?> <br/></h5>
                                  <h5>: <?php echo $data['nama_divisi'] ?> <br/></h5>
                                  <h5>: <?php echo $data['nama_blok'] ?> <br/></h5>
                                  <h5>: <?php echo $data['luas'] ?> <br/></h5>
                                  <h5>: <?php echo $data['janjang'] ?> <br/></h5>
                                  <h5>: <?php echo $data['catatan'] ?> <br/></h5>
                                  <h5>: <?php echo $data['created_at'] ?> <br/></h5>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer right">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Keluar</button>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit<?php echo $data['id_laporan']?>">
                    Ubah
                    </button>
                    <button type="submit" name="hapus" class="btn btn-danger" data-toggle="modal" data-target="#modalHapus<?php echo $data['id_laporan']?>">
                    Hapus
                    </button>
                    <div class="modal fade" id="modalHapus<?php echo $data['id_laporan']?>" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header bg-danger">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="POST">
                            <div class="form-group">
                              <input type="hidden" name="id_laporan" value="<?php echo $data['id_laporan']?>">
                              <h3>Apakah Anda Ingin Menghapus Data <?php echo $data['nama_karyawan']?> </h3>
                              <div class="modal-footer right">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success" name="hapus">Hapus</button>
                              </div>
                            </div>
                            <?php
                            if(isset($_POST['hapus'])){
                              $id_laporan = $_POST['id_laporan'];
                              $sql = $koneksi->query("DELETE FROM laporan_harian WHERE id_laporan='$id_laporan'");
                              if($sql){
                                ?>
                                <Script>
                                  alert("Data Berhasil Dihapus");
                                  window.location.href="?page=laporan";
                                  </Script>

                                <?php
                              }
                            }
                            ?>
                          </form>
                        </div>
                      </div>
                    </div>
                    </td>
            <td><?php echo $data['datetimeinput']; ?></td>
            <?php if ($_SESSION['level']=="admin") {?><td><?php echo $data['nama_lengkap']; ?></td><?php } ?>
            <td><?php echo $data['nama_karyawan']; ?></td>
            <td><?php echo $data['absensi']; ?></td>
            <td><?php echo $data['nama_divisi']; ?></td>
            <td><?php echo $data['nama_blok']; ?></td>
            <td><?php echo $data['luas']; ?></td>
            <td><?php echo $data['janjang']; ?></td>
            <td><?php echo $data['catatan']; ?></td>
            <td><?php echo $data['created_at']; ?></td>
          </tr>
          
          <div class="modal fade" id="modalEdit<?php echo $data['id_laporan']?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header bg-warning">
                            <h4 class="modal-title">EDIT LAPORAN HARIAN</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="POST">
                              <?php 
                              $id_laporan = $data['id_laporan'];
                              $sql_edit = $koneksi->query("SELECT * FROM laporan_harian WHERE id_laporan='$id_laporan'");
                              while ($data_edit=$sql_edit->fetch_assoc()){
                              ?>
                              <div class="form-group">
                                  <input type="hidden" class="form-control" name="id_laporan" value="<?php echo $data_edit['id_laporan']?>">
                              </div>
                              <div class="form-group">
                                  <label >Tanggal</label>
                                  <input type="text" class="form-control" name="datetimeinput" value="<?php echo $data_edit['datetimeinput']?>" required>
                              </div>
                              <?php if ($_SESSION['level']=="admin") {?>
                              <div class="form-group">
                                  <label >Nama Mandor</label>
                                  <select class="form-control" id="id_user" name="id_user" style="width: 100%;">
                                    <option value="<?php echo $data_edit['id_user']?>" selected="selected"><?php echo $data['nama_lengkap']?></option>
                                    <?php
                                    include "koneksi.php";

                                    $query = mysqli_query($koneksi,"SELECT * FROM user");
                                    while($data = mysqli_fetch_array($query)){
                                      echo "<option value=$data[id_user]> $data[nama_lengkap] </option>";
                                    }
                                    
                                    
                                    ?>
                                  </select>
                              </div>
                              <?php } ?>
                              <div class="form-group">
                                <label>Nama Karyawan</label>
                                <select class="form-control" name="id_karyawan" style="width: 100%;" required>
                                    <?php
                                    include "koneksi.php";

                                    // Fetch the current employee details
                                    $current_id_karyawan = isset($data_edit['id_karyawan']) ? $data_edit['id_karyawan'] : '';
                                    $current_nama_karyawan = isset($data_edit['nama_karyawan']) ? $data_edit['nama_karyawan'] : 'Select Karyawan';

                                    echo "<option value='$current_id_karyawan' selected='selected'>$current_nama_karyawan</option>";

                                    // Fetch all employees from the database
                                    $query = mysqli_query($koneksi, "SELECT * FROM karyawan");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $selected = $data['id_karyawan'] == $current_id_karyawan ? "selected" : "";
                                        echo "<option value='{$data['id_karyawan']}' $selected>{$data['nama_karyawan']}</option>";
                                    }
                                    ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Absensi</label>
                                <select class="form-control" name="absensi" style="width: 100%;" required>
                                  <option selected="selected"><?php echo $data_edit['absensi'] ?></option>
                                  <option>Sakit</option>
                                  <option>Izin</option>
                                  <option>Mangkir</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Nama Divisi</label>
                                <select class="form-control" name="id_divisi" style="width: 100%;" required>
                                    <?php
                                    include "koneksi.php";

                                    // Fetch the current employee details
                                    $current_id_divisi = isset($data_edit['id_divisi']) ? $data_edit['id_divisi'] : '';
                                    $current_nama_divisi = isset($data_edit['nama_divisi']) ? $data_edit['nama_divisi'] : 'Select Karyawan';

                                    echo "<option value='$current_id_divisi' selected='selected'>$current_nama_divisi</option>";

                                    // Fetch all employees from the database
                                    $query = mysqli_query($koneksi, "SELECT * FROM divisi");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $selected = $data['id_divisi'] == $current_id_divisi ? "selected" : "";
                                        echo "<option value='{$data['id_divisi']}' $selected>{$data['nama_divisi']}</option>";
                                    }
                                    ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Blok Panen</label>
                                <select class="form-control" name="id_blok" style="width: 100%;" required>
                                    <?php
                                    include "koneksi.php";

                                    // Fetch the current employee details
                                    $current_id_blok = isset($data_edit['id_blok']) ? $data_edit['id_blok'] : '';
                                    $current_nama_blok = isset($data_edit['nama_blok']) ? $data_edit['nama_blok'] : 'Select Karyawan';

                                    echo "<option value='$current_id_blok' selected='selected'>$current_nama_blok</option>";

                                    // Fetch all employees from the database
                                    $query = mysqli_query($koneksi, "SELECT * FROM blok");
                                    while ($data = mysqli_fetch_array($query)) {
                                        $selected = $data['id_blok'] == $current_id_blok ? "selected" : "";
                                        echo "<option value='{$data['id_blok']}' $selected>{$data['nama_blok']}</option>";
                                    }
                                    ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label >Luas</label>
                                <input type="text" class="form-control" name="luas" id="luas" value="<?php echo $data_edit['luas'] ?>" required>
                                
                              </div>
                              <div class="form-group">
                                <label >Janjang Panen</label>
                                <input type="text" class="form-control" name="janjang" id="janjang" value="<?php echo $data_edit['janjang'] ?>" required>
                                
                              </div>
                              <div class="form-group">
                                <label >Catatan</label>
                                <input type="text" class="form-control" name="catatan" id="catatan" value="<?php echo $data_edit['catatan'] ?>" required>
                            
                              </div>
                            
                              </div>
                              <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
                            </div>
                            <?php } ?>
                            </form>
                            <?php
                            if(isset($_POST['ubah'])) {
                                $id_laporan = $_POST['id_laporan'];
                                $datetimeinput = $_POST['datetimeinput'];
                                $absensi = $_POST['absensi'];
                                $luas = $_POST['luas'];
                                $janjang = $_POST['janjang'];
                                $catatan = $_POST['catatan'];
                                $id_user = $_POST['id_user'];
                                $id_divisi = $_POST['id_divisi'];
                                $id_blok = $_POST['id_blok'];
                                $id_karyawan = $_POST['id_karyawan'];

                                $sql = $koneksi->query("UPDATE laporan_harian SET datetimeinput='$datetimeinput', absensi='$absensi', luas='$luas', janjang='$janjang', catatan='$catatan', id_user='$id_user', id_divisi='$id_divisi', id_blok='$id_blok', id_karyawan='$id_karyawan' WHERE id_laporan='$id_laporan'");
                                
                                if($sql){
                                  ?>
                                  <Script>
                                    alert("Data Berhasil Diubah");
                                    window.location.href="?page=laporan";
                                  </Script>
                      
                                  <?php
                                }
                              }
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
            <?php
            }
            ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-tambah_laporan">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Laporan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="tambah_divisi" method="POST">
                <div class="form-group">
                    <label >Tanggal</label>
                    <input type="date" class="form-control" name="datetimeinput" id="datetimeinput"  placeholder="Masukan Tanggal" required> 
                </div>
                <div class="form-group">
                <label>Nama Karyawan</label>
                  <select class="form-control" name="id_karyawan" style="width: 100%;" required>
                    <option selected="selected">Pilih Nama karyawan</option>
                    <?php
                    include "koneksi.php";
                    $query = mysqli_query($koneksi,"SELECT * FROM karyawan");
                    while($data = mysqli_fetch_array($query)){
                      echo "<option value=$data[id_karyawan]> $data[nama_karyawan] </option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Absensi</label>
                  <select class="form-control" name="absensi" style="width: 100%;" required>
                    <option selected="selected">Kerja</option>
                    <option>Sakit</option>
                    <option>Izin</option>
                    <option>Mangkir</option>
                  </select>
                </div>
                <div class="form-group">
                <label>Divisi</label>
                  <select class="form-control" name="id_divisi" style="width: 100%;" required>
                    <option selected="selected">Pilih Nama Divisi</option>
                    <?php
                    include "koneksi.php";
                    $query = mysqli_query($koneksi,"SELECT * FROM divisi");
                    while($data = mysqli_fetch_array($query)){
                      echo "<option value=$data[id_divisi]> $data[nama_divisi] </option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                <label>Blok</label>
                  <select class="form-control" name="id_blok" style="width: 100%;" required>
                    <option selected="selected">Pilih Nama Blok</option>
                    <?php
                    include "koneksi.php";
                    $query = mysqli_query($koneksi,"SELECT * FROM blok");
                    while($data = mysqli_fetch_array($query)){
                      echo "<option value=$data[id_blok]> $data[nama_blok] </option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                    <label >Luas Panen</label>
                    <input type="text" class="form-control" name="luas" id="luas"  placeholder="Masukan luas Panen" required>
                </div>
                <div class="form-group">
                    <label >Janjang Panen</label>
                    <input type="text" class="form-control" name="janjang" id="janjang"  placeholder="Masukan Janjang Panen" required>
                </div>
                <div class="form-group">
                    <label >Catatan</label>
                    <input type="text"  class="form-control" name="catatan" id="catatan" placeholder="Masukan catatan" required></input>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="id_user" id="id_user" value="<?php echo $_SESSION['id_user']; ?> ">
                </div>
                </div>
                <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
              </div>
            </form>
          </div>
        </div>
        <?php
        include "koneksi.php";
        if(isset($_POST['simpan'])){
          $datetimeinput = $_POST['datetimeinput'];
          $absensi = $_POST['absensi'];
          $luas = $_POST['luas'];
          $janjang = $_POST['janjang'];
          $catatan = $_POST['catatan'];
          $id_user = $_POST['id_user'];
          $id_divisi = $_POST['id_divisi'];
          $id_blok = $_POST['id_blok'];
          $id_karyawan = $_POST['id_karyawan'];
          $data = mysqli_query($koneksi,"INSERT INTO laporan_harian (datetimeinput, absensi, luas, janjang, catatan, id_user, id_divisi, id_blok, id_karyawan) VALUES ('$datetimeinput', '$absensi', '$luas', '$janjang', '$catatan', '$id_user', '$id_divisi', '$id_blok', '$id_karyawan')");
          if($data){
            ?>
            <Script>
              alert("Data Berhasil Disimpan")
              window.location.href="?page=laporan";
            </Script>

            <?php
          }
        }
        ?>
</div>

