<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
	$aksi = "modul/mod_logo/aksi_logo.php";
	$query = "SELECT id_identitas, logo FROM identitas LIMIT 1";
    $hasil = mysqli_query($koneksi, $query);
    $r     = mysqli_fetch_array($hasil);
?>
	<section class="content-header">
		<h1>Logo Website</h1>
	</section>
	
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box">
		<?php			
		if(isset($_GET['r'])) {
			if($_GET['r']=="sukses") {
		?>
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> SUKSES!</h4>
					Data BERHASIL di SIMPAN!
				</div>
		<?php
			}
			elseif($_GET['r']=="gagal") {
		?>
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-ban"></i> GAGAL!</h4>
					Data GAGAL di SIMPAN!
			</div>
		<?php
			}
		}
		?>
			<form method="POST" enctype="multipart/form-data" action="<?php echo $aksi; ?>?module=logo" class="form-horizontal">
				<input type="hidden" name="id" value="<?php echo $r['id_identitas']; ?>">
				<div class="box-body">
					<div class="form-group">
						<label for="googlemap" class="col-sm-3 control-label">Gambar Logo Header Web</label>
						<div class="col-sm-9">
							<img src="../images/<?php echo $r['logo']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="fupload" class="col-sm-3 control-label">Ganti Logo</label>
						<div class="col-sm-9">
							<input type="file" class="form-control" id="fupload" name="fupload" />
							<small>*) Apabila gambar logo diganti, ukuran harus <b>267 x 69 pixel</b><br>Untuk contoh file Photoshop bisa di download <a href="../images/logoweb.psd" target="_blank">disini</a>.</small>
						</div>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<button type="submit" class="btn btn-primary">Update</button> <button type="button" onclick="self.history.back()" class="btn">Batal</button>
				</div><!-- /.box-footer -->
			</form>
		</div><!-- /.box -->
	</section><!-- /.content -->
<?php
}
?>