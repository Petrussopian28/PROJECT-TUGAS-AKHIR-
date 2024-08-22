<div class="col-12">
  <div class="card">
      <div class="card-header">
        
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-tambah_divisi">
            Tambah Data
        </button>
        <div class="card-title" style="font-size: 25px;">DATA DIVISI</div>
      </div>
              <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Blok</th>
                    <th>Jumlah Blok</th>
                    <th>Nama Asisten</th>
                    <th>Aksi</th>
                  </tr>
             </thead>
                <tbody>
                <?php
                  
                  include "koneksi.php";
                  $no = 1;

                  $laporan = mysqli_query($koneksi,"SELECT * FROM divisi ORDER BY id_divisi DESC");
                  while($data = mysqli_fetch_array($laporan)){
                    ?>
                    <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['nama_divisi']; ?></td>
                    <td><?php echo $data['jumlah_blok']; ?></td>
                    <td><?php echo $data['nama_asisten']; ?></td>
                    <td>
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalDetail<?php echo $data['id_divisi']?>">
                      Detail
                      </button>
                      <div class="modal fade" id="modalDetail<?php echo $data['id_divisi']?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header bg-primary">
                                <h4 class="modal-title fw-bold">DETAIL DATA DIVISI</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col sm-4">
                                    Nama Divisi <br/>
                                    Jumlah Blok <br/>
                                    Nama Asisten <br/>
                                  </div>
                                  <div class="col-sm-8">
                                    : <?php echo $data['nama_divisi'] ?> <br/>
                                    : <?php echo $data['jumlah_blok'] ?> <br/>
                                    : <?php echo $data['nama_asisten'] ?> <br/>
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
                      
                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit<?php echo $data['id_divisi']?>">
                      Ubah
                      </button>
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalHapus<?php echo $data['id_divisi']?>">
                      Hapus
                      </button>
                      <div class="modal fade" id="modalHapus<?php echo $data['id_divisi']?>" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <input type="hidden" name="id_divisi" value="<?php echo $data['id_divisi']?>">
                                <h3>Apakah Anda Ingin Menghapus Data <?php echo $data['nama_divisi']?> </h3>
                                <div class="modal-footer right">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-success" name="hapus">Hapus</button>
                                </div>
                              </div>
                              <?php
                              if(isset($_POST['hapus'])){
                                $id_divisi = $_POST['id_divisi'];
                                $sql = $koneksi->query("DELETE FROM divisi WHERE id_divisi='$id_divisi'");
                                if($sql){
                                  ?>
                                  <Script>
                                    alert("Data Berhasil Dihapus");
                                    window.location.href="?page=divisi";
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
                    <!-- MODAL EDIT -->
                    <div class="modal fade" id="modalEdit<?php echo $data['id_divisi']?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header bg-warning">
                            <h4 class="modal-title">EDIT DIVISI</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="POST">
                              <?php 
                              $id_divisi = $data['id_divisi'];
                              $sql_edit = $koneksi->query("SELECT * FROM divisi WHERE id_divisi='$id_divisi'");
                              while ($data_edit=$sql_edit->fetch_assoc()){
                              ?>
                              <div class="form-group">
                                  <input type="hidden" class="form-control" name="id_divisi" value="<?php echo $data_edit['id_divisi']?>">
                              </div>
                              <div class="form-group">
                                  <label >Nama Divisi</label>
                                  <input type="text" class="form-control" name="nama_divisi" value="<?php echo $data_edit['nama_divisi']?>" placeholder="Masukan Nama DIvisi" required>
                              </div>
                              <div class="form-group">
                                  <label >Jumlah Blok</label>
                                  <input type="text" class="form-control" name="jumlah_blok" id="jumlah_blok" value="<?php echo $data_edit['jumlah_blok']?>" placeholder="Masukan Jumlah Blok" required>
                                  
                              </div>
                              <div class="form-group">
                                  <label >Nama Asisten</label>
                                  <input type="text" class="form-control" name="nama_asisten" id="nama_asisten" value="<?php echo $data_edit['nama_asisten']?>" placeholder="Masukan Nama Asisten" required>
                                  
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
                                $id_divisi = $_POST['id_divisi'];
                                $nama_divisi = $_POST['nama_divisi'];
                                $jumlah_blok = $_POST['jumlah_blok'];
                                $nama_asisten = $_POST['nama_asisten'];

                                $sql = $koneksi->query("UPDATE divisi SET nama_divisi='$nama_divisi', jumlah_blok='$jumlah_blok', nama_asisten='$nama_asisten' WHERE id_divisi='$id_divisi'");
                                
                                if($sql){
                                  ?>
                                  <Script>
                                    alert("Data Berhasil Diubah");
                                    window.location.href="?page=divisi";
                                  </Script>
                      
                                  <?php
                                }
                              }
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
            <!-- akhir modal edit -->

                    <?php
                  }
                  ?>
                </tbody>
            </table>
          </div>
  </div>
</div>


<div class="modal fade" id="modal-tambah_divisi">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">Tambah Divisi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="tambah_divisi" method="POST">
                <div class="form-group">
                    <label >Nama Divisi</label>
                    <input type="text" class="form-control" name="nama_divisi" id="nama_divisi"  placeholder="Masukan Nama Divisi" required=>
                   
                </div>
                <div class="form-group">
                    <label >Jumlah Blok</label>
                    <input type="text" class="form-control" name="jumlah_blok" id="jumlah_blok"  placeholder="Masukan Jumlah Blok "required>
                    
                </div>
                <div class="form-group">
                    <label >Nama Asisten</label>
                    <input type="text" class="form-control" name="nama_asisten" id="nama_asisten"  placeholder="Masukan Nama Asisten" required>
                    
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
            $nama_divisi = $_POST['nama_divisi'];
            $jumlah_blok = $_POST['jumlah_blok'];
            $nama_asisten = $_POST['nama_asisten'];

            $data = mysqli_query($koneksi,"INSERT INTO divisi (nama_divisi, jumlah_blok, nama_asisten) VALUES ('$nama_divisi', '$jumlah_blok', '$nama_asisten')");
            if($data){
              ?>
              <Script>
                alert("Data Berhasil Disimpan")
                window.location.href="?page=divisi";
              </Script>

              <?php
            }
          }
        ?>
</div>
