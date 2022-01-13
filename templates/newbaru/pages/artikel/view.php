<!-- navigasi menu -->
<header>
<?php include "header.php"; ?>
</header>
<!-- .navigasi menu -->

<section class="site-content padding-bottom-0">
<div class="container">

		<div class="row">
		<div class="col-md-8 no-padding">
		<div class="list-group-item bg-primary">
							<h4 class="list-group-item-heading">
								<i class="fa fa-newspaper-o margin-right-10"></i>
								<b>Artikel</b>
							</h4>
</div>
		<div class="tab-content bg-light social-tabs no-border no-padding">
				<div class="tab-pane no-padding active" id="artikel">
					<ul class="media-list">
						<?php 
						 $p      = new Paging22;
						 $batas  = 10;
						 $posisi = $p->cariPosisi($batas); 
						$terkiniARTIKEL = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id_berita DESC LIMIT $posisi,$batas");
						$no=1;
						while($a = mysqli_fetch_array($terkiniARTIKEL)){      
						$tgl = tgl_indo($a['tanggal']);
						?>
						<li class="media space margin-bottom-20">
							<div class="media-left">
								<img class="media-object borderthumb" 
									 src="foto_berita/medium_<?php echo $a['gambar']; ?>" 
									 alt="<?php echo $a['judul']; ?>" 
									 width="125" 
									 height="70">
							</div> <!-- .media-left -->

							<div class="media-body">
								<p class="small text-muted no-bottom-spacing">
									<i class="fa fa-calendar margin-right-5"></i>
									<?php echo tgl_indo($a['tanggal']); ?>
								</p>
								<h4 class="media-heading margin-top-5">
									<a href="detail-artikel-<?php echo $a['id_berita']."-".$a['judul_seo'];?>.html">
										<?php echo $a['judul']; ?>
									</a>
								</h4>
							</div> <!-- .media-body -->
						</li>
						<?php $no++; 
						} 
						 $jmldata     = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM berita"));
						 $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
						 $linkHalaman = $p->navHalaman($_GET['halartikel'], $jmlhalaman);
						 echo "<div class='col-md-12 col-sm-12 col-xs-12 text-center'>
								   <div class='row' align='center'><center><ul class='pagination'>$linkHalaman</ul></center></div></div>";
						?>
					</ul>
                </div>
		</div>
						</div>
		<div class="col-md-4 right-column no-padding">
				<?php include_once "sidebarkanan.php"; ?>
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
