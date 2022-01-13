<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
	$aksi = "modul/mod_identitas/aksi_identitas.php";
	$query = "SELECT * FROM identitas LIMIT 1";
    $hasil = mysqli_query($koneksi, $query);
    $r     = mysqli_fetch_array($hasil);
    $twitter_widget = htmlspecialchars($r['twitter_widget']);
    $googlemap      = htmlspecialchars($r['googlemap']);
?>
	<section class="content-header">
		<h1>Identitas Website</h1>
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
			<form method="POST" enctype="multipart/form-data" action="<?php echo $aksi; ?>?module=identitas" class="form-horizontal">
				<input type="hidden" name="id" value="<?php echo $r['id_identitas']; ?>">
				<div class="box-body">
					<div class="form-group">
						<label for="nama_pemilik" class="col-sm-3 control-label">Nama Pemilik</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" value="<?php echo $r['nama_pemilik']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="judul_website" class="col-sm-3 control-label">Judul Website</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="judul_website" name="judul_website" value="<?php echo $r['nama_website']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="alamat_website" class="col-sm-3 control-label">Alamat Website</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="alamat_website" name="alamat_website" value="<?php echo $r['alamat_website']; ?>" />
							<small> Apabila website sudah di online-kan, ganti dengan nama domain website Anda. Contoh: http://namadinas.jatimprov.go.id</small>
						</div>
					</div>
					<div class="form-group">
						<label for="meta_deskripsi" class="col-sm-3 control-label">Meta Deskripsi</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="meta_deskripsi" name="meta_deskripsi" value="<?php echo $r['meta_deskripsi']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="meta_keyword" class="col-sm-3 control-label">Meta Keyword</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="meta_keyword" name="meta_keyword" value="<?php echo $r['meta_keyword']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="insta_widget" class="col-sm-3 control-label">Ganti Warna Template</label>
						<div class="col-sm-9">
							<select name="wtemp" class="form-control">
							<?php 
							if($tdin['wtemp']=="biru"){
							?>
								<option value="biru" selected>Biru</option>
								<option value="merah">Merah</option>
								<option value="hijau">Hijau</option>
								<option value="abu">Abu-abu</option>
								<option value="gold">Gold</option>
							<?php }
							elseif($tdin['wtemp']=="merah"){
							?>
								<option value="biru">Biru</option>
								<option value="merah" selected>Merah</option>
								<option value="hijau">Hijau</option>
								<option value="abu">Abu-abu</option>
								<option value="gold">Gold</option>
							<?php
							}
							elseif($tdin['wtemp']=="hijau"){
							?>
								<option value="biru">Biru</option>
								<option value="merah">Merah</option>
								<option value="hijau" selected>Hijau</option>
								<option value="abu">Abu-abu</option>
								<option value="gold">Gold</option>
							<?php
							}
							elseif($tdin['wtemp']=="abu"){
							?>
								<option value="biru">Biru</option>
								<option value="merah">Merah</option>
								<option value="hijau">Hijau</option>
								<option value="abu" selected>Abu-abu</option>
								<option value="gold">Gold</option>
							<?php
							}
							else{
							?>
								<option value="biru">Biru</option>
								<option value="merah">Merah</option>
								<option value="hijau">Hijau</option>
								<option value="abu">Abu-abu</option>
								<option value="gold" selected>Gold</option>
							<?php
							}
							?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="facebook" class="col-sm-3 control-label">Facebook Fan Page</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="facebook" name="facebook" value="<?php echo $r['facebook']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="twitter_widget" class="col-sm-3 control-label">Twitter Widget</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="twitter_widget" name="twitter_widget"><?php echo $r['twitter_widget']; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="twitter" class="col-sm-3 control-label">Facebook</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="fb" name="fb" value="<?php echo $r['fb']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="twitter" class="col-sm-3 control-label">Twitter</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="twitter" name="twitter" value="<?php echo $r['twitter']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="twitter" class="col-sm-3 control-label">Youtube Channel</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="tube" name="tube" value="<?php echo $r['tube']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="twitter" class="col-sm-3 control-label">Instagram</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="ig" name="ig" value="<?php echo $r['ig']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-3 control-label">Telepon</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="telpon" name="telpon" value="<?php echo $r['telpon']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-3 control-label">Email</label>
						<div class="col-sm-9">
							<input type="email" class="form-control" id="email" name="email" value="<?php echo $r['email']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-3 control-label">Alamat</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="alamat" name="alamat"><?php echo $r['alamat']; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="googlemap" class="col-sm-3 control-label">Gambar Favicon</label>
						<div class="col-sm-9">
							<img src="../<?php echo $r['favicon']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="fupload" class="col-sm-3 control-label">Ganti Favicon</label>
						<div class="col-sm-9">
							<input type="file" class="form-control" id="fupload" name="fupload" />
							<small>*) Apabila gambar favicon tidak diganti, dikosongkan saja.<br>
                                *) Apabila gambar favicon diganti, nama filenya harus <b>favicon.png</b> dengan ukuran <b>50 x 50 pixel</b>.</small>
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