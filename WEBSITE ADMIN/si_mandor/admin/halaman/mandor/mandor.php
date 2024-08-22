<div class="col-12">
  <div class="card">
      <div class="card-header">
      <div class="card-title" style="font-size: 25px;">DATA MANDOR</div>
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-tambah_mandor">
            Tambah Data
        </button>
      </div>
              <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>Divisi</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Level</th>
                    <th>Aksi</th>
                  </tr>
             </thead>
                <tbody>
                <?php
                  
                  include "koneksi.php";
                  $no = 1;
                  $level = $_SESSION['level'];
                  $laporan = mysqli_query($koneksi,"SELECT * FROM user, divisi WHERE user.id_divisi = divisi.id_divisi AND  level = 'mandor' ORDER BY id_user DESC");
                  while($data = mysqli_fetch_array($laporan)){
                    ?>
                    <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['nama_lengkap']; ?></td>
                    <td><?php echo $data['alamat']; ?></td>
                    <td><?php echo $data['nama_divisi']; ?></td>
                    <td><?php echo $data['username']; ?></td>
                    <td><?php echo $data['password']; ?></td>
                    <td><?php echo $data['level']; ?></td>
                    <td>
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalDetail<?php echo $data['id_user']?>">
                      Detail
                      </button>
                      <div class="modal fade" id="modalDetail<?php echo $data['id_user']?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header bg-primary">
                                <h4 class="modal-title fw-bold">DETAIL DATA MANDOR</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col sm-4">
                                    Nama Lengkap <br/>
                                    Alamat <br/>
                                    Divisi <br/>
                                    Username <br/>
                                    Password <br/>
                                    Status <br/>
                                  </div>
                                  <div class="col-sm-8">
                                    : <?php echo $data['nama_lengkap'] ?> <br/>
                                    : <?php echo $data['alamat'] ?> <br/>
                                    : <?php echo $data['nama_divisi'] ?> <br/>
                                    : <?php echo $data['username'] ?> <br/>
                                    : <?php echo $data['password'] ?> <br/>
                                    : <?php echo $data['level'] ?> <br/>
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
                      
                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit<?php echo $data['id_user']?>">
                      Ubah
                      </button>
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalHapus<?php echo $data['id_user']?>">
                      Hapus
                      </button>
                      <div class="modal fade" id="modalHapus<?php echo $data['id_user']?>" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header bg-danger">
                              <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"></span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form method="POST">
                              <div class="form-group">
                                <input type="hidden" name="id_user" value="<?php echo $data['id_user']?>">
                                <h3>Apakah Anda Ingin Menghapus Data <?php echo $data['nama_lengkap']?> </h3>
                                <div class="modal-footer right">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-success" name="hapus">Hapus</button>
                                </div>
                              </div>
                              <?php
                              if(isset($_POST['hapus'])){
                                $id_user = $_POST['id_user'];
                                $hapus = $koneksi->query("DELETE FROM user WHERE id_user='$id_user'");
                                if($hapus){
                                  ?>
                                  <Script>
                                    alert("Data Berhasil Dihapus");
                                    window.location.href="?page=mandor";
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
                    </tr>
                    <div class="modal fade" id="modalEdit<?php echo $data['id_user']?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header bg-warning">
                            <h4 class="modal-title">EDIT MANDOR</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="POST">
                              <?php 
                              $id_user = $data['id_user'];
                              $sql_edit = $koneksi->query("SELECT * FROM user, divisi WHERE user.id_divisi = divisi.id_divisi AND id_user='$id_user'");
                              while ($data_edit=$sql_edit->fetch_assoc()){
                              ?>
                              <div class="form-group">
                                  <input type="hidden" class="form-control" name="id_user" value="<?php echo $data_edit['id_user']?>">
                              </div>
                              <div class="form-group">
                                  <label >Nama Lengkap</label>
                                  <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $data_edit['nama_lengkap']?>" required>
                              </div>
                              <div class="form-group">
                                  <label >Alamat</label>
                                  <input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo $data_edit['alamat']?>" required>
                                  
                              </div>
                              <div class="form-group">
                                  <label >Divisi</label>
                                  <select class="form-control" id="id_divisi" name="id_divisi" style="width: 100%;" required>
                                    <option value="<?php echo $data_edit['id_divisi']?>" selected="selected"><?php echo $data_edit['nama_divisi']?></option>
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
                                  <label >Username</label>
                                  <input type="text" class="form-control" name="username" id="username" value="<?php echo $data_edit['username']?>" required>
                                  
                              </div>
                              <div class="form-group">
                                  <label >Password</label>
                                  <input type="text" class="form-control" name="password" id="password" value="<?php echo $data_edit['password']?>" required>
   
                              </div>
                              <div class="form-group">
                                <label>Level</label>
                                <select class="form-control" name="level" style="width: 100%;" required>
                                  <option selected="selected"><?php echo $data_edit['level']?></option>
                                  <option>admin</option>
                                </select>
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
                              $id_user = $_POST['id_user'];
                              $nama_lengkap = $_POST['nama_lengkap'];
                              $alamat = $_POST['alamat'];
                              $username = $_POST['username'];
                              $password = $_POST['password'];
                              $level = $_POST['level'];
                              $id_divisi = $_POST['id_divisi'];

                              $mandor = $koneksi->query("UPDATE user SET nama_lengkap='$nama_lengkap', alamat='$alamat', username='$username', password='$password', level='$level', id_divisi='$id_divisi' WHERE id_user='$id_user'");
                              
                              if($mandor){
                                ?>
                                <Script>
                                  alert("Data Berhasil Diubah");
                                  window.location.href="?page=mandor";
                                </Script>
                    
                                <?php
                              }
                            }
                          ?>
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
<div class="modal fade" id="modal-tambah_mandor">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Tambah Mandor</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="tambah_divisi" method="POST">
              <div class="form-group">
                  <label>Nama Mandor</label>
                  <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Masukan Nama Mandor" required oninvalid="this.setCustomValidity('Nama mandor tidak boleh kosong. Masukkan nama mandor.')" oninput="setCustomValidity('')">
              </div>
              <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukan Alamat" required oninvalid="this.setCustomValidity('Alamat tidak boleh kosong. Masukkan alamat Anda.')" oninput="setCustomValidity('')">
              </div>
              <div class="form-group">
                  <label>Divisi</label>
                  <select class="form-control" name="id_divisi" style="width: 100%;" required oninvalid="this.setCustomValidity('Pilih salah satu divisi.')" oninput="setCustomValidity('')">
                      <option selected="selected" disabled value="">Pilih Nama Divisi</option>
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
                  <label>Username</label>
                  <input type="text" class="form-control" name="username" id="username" placeholder="Masukan Username" required oninvalid="this.setCustomValidity('Username tidak boleh kosong. Masukkan username.')" oninput="setCustomValidity('')">
              </div>
              <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Masukan Password" required oninvalid="this.setCustomValidity('Password tidak boleh kosong. Masukkan password.')" oninput="setCustomValidity('')">
              </div>
              <div class="form-group">
                  <label>Level</label>
                  <select class="form-control" name="level" style="width: 100%;" required oninvalid="this.setCustomValidity('Pilih salah satu level.')" oninput="setCustomValidity('')">
                      <option selected="selected" disabled value="">Pilih Level</option>
                      <option value="admin">admin</option>
                      <option value="mandor">mandor</option>
                  </select>
              </div>
                </div>
                <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        <?php
        include "koneksi.php";
        if(isset($_POST['simpan'])){
            $nama_lengkap = $_POST['nama_lengkap'];
            $alamat = $_POST['alamat'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $level = $_POST['level'];
            $id_divisi = $_POST['id_divisi'];

            $data = mysqli_query($koneksi,"INSERT INTO user (nama_lengkap, alamat, username, password, level, id_divisi) VALUES ('$nama_lengkap', '$alamat', '$username', '$password', '$level', '$id_divisi')");
            if($data){
              ?>
              <Script>
                alert("Data Berhasil Disimpan")
                window.location.href="?page=mandor";
              </Script>

              <?php
            }
          }
        ?>
</div>
