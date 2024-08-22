<div class="col-12">
  <div class="card">
      <div class="card-header">
      <div class="card-title" style="font-size: 25px;">DATA BLOK</div>
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-tambah_blok">
            Tambah Data
        </button>
      </div>
              <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Blok</th>
                    <th>Divisi</th>
                    <th>Luas Blok(Ha)</th>
                    <th>Tahun Tanam</th>
                    <th>Jumlah Pokok</th>
                    <th>Jenis Tanah</th>
                    <th>Aksi</th>
                  </tr>
             </thead>
                <tbody>
                <?php
                  
                  include "koneksi.php";
                  $no = 1;

                  $blok = mysqli_query($koneksi,"SELECT * FROM blok, divisi WHERE blok.id_divisi = divisi.id_divisi");
                  while($data = mysqli_fetch_array($blok)){
                    ?>
                    <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['nama_blok']; ?></td>
                    <td><?php echo $data['nama_divisi']; ?></td>
                    <td><?php echo $data['luas']; ?></td>
                    <td><?php echo $data['tahun_tanam']; ?></td>
                    <td><?php echo $data['jumlah_pokok']; ?></td>
                    <td><?php echo $data['jenis_tanah']; ?></td>
                    <td>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalDetail<?php echo $data['id_blok']?>">
                    Detail
                    </button>
                    <div class="modal fade" id="modalDetail<?php echo $data['id_blok']?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header bg-primary">
                                <h4 class="modal-title fw-bold">DETAIL DATA BLOK</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col sm-4">
                                    Nama Blok <br/>
                                    Divisi <br/>
                                    Luas Blok(Ha) <br/>
                                    Tahun Tanam <br/>
                                    Jumlah Pokok <br/>
                                    Jenis Tanah <br/>
                                  </div>
                                  <div class="col-sm-8">
                                    : <?php echo $data['nama_blok'] ?> <br/>
                                    : <?php echo $data['nama_divisi'] ?> <br/>
                                    : <?php echo $data['luas'] ?> <br/>
                                    : <?php echo $data['tahun_tanam'] ?> <br/>
                                    : <?php echo $data['jumlah_pokok'] ?> <br/>
                                    : <?php echo $data['jenis_tanah'] ?> <br/>
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

                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit<?php echo $data['id_blok']?>">
                    Ubah
                    </button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDetail">
                    Hapus
                    </button>
                    </td>
                    </tr>
                    <div class="modal fade" id="modalEdit<?php echo $data['id_blok']?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header bg-warning">
                            <h4 class="modal-title">EDIT BLOK</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="POST">
                              <?php 
                              $id_blok = $data['id_blok'];
                              $sql_edit = $koneksi->query("SELECT * FROM blok, divisi WHERE blok.id_divisi = divisi.id_divisi AND id_blok='$id_blok'");
                              while ($data_edit=$sql_edit->fetch_assoc()){
                              ?>
                              <div class="form-group">
                                  <input type="hidden" class="form-control" name="id_blok" value=" <?php echo $data_edit['id_blok'] ?>">
                              </div>
                              <div class="form-group">
                                  <label >Nama Blok</label>
                                  <input type="text" class="form-control" name="nama_blok" value="<?php echo $data_edit['nama_blok']?>" placeholder="Masukan Nama Blok">
                              </div>
                              <div class="form-group">
                                  <label >Divisi</label>
                                  <select class="form-control" id="id_divisi" name="id_divisi" style="width: 100%;">
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
                                  <label >Luas</label>
                                  <input type="text" class="form-control" name="luas" id="luas" value="<?php echo $data_edit['luas']?>" placeholder="Masukan Luas Blok">
                              </div>
                              <div class="form-group">
                                  <label >Tahun Tanam</label>
                                  <input type="text" class="form-control" name="tahun_tanam" id="tahun_tanam" value="<?php echo $data_edit['tahun_tanam']?>" placeholder="Masukan Username">  
                              </div>
                              <div class="form-group">
                                  <label >Jumlah Pokok</label>
                                  <input type="text" class="form-control" name="jumlah_pokok" id="jumlah_pokok" value="<?php echo $data_edit['jumlah_pokok']?>" placeholder="Masukan Username">
   
                              </div>
                              <div class="form-group">
                                <label>Jenis Tanah</label>
                                <select class="form-control" name="jenis_tanah" style="width: 100%;">
                                  <option selected="selected"><?php echo $data_edit['jenis_tanah']?></option>
                                  <option>inti</option>
                                  <option>plasma</option>
                                </select>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" name="edit">Ubah</button>
                              </div>
                              <?php } ?>
                            </form>
                            <?php
                            if(isset($_POST['edit'])) {
                                $id_blok = $_POST['id_blok'];
                                $nama_blok = $_POST['nama_blok'];
                                $luas = $_POST['luas'];
                                $tahun_tanam = $_POST['tahun_tanam'];
                                $jumlah_pokok = $_POST['jumlah_pokok'];
                                $jenis_tanah = $_POST['jenis_tanah'];
                                $id_divisi = $_POST['id_divisi'];
                                
                                $blok = $koneksi->query("UPDATE blok SET nama_blok='$nama_blok', luas='$luas', tahun_tanam='$tahun_tanam', jumlah_pokok='$jumlah_pokok', jenis_tanah='$jenis_tanah', id_divisi='$id_divisi' WHERE id_blok='$id_blok'");
                                
                                if($blok){
                                  ?>
                                  <Script>
                                    alert("Data Berhasil Diubah");
                                    window.location.href="?page=blok";
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
<div class="modal fade" id="modal-tambah_blok">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Tambah Blok</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="tambah_divisi" method="POST">
                <div class="form-group">
                    <label >Nama Blok</label>
                    <input type="text" class="form-control" name="nama_blok" id="nama_blok"  placeholder="Masukan Nama Blok" required=>
                   
                </div>
                <div class="form-group">
                <label>Divisi</label>
                  <select class="form-control" name="id_divisi" style="width: 100%;">
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
                    <label >Luas Blok(Ha)</label>
                    <input type="text" class="form-control" name="luas" id="luas"  placeholder="Masukan luas" required=>
                   
                </div>
        
                <div class="form-group">
                    <label >Tahun Tanam</label>
                    <input type="text" class="form-control" name="tahun_tanam" id="tahun_tanam"  placeholder="Masukan Tahun Tanam" required>
                    
                </div>
                <div class="form-group">
                    <label >Jumlah Pokok</label>
                    <input type="text" class="form-control" name="jumlah_pokok" id="jumlah_pokok"  placeholder="Masukan Jumlah Pokok" required>
                    
                </div>
                <div class="form-group">
                  <label>Jenis Tanah</label>
                  <select class="form-control" name="jenis_tanah" style="width: 100%;">
                    <option selected="selected">inti</option>
                    <option>plasma</option>
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
            $nama_blok = $_POST['nama_blok'];
            $luas = $_POST['luas'];
            $tahun_tanam = $_POST['tahun_tanam'];
            $jumlah_pokok = $_POST['jumlah_pokok'];
            $jenis_tanah = $_POST['jenis_tanah'];
            $id_divisi = $_POST['id_divisi'];

            $data = mysqli_query($koneksi,"INSERT INTO blok (nama_blok, luas, tahun_tanam, jumlah_pokok, jenis_tanah, id_divisi) VALUES ('$nama_blok', '$luas', '$tahun_tanam', '$jumlah_pokok', '$jenis_tanah', '$id_divisi')");
            if($data){
              ?>
              <Script>
                alert("Data Berhasil Disimpan")
                window.location.href="?page=blok";
              </Script>

              <?php
            }
          }
        ?>
</div>