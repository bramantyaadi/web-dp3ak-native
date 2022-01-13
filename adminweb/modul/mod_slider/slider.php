<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_slider/aksi_slider.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : '';  
?>
	<section class="content-header">
		<h1>Slider</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=slider&act=tambahslider"><i class="fa fa-plus"></i>Tambah Slider</a></li>
        </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
<?php

  switch($act){
    // Tampil Banner
    default:
?>
              <div class="box">
                <div class="box-body">
                  <table id="databanner" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Link</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM slider ORDER BY id_slider DESC";
					$tampil = mysqli_query($koneksi, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						echo "<tr><td>$no</td>
							<td><img src=\"../foto_slider/small_$r[gmb_slider]\"></td>
							<td><a href=\"$r[link]\" target=\"_blank\">$r[link]</a></td>
							<td align=\"center\"><a href=\"?module=slider&act=editslider&id=$r[id_slider]\" title=\"Edit Data\"><i class=\"fa fa-pencil\"></i></a> &nbsp; 
							<a href=\"$aksi?module=slider&act=hapus&id=$r[id_slider]\" onclick=\"return confirm('APAKAH ANDA YAKIN AKAN MENGHAPUS SLIDER INI ?')\" title=\"Hapus Data\"><i class=\"fa fa-trash text-red\"></i></a></td>
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
	
	case "tambahslider":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Slider</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=slider&act=input" class="form-horizontal" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="link" class="col-sm-2 control-label">Link Slider</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="link" name="link" required />
								<small>* Contoh : <b>https://dp3ak.jatimprov.go.id/</b></small>
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Gambar Slider</label>
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
	
	case "editslider":
      $query = "SELECT * FROM slider WHERE id_slider='$_GET[id]'";
      $hasil = mysqli_query($koneksi, $query);

      $r = mysqli_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Slider</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=slider&act=update" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $r['id_slider']; ?>" />
					<div class="box-body">
						<div class="form-group">
							<label for="link" class="col-sm-2 control-label">Link</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="link" name="link" value="<?php echo $r['link']; ?>" />
								<small>* Contoh : <b>https://dp3ak.jatimprov.go.id/</b></small>
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Gambar Slider</label>
							<div class="col-sm-10">
								<?php
								if ($r['gmb_slider']!=''){
									echo "<img src=\"../foto_slider/small_$r[gmb_slider]\">";  
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