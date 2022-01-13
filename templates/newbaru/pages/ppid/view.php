<?php 
$aksi = "pages/ppid/proses_ppid.php";

// mengatasi variabel yang belum di definisikan (notice undefined index)
$act = isset($_GET['act']) ? $_GET['act'] : ''; 
?>
<!-- navigasi menu -->
<header>
<?php include "header.php"; ?>
</header>
<!-- .navigasi menu -->
<section class="content-header">
    <section class="site-content">
	<div class="container">
		<div class="row">
			<div class="col-md-8 padding-bottom-20 left-column no-padding">
				<div class="breadcrumb-wrapper bg-medium margin-bottom-20">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
                            <h3>Formulir PPID</h3>
							</div> <!-- .col-md-6 -->
							
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div>
				<div class="row">
				
				<?php  
    // fungsi untuk menampilkan pesan
    // jika alert = "" (kosong)
    // tampilkan pesan "" (kosong)
    if (empty($_GET['alert'])) {
      echo "";
    } 
    // jika alert = 1
    // tampilkan pesan Sukses "portfolio baru berhasil disimpan"
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Success!</h4>
              Data Berhasil di Input, tunggu selanjutnya email dari admin.
            </div>";
    }
    // jika alert = 2
    // tampilkan pesan Sukses "portfolio berhasil diubah"
    elseif ($_GET['alert'] == 2) {
      echo "<div class='alert alert-danger alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Success!</h4>
              Gagal Input Data, Silahkan di coba kembali.
            </div>";
    }
   
    ?>
				<form method="POST" action="media.php?page=prosesppid" class="form-horizontal">
				
						<div class="form-group">
						<div class="col-sm-10">
							<label for="nama_pemohon" class="control-label">Nama Pemohon</label>
								<input type="text" class="form-control" id="nama_pemohon" name="a" required/>
								<p>Sesuai KTP <code> *)Jangan dikosongkan</code></p>
						</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="no_ktp_1" class="">No.KTP (Kartu Tanda Penduduk) Pemohon</label>
								<input type="text" class="form-control" id="no_ktp_1" name="b" required/>
								<p>Sesuai KTP <code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="alamat_1" class="">Alamat Pemohon Informasi</label>
							<textarea class="form-control" rows="2" id="alamat_1" name="c" required></textarea>
							<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="no_tlp_1" class="">No.HP (Mobile Phone)/WA Pemohon</label>
								<input type="number" class="form-control" id="no_tlp_1" name="d" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="email_1" class="">Email Pemohon</label>
								<input type="text" class="form-control" id="email_1" name="e" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="y_d_informasi" class="">Informasi Yang dibutuhkan </label>
								<input type="text" class="form-control" id="y_d_informasi" name="f" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="alasan_1" class="">Alasan Permintaan  </label>
								<input type="text" class="form-control" id="alasan_1" name="g" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<hr>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="nama_pengguna" class="">Nama Pengguna</label>
								<input type="text" class="form-control" id="nama_pengguna" name="h" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="no_ktp_2" class="">No.KTP (Kartu Tanda Penduduk) Pengguna</label>
								<input type="text" class="form-control" id="no_ktp_2" name="i" required/>
								<p>Sesuai KTP <code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="alamat_2" class="">Alamat Pengguna Informasi</label>
							<textarea class="form-control" rows="2" id="alamat_2" name="j" required></textarea>
							<p>Sesuai KTP <code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="no_tlp_1" class="">No.HP (Mobile Phone)/WA Pengguna</label>
								<input type="number" class="form-control" id="no_tlp_2" name="k" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="email_1" class="">Email Pengguna</label>
								<input type="text" class="form-control" id="email_2" name="l" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="alasan_2" class="">Alasan Penggunaan Informasi  </label>
								<input type="text" class="form-control" id="alasan_2" name="m" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="c_m_informasi" class="">Cara Memperoleh Informasi  </label>
								<select class="form-control" name="n" required>
									<option value="">-- Pilih --</option>
									<option value="langsung">Langsung</option>
									<option value="website">Website</option>
									<option value="email">Email</option>
									<option value="fax">Fax</option>
									<option value="via_pos">Via Pos</option>
								</select>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="f_b_informasi" class="">Format Bahan Informasi   </label>
								<select class="form-control" name="o" required>
									<option value="">-- Pilih --</option>
									<option value="tercetak">Tercetak</option>
									<option value="terekam">Terekam</option>
								</select>
							</div>
						</div>
						<div class="form-group">
						<div class="col-sm-10">
							<label for="c_m_b_informasi" class="">Cara Memperoleh Informasi  </label>
								<select class="form-control" name="p" required>
									<option value="">-- Pilih --</option>
									<option value="langsung">Langsung</option>
									<option value="via_pos">Via Pos</option>
									<option value="email">Email</option>
								</select>
							</div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="input">Simpan</button> 
						<button type="button" onclick="self.history.back(-1)" class="btn">Batal</button>
					</div><!-- /.box-footer -->
				</form>
				
			</div>
			<div class="col-md-4 right-column no-padding">
			<?php include "sidebarkanan.php"; ?>
			</div>
		</div>
	</div>
</section>
<!-- Footer -->
<footer>
	<div class="container">
		<div class="row">
			
			<div class="col-sm-4 border-kanan">
				<h5 class="myriadpro margin-bottom-15">Kontak Kami</h5>

				<ul class="fa-ul margin-top-15">
					<li><i class="fa-li fa-md link-default fa fa-home"></i>
					<?php echo nl2br($tiden['alamat']); ?></li>
					<li><i class="fa-li fa-md link-default fa fa-envelope"></i>
					<a href="mailto:<?php echo $tiden['email']; ?>"><?php echo $tiden['email']; ?></a></li>
					<li><i class="fa-li fa-md link-default fa fa-fax"></i>
					<?php echo $tiden['telpon']; ?></li>
				</ul>

				<ul class="list-inline icon-social icon-social-color circle">
						<li class="instagram margin-right-5 margin-top-10">
							<a target="_BLANK" href="<?php echo $tiden['fb']; ?>" title="Facebook">
							<i class="fa fa-facebook"></i>
							<span class="sr-only">Facebook</span>
							</a>
						</li>
						<li class="instagram margin-right-5 margin-top-10">
							<a target="_BLANK" href="<?php echo $tiden['twitter']; ?>" title="Twitter">
							<i class="fa fa-twitter"></i>
							<span class="sr-only">Twitter</span>
							</a>
						</li>
						<li class="instagram margin-right-5 margin-top-10">
							<a target="_BLANK" href="<?php echo $tiden['tube']; ?>" title="Youtube">
							<i class="fa fa-youtube"></i>
							<span class="sr-only">Youtube</span>
							</a>
						</li>
						<li class="instagram margin-right-5 margin-top-10">
							<a target="_BLANK" href="<?php echo $tiden['ig']; ?>" title="Instagram">
							<i class="fa fa-instagram"></i>
							<span class="sr-only">Instagram</span>
							</a>
						</li>
				</ul>
			</div>

			<div class="col-sm-4 border-custom-left border-custom-right margin-bottom-15">
			<?php
              $ip      = $_SERVER['REMOTE_ADDR']; // Mendapatkan IP komputer user
              $tanggal = date("Ymd"); // Mendapatkan tanggal sekarang
              $waktu   = time(); // 

              // Mencek berdasarkan IPnya, apakah user sudah pernah mengakses hari ini 
              $s = mysqli_query($koneksi, "SELECT * FROM statistik WHERE ip='$ip' AND tanggal='$tanggal'");
              // Kalau belum ada, simpan data user tersebut ke database
              if(mysqli_num_rows($s) == 0){
                mysqli_query($koneksi, "INSERT INTO statistik(ip, tanggal, hits, online) VALUES('$ip','$tanggal','1','$waktu')");
              } 
              else{
                mysqli_query($koneksi, "UPDATE statistik SET hits=hits+1, online='$waktu' WHERE ip='$ip' AND tanggal='$tanggal'");
              }

              $pengunjung       = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM statistik WHERE tanggal='$tanggal' GROUP BY ip"));
			  $sql1  			= mysqli_query($koneksi, "SELECT COUNT(hits) as totsum FROM statistik");
			  $totalpengunjung	= mysqli_fetch_array($sql1);
              $hits             = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(hits) as hitstoday FROM statistik WHERE tanggal='$tanggal' GROUP BY tanggal")); 
			  $sql3       		= mysqli_query($koneksi, "SELECT SUM(hits) as sum FROM statistik");
			  $tothitsgbr  		= mysqli_fetch_array($sql3);	
              $bataswaktu       = $waktu - 300;
              $pengunjungonline = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM statistik WHERE online > '$bataswaktu'"));
            ?>
				<h5 class="myriadpro margin-bottom-15">Statistik</h5>
					<b><font size="5"><?php echo number_format($tothitsgbr['sum'],0,',','.'); ?></font></b><br>
						<i class="fa fa-user"></i> Pengunjung hari ini: <?php echo $pengunjung; ?> <br>
						<i class="fa fa-users"></i> Total pengunjung: <?php echo number_format($totalpengunjung['totsum'],0,',','.'); ?> <br><br>
						<i class="fa fa-bar-chart"></i> Hits hari ini: <?php echo number_format($hits['hitstoday'],0,',','.'); ?> <br><br>
						<i class="fa fa-user-o"></i> Pengunjung Online: <?php echo $pengunjungonline; ?> <br><br>
			</div> <!-- .col-md-6 -->
			<div class="col-sm-4 border-kiri margin-bottom-15">
				<h5 class="myriadpro margin-bottom-15">Media Sosial</h5>
				<iframe src="http://www.facebook.com/plugins/likebox.php?href=<?php echo $tiden['facebook']; ?>&amp;width=350px&amp;height=350&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=352861198057415" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:220px;" allowTransparency="true"></iframe>
			</div> <!-- .col-md-6 -->
		</div> <!-- .row -->
	</div> <!-- .container -->

	<!-- footer-copyright -->
	<div class="footer-copyright custom">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 text-center">
					<p class="copyright-text">
					Copyright &copy; 2020 Website Resmi <?php echo $tiden['nama_pemilik']; ?> All Right Reserved. Powered by <a target="_blank" href="http://msnsolutindo.com"> msnsolutindo </a>
					</p>

				</div> <!-- .col-xs-12 -->
			</div> <!-- .row -->
		</div> <!-- .container -->
	</div> <!-- .footer-copyright -->
</footer>
<!-- /.Footer -->