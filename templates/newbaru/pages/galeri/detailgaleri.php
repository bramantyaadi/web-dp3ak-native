<?php
$ambilalbum=mysqli_query($koneksi, "SELECT * FROM album WHERE id_album='".$val->validasi($_GET['id'],'sql')."'");
	$dalb=mysqli_fetch_array($ambilalbum);
?>
<!-- navigasi menu -->
<header>
<?php include "header.php"; ?>
</header>
<!-- .navigasi menu -->
<section class="site-content">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-lg-8 left-column no-padding">
				<div class="breadcrumb-wrapper">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<h1 class="breadcrumb-page-title hidden-xs hidden-sm"></h1>

							</div> <!-- .col-md-6 -->

							<div class="col-md-6 col-sm-6 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="./">Beranda</a></li>
									<li><a href="#">Foto</a></li>
								</ol>
							</div> <!-- .col-md-6 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .breadcrumb-wrapper -->

				<h1 class="margin-top-15"><?php echo $dalb['jdl_album']; ?></h1>
				<style type="text/css">
					img.gambarnya {
					    cursor: zoom-in;
					}
				</style>

				<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
				    <div class="modal-dialog modal-lg" role="document">
				      <div class="modal-content">
				        <div class="modal-header">
				          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				        </div>
				        <div class="modal-body">
				          <img src="#" class="enlargeImageModalSource" style="width: 100%;">
				        </div>
				      </div>
				    </div>
				</div>

				<article id="post-88467" class="news margin-bottom-0">
					<div class="row">
						<?php 
						  $p      = new Paging6;
						  $batas  = 6;
						  $posisi = $p->cariPosisi($batas);

						  $g = mysqli_query($koneksi, "SELECT * FROM gallery WHERE id_album='".$val->validasi($_GET['id'],'sql')."' ORDER BY id_gallery DESC LIMIT $posisi,$batas");
  						  $ada = mysqli_num_rows($g);
  						  if ($ada > 0) {
  						  while ($w = mysqli_fetch_array($g)) {
						?>
						<div class="col-md-6">
							<figure  class="wp-caption margin-bottom-15">
														<img style="width: 400px;height: 210px;" class="gambarnya size-medium img-responsive img-thumbnail" src="img_galeri/<?php echo $w['gbr_gallery']; ?>" alt="<?php echo $w['jdl_gallery']; ?>" title="<?php echo $w['keterangan']; ?>"/>
							</figure>
						</div>						
						<?php }
						}	
						else{
							echo "<h3><center>Belum ada foto pada gallery ini</center></h3>";
						}
						  $jmldata     = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM gallery WHERE id_album='".$val->validasi($_GET['id'],'sql')."'"));
						  $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
						  $linkHalaman = $p->navHalaman($_GET['halgaleri'], $jmlhalaman);	
						?>					
				</div><!-- .row -->
				
				<div class="row" align="center">
      				<ul class="pagination"><?php echo $linkHalaman; ?></ul></div>

					<div class="divider-light"></div>
					<!-- facebook comments plugin -->
					<div id="disqus_thread"></div>

				</article>
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