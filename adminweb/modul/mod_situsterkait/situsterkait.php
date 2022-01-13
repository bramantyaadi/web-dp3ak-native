<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
	$aksi = "modul/mod_situsterkait/aksi_situsterkait.php";

	// mengatasi variabel yang belum di definisikan (notice undefined index)
	$act = isset($_GET['act']) ? $_GET['act'] : ''; 
?>
	<section class="content-header">
		<h1>Situs Terkait</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=situsterkait&act=tambahsitus"><i class="fa fa-plus"></i>Tambah situs</a></li>
        </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
<?php
	switch($act){
		// Tampil Kategori
		default:
?>
              <div class="box">
                <div class="box-body">
                  <table id="datasitus" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Situs</th>
                        <th>Url</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM situs ORDER BY id_situs DESC";
					$tampil = mysqli_query($koneksi, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						echo "<tr><td class=\"text-center\">$no</td>
								<td>$r[nama_situs]</td>
								<td>$r[url]</td>
								<td class=\"text-center\">$r[aktif]</td>
								<td class=\"text-center\"><a href=\"?module=situsterkait&act=editsitus&id=$r[id_situs]\" title=\"Edit Data\"><i class=\"fa fa-pencil\"></i></a></td>
								</tr>";
						$no++;
					}
					?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
				<div class="box-footer">
					<i>*) Data pada Situs tidak bisa dihapus, tapi bisa di non-aktifkan melalui Edit Situs Terkait.</i>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
<?php
		break;
		
		case "tambahsitus":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Situs</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=situsterkait&act=input" class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<label for="nama_situs" class="col-sm-2 control-label">Nama Situs</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_situs" name="nama_situs" />
							</div>
            </div>
            <div class="form-group">
							<label for="nama_situs" class="col-sm-2 control-label">URL</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="url" name="url" />
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
		
		case "editsitus":
			$query = "SELECT * FROM situs WHERE id_situs='$_GET[id]'";
			$hasil = mysqli_query($koneksi, $query);
			$r     = mysqli_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Situs Terkait</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=situsterkait&act=update" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $r['id_situs']; ?>">
					<div class="box-body">
						<div class="form-group">
							<label for="nama_situs" class="col-sm-2 control-label">Nama Situs</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_situs" name="nama_situs" value="<?php echo $r['nama_situs']; ?>" />
							</div>
            </div>
            <div class="form-group">
							<label for="url" class="col-sm-2 control-label">URL</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="url" name="url" value="<?php echo $r['url']; ?>" />
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