<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_galerifoto/aksi_galerifoto.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : '';  
?>
	<section class="content-header">
		<h1>Galeri Foto</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=galerifoto&act=tambahgalerifoto"><i class="fa fa-plus"></i>Tambah Galeri Photo</a></li>
        </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
<?php

  switch($act){
    // Tampil Galeri Foto
    default:
?>
              <div class="box">
                <div class="box-body">
                  <table id="datagalerifoto" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Judul Foto</th>
                        <th>Album Photo</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM gallery,album WHERE gallery.id_album = album.id_album ORDER BY id_gallery DESC";
					$tampil = mysqli_query($koneksi, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						echo "<tr><td>$no</td>
							<td><img src=\"../img_galeri/kecil_$r[gbr_gallery]\" width=\"100\" height=\"75\"></td>
							<td>$r[jdl_gallery]</td>
							<td>$r[jdl_album]</td>
							<td align=\"center\"><a href=\"?module=galerifoto&act=editgalerifoto&id=$r[id_gallery]\"><i class=\"fa fa-pencil\"></i></a> &nbsp; <a href=\"$aksi?module=galerifoto&act=hapus&id=$r[id_gallery]\" onclick=\"return confirm('APAKAH ANDA YAKIN AKAN MENGHAPUS FOTO INI ?')\"><i class=\"fa fa-trash text-red\"></i></a></td>
							</tr>";
						$no++;
					}
					?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
<?php
	break;
	
	case "tambahgalerifoto":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Galeri Foto</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=galerifoto&act=input" class="form-horizontal" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="judul_galeri" class="col-sm-2 control-label">Judul Foto</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="judul_galeri" name="judul_galeri" />
							</div>
						</div>
						<div class="form-group">
							<label for="album" class="col-sm-2 control-label">Album Photo</label>
							<div class="col-sm-10">
								<select class="form-control select2" id="album" name="album">
									<option value="0" selected>- Pilih Album Photo -</option>
									<?php
									$query  = "SELECT * FROM album ORDER BY id_album DESC";
									$tampil = mysqli_query($koneksi, $query);
									while($r=mysqli_fetch_array($tampil)){
										echo "<option value=\"$r[id_album]\">$r[jdl_album]</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="keterangan" class="col-sm-2 control-label">Keterangan</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="keterangan" name="keterangan" />
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Foto</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="fupload" name="fupload" />
								<small>- Tipe foto harus JPG/JPEG</small>
							</div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Simpan</button> <button type="button" onclick="self.history.back()" class="btn">Batal</button>
					</div><!-- /.box-footer -->
				</form>
            </div><!-- /.box -->
<?php
	break;
	
	case "editgalerifoto":
      $query = "SELECT * FROM gallery WHERE id_gallery='$_GET[id]'";
      $hasil = mysqli_query($koneksi, $query);

      $r = mysqli_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Galeri Foto</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=galerifoto&act=update" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $r['id_gallery']; ?>" />
					<div class="box-body">
						<div class="form-group">
							<label for="judul_galeri" class="col-sm-2 control-label">Judul Foto</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="judul_galeri" name="judul_galeri" value="<?php echo $r['jdl_gallery']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="album" class="col-sm-2 control-label">Album Photo</label>
							<div class="col-sm-10">
								<select class="form-control select2" id="album" name="album">
									<?php if ($r['id_album']==0){ ?>
									<option value="0" selected>- Pilih Album Photo -</option>
									<?php
									}
									$query2  = "SELECT * FROM album ORDER BY id_album DESC";
									$tampil2 = mysqli_query($koneksi, $query2);
									while($w=mysqli_fetch_array($tampil2)){
										if ($r['id_album']==$w['id_album']){
											echo "<option value=\"$w[id_album]\" selected>$w[jdl_album]</option>";
										} else {
											echo "<option value=\"$w[id_album]\">$w[jdl_album]</option>";
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="keterangan" class="col-sm-2 control-label">Keterangan</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $r['keterangan']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Gambar</label>
							<div class="col-sm-10">
								<?php
								if ($r['gbr_gallery']!=''){
									echo "<img src=\"../img_galeri/kecil_$r[gbr_gallery]\">";  
								}
								else{
									echo "Belum ada foto";
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Ganti Gambar</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="fupload" name="fupload" />
								<small>- Apabila gambar tidak diganti, dikosongkan saja.</small>
							</div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Update</button> <button type="button" onclick="self.history.back()" class="btn">Batal</button>
					</div><!-- /.box-footer -->
				</form>
              </div><!-- /.box -->
<?php
	break;
  }
?>
            </div><!-- /.col -->
		</div><!-- /.row -->
	</section><!-- /.section -->
<?php
}
?>