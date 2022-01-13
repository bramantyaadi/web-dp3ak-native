<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_album/aksi_album.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : '';  
?>
	<section class="content-header">
		<h1>Album Photo</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=album&act=tambahalbum"><i class="fa fa-plus"></i>Tambah Album Photo</a></li>
        </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
<?php

  switch($act){
    // Tampil Album
    default:
?>
              <div class="box">
                <div class="box-body">
                  <table id="dataalbum" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Judul Album</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM album ORDER BY id_album DESC";
					$tampil = mysqli_query($koneksi, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						echo "<tr><td>$no</td>
							<td>$r[jdl_album]</td>
							<td align=\"center\">$r[aktif]</td>
							<td align=\"center\"><a href=\"?module=album&act=editalbum&id=$r[id_album]\"><i class=\"fa fa-pencil\"></i></a></td>
							</tr>";
						$no++;
					}
					?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
				<div class="box-footer">
					<i>*) Album Photo tidak bisa dihapus, tapi bisa di non-aktifkan melalui Edit Album Photo.</i>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
<?php
	break;
	
	case "tambahalbum":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Album Photo</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=album&act=input" class="form-horizontal" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="nama_album" class="col-sm-2 control-label">Judul Album</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="nama_album" name="nama_album" />
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Gambar</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="fupload" name="fupload" required />
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
	
	case "editalbum":
      $query = "SELECT * FROM album WHERE id_album='$_GET[id]'";
      $hasil = mysqli_query($koneksi, $query);

      $r = mysqli_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Album</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=album&act=update" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $r['id_album']; ?>" />
					<div class="box-body">
						<div class="form-group">
							<label for="nama_album" class="col-sm-2 control-label">Nama Album</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="nama_album" name="nama_album" value="<?php echo $r['jdl_album']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="aktif" class="col-sm-2 control-label">Aktif</label>
							<div class="col-sm-6">
								<?php if($r['aktif']=="Y") { ?>
									<label><input type="radio" class="minimal" id="aktif" name="aktif" value="Y" checked /> Y &nbsp; </label>
									<label><input type="radio" class="minimal" id="aktif" name="aktif" value="N" /> N </label>
								<?php } else { ?>
									<label><input type="radio" class="minimal" id="aktif" name="aktif" value="Y" /> Y &nbsp; </label>
									<label><input type="radio" class="minimal" id="aktif" name="aktif" value="N" checked /> N </label>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Gambar</label>
							<div class="col-sm-10">
								<?php
								if ($r['gbr_album']!=''){
									echo "<img src=\"../img_album/kecil_$r[gbr_album]\">";  
								}
								else{
									echo "Belum ada gambar";
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