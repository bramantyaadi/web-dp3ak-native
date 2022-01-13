<!-- navigasi menu -->
<header>
<?php include "header.php"; ?>
</header>
<!-- .navigasi menu -->
<section class="site-content">
  <div class="container">
	<div class="row">
<?php
 if (isset($_COOKIE["poling"])) {
   echo "<h3><center>Sorry, anda sudah pernah melakukan voting terhadap poling ini.</center></h3>";
 }
 else{
  // membuat cookie dengan nama poling
  // cookie akan secara otomatis terhapus dalam waktu 24 jam
  setcookie("poling", "sudah poling", time() + 3600 * 24);
  $u=mysqli_query($koneksi, "UPDATE poling SET rating=rating+1 WHERE id_poling='$_POST[pilihan]'");
?>
	  <div class="col-md-12 padding-bottom-20 left-column no-padding">
		<div class="breadcrumb-wrapper bg-medium margin-bottom-20">
		  <div class="container-fluid no-padding">
			<div class="row">
			  <div class="col-md-6 col-sm-6 col-xs-12">
				<h1 class="breadcrumb-page-title">Hasil Jajak Pendapat</h1>


			  </div> <!-- .col-md-6 -->
			  <div class="col-md-6 col-sm-6 col-xs-12">
				<ol class="breadcrumb">
				  <li><a href="./">Beranda</a></li>
				  <li>Hasil Jajak Pendapat</li>
				</ol>
			  </div> <!-- .col-md-6 -->
			</div> <!-- .row -->
		  </div> <!-- .container -->
		</div> <!-- .breadcrumb-wrapper -->
		<div class="row">
		<?php 
		$pertanyaan=mysqli_query($koneksi, "SELECT * FROM poling WHERE aktif='Y' and status='Pertanyaan'");
		$dperta=mysqli_fetch_array($pertanyaan)
		?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td align="left" valign="middle"><strong>Pertanyaan:</strong></td>
						<td align="center" valign="middle">&nbsp;</td>
						<td colspan="3" align="left" valign="middle">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="5" align="left" valign="middle"><?php echo $dperta['pilihan']; ?></td>
					  </tr>
					  <tr>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="center" valign="middle">&nbsp;</td>
						<td colspan="3" align="left" valign="middle">&nbsp;</td>
					  </tr>
					  <tr>
						<td align="left" valign="middle"><strong>Pilihan</strong></td>
						<td align="center" valign="middle">&nbsp;</td>
						<td colspan="3" align="left" valign="middle"><strong>Hasil Persentase (%)</strong></td>
					  </tr>
					  <?php 
					     $jml=mysqli_query($koneksi, "SELECT SUM(rating) as jml_vote FROM poling WHERE aktif='Y'");
						  $j=mysqli_fetch_array($jml);
						  
						  $jml_vote=$j['jml_vote'];
						  
						  $sql=mysqli_query($koneksi, "SELECT * FROM poling WHERE aktif='Y' and status='Jawaban'");
						  
						  while ($s=mysqli_fetch_array($sql)){
						  	
						  	$prosentase = sprintf("%2.1f",(($s['rating']/$jml_vote)*100));
						  	$gbr_vote   = $prosentase * 3;
						 
					  ?>
					  <tr class="teks_utama">
						<td width="23%" align="left" valign="middle" bgcolor="#EFEFEF"><?php echo $s['pilihan']; ?>&nbsp;</td>
						<td width="1%" align="center" valign="middle" bgcolor="#EFEFEF"></td>
						<td width="30%" align="left" valign="middle" bgcolor="#EFEFEF"><img src="images/bar.gif" width="<?php echo $gbr_vote; ?>" height="14" /></td>
						<td width="4%" align="right" valign="middle" bgcolor="#EFEFEF"><?php echo $s['rating']; ?>&nbsp;</td>
						<td width="20%" align="left" valign="middle" bgcolor="#EFEFEF"> (<?php echo $prosentase; ?> %)</td>
					  </tr>
					  <tr class="teks_utama">
						<td align="left" valign="middle">&nbsp;</td>
						<td align="center" valign="middle">&nbsp;</td>
						<td colspan="3" align="left" valign="middle">&nbsp;</td>
					  </tr>
					  <?php  } ?>
					  <tr class="teks_utama">
						<td align="left" valign="middle">&nbsp;</td>
						<td align="center" valign="middle">&nbsp;</td>
						<td colspan="3" align="left" valign="middle">&nbsp;</td>
					  </tr>
					  <tr class="teks_utama">
						<td align="left" valign="middle">Total</td>
						<td align="center" valign="middle"></td>
						<td colspan="3" align="left" valign="middle"> <b><?php echo $jml_vote; ?></b> Responden </td>
					  </tr>
				  </table>
<?php } ?>
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