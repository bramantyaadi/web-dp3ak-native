<!-- navigasi menu -->
<header>
<?php include "header.php"; ?>
</header>
<!-- .navigasi menu -->
<section class="site-section banner-atas-default hidden-xs hidden-sm">

	<div class="margin-bottom-100 visible-xs">
		<div class="clearfix"></div>
	</div>
	<div id="bootstrap-touch-slider" class="carousel bs-slider fade control-round indicators-line" data-ride="carousel" data-interval="4500" >

		<!-- Indicators -->
		
		<!-- Wrapper For Slides -->
		<div class="carousel-inner" role="listbox">
			<?php
			$no=1;
			$slider=mysqli_query($koneksi, "SELECT * FROM slider ORDER BY id_slider DESC");
			while($tsd=mysqli_fetch_array($slider)){
			?>
			<!-- Start of Slide -->
			<div class="item <?php if($no==1){echo "active";} ?>">
			<a href="<?php echo $tsd['link']; ?>" target="_blank">
				<!-- Slide Background -->
				<img src="./foto_slider/<?php echo $tsd['gmb_slider']; ?>" alt=""  class="slide-image"/>
				<!-- <div class="bs-slider-overlay"></div> -->

				<div class="container">
					<div class="row">
					</div>
				</div>
				</a>
			</div>
			<!-- End of Slide -->
			<?php $no++; } ?>
		</div>
		<!-- End of Wrapper For Slides -->
		
		<!-- Left Control -->
		<a class="left carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="prev">
			<span class="fa fa-angle-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>

		<!-- Right Control -->
		<a class="right carousel-control" href="#bootstrap-touch-slider" role="button" data-slide="next">
			<span class="fa fa-angle-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div><!-- End  bootstrap-touch-slider Slider -->
</section>
<section class="site-section no-margin padding-bottom-15 running-section hidden-xs hidden-sm">
	<div class="container paddingnya margin-top-10">
		<div class="row">
			<div class="col-md-3 no-padding">
				<?php 
				$ambiliden=mysqli_query($koneksi, "SELECT * FROM identitas LIMIT 1");
				$tiden=mysqli_fetch_array($ambiliden);
				?>
				<img class="foto-bupati" src="images/<?php echo $tiden['fopim']; ?>">
			</div>
			<div class="col-md-9 padding-right-0">
				<ul class="indicators-list slider-kecil margin-left-20 margin-right-10">
					<?php 
					$no=0;
					$listslide=mysqli_query($koneksi, "SELECT * FROM listslider ORDER BY nama_menu ASC");
					while($tlist=mysqli_fetch_array($listslide)){
						$awback=array("","pink-box","yellow-box","green-box");
						$awicon=array("#0FA3DB","#C80974","#F18F21","#10D494");
						if($no>3){
							$no=0;
						}
					?>
					<li class="<?php echo $awback[$no]; ?> margin-top-0 margin-bottom-40">
						<a class="pie margin-top-20 margin-bottom-10" href="<?php echo $tlist['link']; ?>" target="_blank">
						<i class="fa fa-folder-open icon-circle icon-bordered fa-primary ikon-kecil" style="color: <?php echo $awicon[$no]; ?>; border-color: <?php echo $awicon[$no]; ?>;"></i><strong><?php echo $tlist['nama_menu']; ?></strong>
							<span><p><?php echo $tlist['keterangan']; ?></p>
							</span>
						</a>
					</li>
					<?php $no++;} ?>
				</ul><!-- .indicators-list -->
			</div><!-- .col-md-9 -->
		</div><!-- .row -->
	</div><!-- .container -->
</section>
<section class="site-content">
	<div class="container">
		<div class="row">
			<div class="col-md-8 padding-bottom-20 left-column no-padding">
				<div class="breadcrumb-wrapper bg-medium margin-bottom-20">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<h1 class="breadcrumb-page-title">Direktori Pengumuman</h1>
							</div> <!-- .col-md-6 -->
							<div class="col-md-6 col-sm-6 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="./">Beranda</a></li>
									<li>Direktori Pengumuman</li>
								</ol>
							</div> <!-- .col-md-6 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div>
				<div class="row">
				<?php 
				  $p      = new PagingPengumuman;
				  $batas  = 2;
				  $posisi = $p->cariPosisi($batas); 
				  // Tampilkan semua agenda
				 	$sql = mysqli_query($koneksi, "SELECT * FROM pengumuman  
				                      ORDER BY id_pengumuman DESC LIMIT $posisi,$batas");		 
				  while($d=mysqli_fetch_array($sql)){
				    $tgl_posting = tgl_indo($d['tgl_posting']);
				    
				    // Tampilkan hanya sebagian isi berita
				      $isi_pengumuman = htmlentities(strip_tags($d['isi_pengumuman'])); // membuat paragraf pada isi berita dan mengabaikan tag html
				      $isi = substr($isi_pengumuman,0,220); // ambil sebanyak 150 karakter
				      $isi = substr($isi_pengumuman,0,strrpos($isi," ")); // potong per spasi kalimat
				    ?>
				    <div class="col-md-12 col-sm-12 col-xs-12 masonry-grid-item no-padding">
					<article class="content-box box-img bg-light box-clickable media">
						<div class="box-body media">
							<div class="media-body">
							<h3>
								<a href="baca-pengumuman-<?php echo $d['id_pengumuman']."-".$d['judul_seo']; ?>.html"><?php echo $d['judul']; ?></a>
							</h3>

							<ul class="list-inline small">
								<li><i class="fa fa-calendar"></i> <?php echo $tgl_posting; ?></li>
								<li style="margin-top: 5px;">
									<?php echo $isi; ?>  ...
		                            <a href="baca-pengumuman-<?php echo $d['id_pengumuman']."-".$d['judul_seo']; ?>.html">
		                            	<span></span>
		                            </a>
								</li>
							</ul>
							</div>
						</div>
					</article>
				</div>
				          <?php
					 }
					
				  $jmldata     = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pengumuman"));
				  $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
				  $linkHalaman = $p->navHalaman($_GET['halpengumuman'], $jmlhalaman);
				  echo "<div class='col-md-12 col-sm-12 col-xs-12 text-center'>
							<div class='row' align='center'><center><ul class='pagination'>$linkHalaman</ul></center></div></div>";
				?>	
				</div>
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