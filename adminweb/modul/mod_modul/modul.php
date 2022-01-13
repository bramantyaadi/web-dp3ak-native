<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
	$aksi = "modul/mod_modul/aksi_modul.php";

	// mengatasi variabel yang belum di definisikan (notice undefined index)
	$act = isset($_GET['act']) ? $_GET['act'] : ''; 
?>
	<section class="content-header">
		<h1>Manajemen Modul</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=modul&act=tambahmodul"><i class="fa fa-plus"></i>Tambah Modul</a></li>
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
                  <table id="datamodul" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Urutan Modul</th>
                        <th>Nama Modul</th>
                        <th>Link</th>
                        <th>Status</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM modul ORDER BY urutan";
					$tampil = mysqli_query($konek, $query);
					while ($r=mysqli_fetch_array($tampil)){  
						echo "<tr><td class=\"text-center\">$r[urutan]</td>
								<td>$r[nama_modul]</td>
								<td>$r[link]</td>
								<td>$r[status]</td>
								<td class=\"text-center\">$r[aktif]</td>
								<td class=\"text-center\"><a href=\"?module=modul&act=editmodul&id=$r[id_modul]\" title=\"Edit Data\"><i class=\"fa fa-pencil\"></i></a></td>
								</tr>";
					}
					?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
				<div class="box-footer">
					<i>Data pada Modul tidak bisa dihapus, tapi bisa di non-aktifkan melalui Edit Modul.</i>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
<?php
		break;
		
		case "tambahmodul":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Modul</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=modul&act=input" class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<label for="nama_modul" class="col-sm-2 control-label">Nama Modul</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_modul" name="nama_modul" />
							</div>
						</div>
						<div class="form-group">
							<label for="link" class="col-sm-2 control-label">Link</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="link" name="link" />
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
		
		case "editmodul":
			$query = "SELECT * FROM modul WHERE id_modul='$_GET[id]'";
			$hasil = mysqli_query($konek, $query);
			$r     = mysqli_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Modul</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=modul&act=update" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $r['id_modul']; ?>">
					<div class="box-body">
						<div class="form-group">
							<label for="urutan" class="col-sm-2 control-label">Urutan Menu</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="urutan" name="urutan" value="<?php echo $r['urutan']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="nama_modul" class="col-sm-2 control-label">Nama Modul</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_modul" name="nama_modul" value="<?php echo $r['nama_modul']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="link" class="col-sm-2 control-label">Link</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="link" name="link" value="<?php echo $r['link']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="status" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-6">
								<?php
								if($r['status']=="admin") {
								?>
									<label><input type="radio" class="minimal" id="status" name="status" value="admin" checked> admin &nbsp; </label>
									<label><input type="radio" class="minimal" id="status" name="status" value="user"> user</label>
								<?php
								}
								elseif($r['status']=="user") {
								?>
									<label><input type="radio" class="minimal" id="status" name="status" value="admin"> admin &nbsp; </label>
									<label><input type="radio" class="minimal" id="status" name="status" value="user" checked> user</label>
								<?php
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label for="aktif" class="col-sm-2 control-label">Aktif</label>
							<div class="col-sm-6">
								<?php
								if($r['aktif']=="Y") {
								?>
									<label><input type="radio" class="minimal" id="aktif" name="aktif" value="Y" checked> Y &nbsp; </label>
									<label><input type="radio" class="minimal" id="aktif" name="aktif" value="N"> N </label>
								<?php
								}
								elseif($r['aktif']=="N") {
								?>
									<label><input type="radio" class="minimal" id="aktif" name="aktif" value="Y"> Y &nbsp; </label>
									<label><input type="radio" class="minimal" id="aktif" name="aktif" value="N" checked> N </label>
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