<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_banner/aksi_banner.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : '';  
?>
	
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
                        <th>Judul</th>
                        <th>Link</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM banner ORDER BY id_banner DESC";
					$tampil = mysqli_query($koneksi, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						echo "<tr><td>$no</td>
							<td>$r[judul]</td>
							<td><a href=\"$r[link]\" target=\"_blank\">$r[link]</a></td>
							<td align=\"center\"><a href=\"?module=banner&act=editbanner&id=$r[id_banner]\" title=\"Ganti Banner\"><i class=\"fa fa-pencil\"></i></a> &nbsp; 
							</td>
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
	
	case "editbanner":
      $query = "SELECT * FROM banner WHERE id_banner='$_GET[id]'";
      $hasil = mysqli_query($koneksi, $query);

      $r = mysqli_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Banner</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=banner&act=update" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $r['id_banner']; ?>" />
					<div class="box-body">
						<div class="form-group">
							<label for="judul" class="col-sm-2 control-label">Judul</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="judul" name="judul" value="<?php echo $r['judul']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="link" class="col-sm-2 control-label">Link</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="link" name="link" value="<?php echo $r['link']; ?>" />
								<small>* Contoh : <b>http://www.dp3ak.jatimprov.go.id</b></small>
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Gambar</label>
							<div class="col-sm-10">
								<?php
								if ($r['gambar']!=''){
									echo "<img src=\"../foto_banner/$r[gambar]\">";  
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
								<small>Ukuran gambar banner yang di upload adalah 367x325 px.</small>
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