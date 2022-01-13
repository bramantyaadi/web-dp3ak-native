<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
	$aksi = "modul/mod_kategori/aksi_kategori.php";

	// mengatasi variabel yang belum di definisikan (notice undefined index)
	$act = isset($_GET['act']) ? $_GET['act'] : ''; 
?>
	<section class="content-header">
		<h1>Kategori</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=kategori&act=tambahkategori"><i class="fa fa-plus"></i>Tambah Kategori</a></li>
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
                  <table id="datakategori" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Link</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM kategori ORDER BY id_kategori DESC";
					$tampil = mysqli_query($koneksi, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						echo "<tr><td class=\"text-center\">$no</td>
								<td>$r[nama_kategori]</td>
								<td>kategori-$r[id_kategori]-$r[kategori_seo]</td>
								<td class=\"text-center\">$r[aktif]</td>
								<td class=\"text-center\"><a href=\"?module=kategori&act=editkategori&id=$r[id_kategori]\" title=\"Edit Data\"><i class=\"fa fa-pencil\"></i></a></td>
								</tr>";
						$no++;
					}
					?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
				<div class="box-footer">
					<i>*) Data pada Kategori tidak bisa dihapus, tapi bisa di non-aktifkan melalui Edit Kategori.</i>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
<?php
		break;
		
		case "tambahkategori":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Kategori</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=kategori&act=input" class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<label for="nama_kategori" class="col-sm-2 control-label">Nama Kategori</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_kategori" name="nama_kategori" />
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
		
		case "editkategori":
			$query = "SELECT * FROM kategori WHERE id_kategori='$_GET[id]'";
			$hasil = mysqli_query($koneksi, $query);
			$r     = mysqli_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Kategori</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=kategori&act=update" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $r['id_kategori']; ?>">
					<div class="box-body">
						<div class="form-group">
							<label for="nama_kategori" class="col-sm-2 control-label">Nama Kategori</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?php echo $r['nama_kategori']; ?>" />
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