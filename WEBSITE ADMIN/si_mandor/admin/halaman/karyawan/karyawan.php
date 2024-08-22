<div class="col-12">
  <div class="card">
      <div class="card-header">
      <div class="card-title" style="font-size: 25px;">DATA KARYAWAN</div>
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-tambah_karyawan">
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
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>No Handphone</th>
                    <th>Aksi</th>

                  </tr>
             </thead>
                <tbody>
                <?php
                  
                  include "koneksi.php";
                  $no = 1;

                  $laporan = mysqli_query($koneksi,"SELECT * FROM karyawan, divisi WHERE karyawan.id_divisi = divisi.id_divisi");
                  while($data = mysqli_fetch_array($laporan)){
                    ?>
                    <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['nama_karyawan']; ?></td>
                    <td><?php echo $data['alamat']; ?></td>
                    <td><?php echo $data['nama_divisi']; ?></td>
                    <td><?php echo $data['tanggal_lahir']; ?></td>
                    <td><?php echo $data['jenis_kelamin']; ?></td>
                    <td><?php echo $data['hp']; ?></td>
                    <td>
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalDetail<?php echo $data['id_karyawan']?>">
                      Detail
                      </button>
                      <div class="modal fade" id="modalDetail<?php echo $data['id_karyawan']?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header bg-primary">
                                <h4 class="modal-title fw-bold">DETAIL DATA KARYAWAN</h4>
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
                                    Tanggal Lahir <br/>
                                    Jenis Kelamin <br/>
                                    No.Handpone <br/>
                                  </div>
                                  <div class="col-sm-8">
                                    : <?php echo $data['nama_karyawan'] ?> <br/>
                                    : <?php echo $data['alamat'] ?> <br/>
                                    : <?php echo $data['nama_divisi'] ?> <br/>
                                    : <?php echo $data['tanggal_lahir'] ?> <br/>
                                    : <?php echo $data['jenis_kelamin'] ?> <br/>
                                    : <?php echo $data['hp'] ?> <br/>
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
                      
                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit<?php echo $data['id_karyawan']?>">
                      Ubah
                      </button>
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalHapus<?php echo $data['id_karyawan']?>">
                      Hapus
                      </button>
                      <div class="modal fade" id="modalHapus<?php echo $data['id_karyawan']?>" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <input type="hidden" name="id_karyawan" value="<?php echo $data['id_karyawan']?>">
                                <h3>Apakah Anda Ingin Menghapus Data <?php echo $data['nama_karyawan']?> </h3>
                                <div class="modal-footer right">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-success" name="hapus">Hapus</button>
                                </div>
                              </div>
                              <?php
                              if(isset($_POST['hapus'])){
                                $id_karyawan = $_POST['id_karyawan'];
                                $sql = $koneksi->query("DELETE FROM karyawan WHERE id_karyawan='$id_karyawan'");
                                if($sql){
                                  ?>
                                  <Script>
                                    alert("Data Berhasil Dihapus");
                                    window.location.href="?page=karyawan";
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
                    <div class="modal fade" id="modalEdit<?php echo $data['id_karyawan']?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header bg-warning">
                            <h4 class="modal-title">EDIT DATA KARYAWAN</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="POST">
                              <?php 
                              $id_karyawan = $data['id_karyawan'];
                              $sql_edit = $koneksi->query("SELECT * FROM karyawan WHERE id_karyawan='$id_karyawan'");
                              while ($data_edit=$sql_edit->fetch_assoc()){
                              ?>
                              <div class="form-group">
                                  <input type="hidden" class="form-control" name="id_karyawan" value="<?php echo $data_edit['id_karyawan']?>">
                              </div>
                              <div class="form-group">
                                  <label >Nama Karyawan</label>
                                  <input type="text" class="form-control" name="nama_karyawan" value="<?php echo $data_edit['nama_karyawan']?>" required>
                              </div>
                              <div class="form-group">
                                  <label >Alamat</label>
                                  <input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo $data_edit['alamat']?>" required>
                                  
                              </div>
                              <div class="form-group">
                              <label>Divisi</label>
                                <select class="form-control" name="id_divisi" style="width: 100%;">
                                  <option value="<?php echo $data_edit['id_divisi']?>" selected="selected"><?php echo $data['nama_divisi']?></option>
                                  <?php
                                  include "koneksi.php";

                                  $query = mysqli_query($koneksi,"SELECT * FROM divisi");
                                  while($data = mysqli_fetch_array($query)){
                                    if ($divisi['id_divisi'] != $data_edit['id_divisi']) {
                                    echo "<option value=$data[id_divisi]> $data[nama_divisi] </option>";
                                  }
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                  <label >Tanggal Lahir</label>
                                  <input type="text" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="<?php echo $data_edit['tanggal_lahir']?>" required>
                                  
                              </div>
                              <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelamin" style="width: 100%;" required>
                                  <option selected="selected"><?php echo $data_edit['jenis_kelamin']?></option>
                                  <option>laki-laki</option>
                                  <option>perempuan</option>
                                </select>
                              </div>
                              <div class="form-group">
                                  <label >No.Handphone</label>
                                  <input type="text" class="form-control" name="hp" id="hp" value="<?php echo $data_edit['hp']?>" required>
                                  
                              </div>
                            
                              
                              <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary" name="ubah">Ubah</button>
                              </div>
                            <?php } ?>
                            </form>
                            <?php
                            include "koneksi.php";
                            if(isset($_POST['ubah'])) {
                                $id_karyawan = $_POST['id_karyawan'];
                                $nama_karyawan = $_POST['nama_karyawan'];
                                $alamat = $_POST['alamat'];
                                $tanggal_lahir = $_POST['tanggal_lahir'];
                                $jenis_kelamin = $_POST['jenis_kelamin'];
                                $hp = $_POST['hp'];
                                $id_divisi = $_POST['id_divisi'];
                                
                                $sql = $koneksi->query("UPDATE karyawan SET nama_karyawan='$nama_karyawan', alamat='$alamat', tanggal_lahir='$tanggal_lahir', jenis_kelamin='$jenis_kelamin', hp='$hp', id_divisi='$id_divisi' WHERE id_karyawan='$id_karyawan'");
                                
                                if($sql){
                                  ?>
                                  <Script>
                                    alert("Data Berhasil Diubah");
                                    window.location.href="?page=karyawan";
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

<div class="modal fade" id="modal-tambah_karyawan">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Tambah Karyawan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="tambah_divisi" method="POST">
              <div class="form-group">
        <label>Nama Karyawan</label>
        <input type="text" class="form-control" name="nama_karyawan" id="nama_karyawan" placeholder="Masukan Nama Karyawan" required oninvalid="this.setCustomValidity('Nama karyawan tidak boleh kosong. Masukkan nama karyawan.')" oninput="setCustomValidity('')">
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
        <label>Tanggal Lahir</label>
        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" placeholder="Masukan Tanggal Lahir" required oninvalid="this.setCustomValidity('Tanggal lahir tidak boleh kosong. Masukkan tanggal lahir.')" oninput="setCustomValidity('')">
    </div>
    <div class="form-group">
        <label>Jenis Kelamin</label>
        <select class="form-control" name="jenis_kelamin" style="width: 100%;" required oninvalid="this.setCustomValidity('Pilih jenis kelamin.')" oninput="setCustomValidity('')">
            <option selected="selected" disabled value="">Pilih Jenis Kelamin</option>
            <option value="laki-laki">Laki-laki</option>
            <option value="perempuan">Perempuan</option>
        </select>
    </div>
    <div class="form-group">
        <label>No. Handphone</label>
        <input type="text" class="form-control" name="hp" id="hp" placeholder="Masukan No Handphone" required oninvalid="this.setCustomValidity('Nomor handphone tidak boleh kosong. Masukkan nomor handphone.')" oninput="setCustomValidity('')">
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
            $nama_karyawan = $_POST['nama_karyawan'];
            $alamat = $_POST['alamat'];
            $tanggal_lahir = $_POST['tanggal_lahir'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $hp = $_POST['hp'];
            $id_divisi = $_POST['id_divisi'];

            $data = mysqli_query($koneksi,"INSERT INTO karyawan (nama_karyawan, alamat, tanggal_lahir, jenis_kelamin, hp, id_divisi) VALUES ('$nama_karyawan', '$alamat', '$tanggal_lahir', '$jenis_kelamin', '$hp', '$id_divisi')");
            if($data){
              ?>
              <Script>
                alert("Data Berhasil Disimpan")
                window.location.href="?page=karyawan";
              </Script>

              <?php
            }
          }
        ?>
</div>
