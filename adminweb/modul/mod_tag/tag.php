<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
	$aksi = "modul/mod_tag/aksi_tag.php";

	// mengatasi variabel yang belum di definisikan (notice undefined index)
	$act = isset($_GET['act']) ? $_GET['act'] : ''; 
?>
	<section class="content-header">
		<h1>Tag Berita</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=tag&act=tambahtag"><i class="fa fa-plus"></i>Tambah Tag</a></li>
        </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
<?php
	switch($act){
		// Tampil Modul
		default:
?>
              <div class="box">
                <div class="box-body">
                  <table id="datatag" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama tag</th>
                        <th>Topik Pilihan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM tag ORDER BY id_tag DESC";
					$tampil = mysqli_query($konek, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						echo "<tr><td class=\"text-center\">$no</td>
								<td>$r[nama_tag]</td>
								<td class=\"text-center\">$r[pilihan]</td>
								<td class=\"text-center\"><a href=\"?module=tag&act=edittag&id=$r[id_tag]\" title=\"Edit Data\"><i class=\"fa fa-pencil\"></i></a> &nbsp; 
								<a href=\"$aksi?module=tag&act=hapus&id=$r[id_tag]\" onclick=\"return confirm('APAKAH ANDA YAKIN AKAN MENGHAPUS TAG INI ?')\" title=\"Hapus Data\"><i class=\"fa fa-trash text-red\"></i></a></td>
								</tr>";
						$no++;
					}
					?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
				<div class="box-footer">
					<i>*) Apabila Tag dijadikan Berita Pilihan (hot news), ubah Pilihan menjadi Y.</i>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
<?php
		break;
		
		case "tambahtag":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Tag Berita</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=tag&act=input" class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<label for="nama_tag" class="col-sm-2 control-label">Nama Tag</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_tag" name="nama_tag" />
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
		
		case "edittag":
			$query = "SELECT * FROM tag WHERE id_tag='$_GET[id]'";
			$hasil = mysqli_query($konek, $query);
			$r     = mysqli_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Tag Berita</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=tag&act=update" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $r['id_tag']; ?>">
					<div class="box-body">
						<div class="form-group">
							<label for="nama_tag" class="col-sm-2 control-label">Nama tag</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_tag" name="nama_tag" value="<?php echo $r['nama_tag']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="pilihan" class="col-sm-2 control-label">Pilihan</label>
							<div class="col-sm-6">
								<?php
								if($r['pilihan']=="Y") {
								?>
									<label><input type="radio" class="minimal" id="pilihan" name="pilihan" value="Y" checked> Y &nbsp; </label>
									<label><input type="radio" class="minimal" id="pilihan" name="pilihan" value="N"> N </label>
								<?php
								}
								elseif($r['pilihan']=="N") {
								?>
									<label><input type="radio" class="minimal" id="pilihan" name="pilihan" value="Y"> Y &nbsp; </label>
									<label><input type="radio" class="minimal" id="pilihan" name="pilihan" value="N" checked> N </label>
								<?php
								}
								?>
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
		</div>
	</section>
<?php
}
?>