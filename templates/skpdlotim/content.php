<?php 
				$ambiliden=mysql_query("SELECT * FROM identitas LIMIT 1");
				$tiden=mysql_fetch_array($ambiliden);
				?>
 <?php 

 function konversi_tanggal($format, $tanggal="now", $bahasa="id"){
	$en=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Okt","Nov","Dec");
	$id=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	
	return str_replace($en,$$bahasa,date($format,strtotime($tanggal)));
}
function artikelTerkait($id){
	//Batas threshold
	$threshold = 40;
	//Jumlah maksimum artikel terkait
	$maksArtikel = 5;
	// Membaca judul artikel dari ID tertentu (ID artikel acuan)
	// array yang nantinya diisi judul artikel terkait
	$listArtikel = Array();
	$query = "SELECT judul FROM berita WHERE id_berita = '$id'";
	$hasil = mysql_query($query);
	$data  = mysql_fetch_array($hasil);
	$judul = $data['judul'];

	// Membaca semua data artikel selain ID artikel acuan
	$query = "SELECT * FROM berita WHERE id_berita <> '$id'";
	$hasil = mysql_query($query);
	while($data = mysql_fetch_array($hasil)){
		// Cek similaritas judul artikel acuan dengan judul artikel lainya
		similar_text($judul, $data['judul'], $percent);
		if($percent >= $threshold){
			// Jika prosentase kemiripan judul di atas threshold
			if(count($listArtikel) <= $maksArtikel){
				// jika jumlah artikel belum sampai batas maksimum, tambahkan
				$listArtikel[] = "<a href='baca-berita-".$data['id_berita']."-".$data['judul_seo'].".html' class='list-group-item'><h4 class='list-group-item-heading'>".$data['judul']."</h4></a>";
			}
		}
	}
	if(count($listArtikel)>0){
		echo "<div class='list-group margin-top-0'>";
		for($i=0;$i<=count($listArtikel)-1;$i++){
			echo $listArtikel[$i];
		}
		echo "</div>";
	} 
	else{
		echo "<p><center>Tidak ada artikel terkait</center></p>";
	} 
}
// MODUL BERANDA				
if ($_GET['module']=='home'){
 ?>
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
			$slider=mysql_query("SELECT * FROM slider ORDER BY id_slider DESC");
			while($tsd=mysql_fetch_array($slider)){
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
				$ambiliden=mysql_query("SELECT * FROM identitas LIMIT 1");
				$tiden=mysql_fetch_array($ambiliden);
				?>
				<img class="foto-bupati" src="images/<?php echo $tiden['fopim']; ?>">
			</div>
			<div class="col-md-9 padding-right-0">
				<ul class="indicators-list slider-kecil margin-left-20 margin-right-10">
					<?php 
					$no=0;
					$listslide=mysql_query("SELECT * FROM listslider ORDER BY nama_menu ASC");
					while($tlist=mysql_fetch_array($listslide)){
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
<section class="site-content padding-bottom-0">
	<div class="container paddingnya">
		<div class="row margin-bottom-10">
			<div class="col-md-8 no-padding left-column">
				
				<!-- Start Carousel Slider Berita -->
				<div id="custom_carousel" class="carousel slide margin-bottom-15" data-ride="carousel" data-interval="5000">
					<!-- Carousel Inner -->
					<div class="carousel-inner">
						<?php
						$terkini2=mysql_query("SELECT * FROM berita WHERE id_kategori='2' ORDER BY id_berita DESC LIMIT 5");
						$no=1;
						while($t=mysql_fetch_array($terkini2)){      
						$tgl = tgl_indo($t[tanggal]);
						/*$isi_berita = strip_tags($t['isi_berita']); 
						$isi = substr($isi_berita,0,130); 
						$isi = substr($isi_berita,0,strrpos($isi," ")); */
						
						if($no==1){$item="active";}else{$item="";}
						?>
						<div class="item <?php echo $item; ?>">
							<div class="container-fluid no-padding">
								<div class="row">                               
									<div class="col-sm-12 no-padding">
										<a href="baca-berita-<?php echo $t['id_berita']."-".$t['judul_seo'];?>.html">
											<img class="img-responsive slider-berita" src="foto_berita/<?php echo $t['gambar']; ?>"/>
											<div class="carousel-caption">
												<span><?php echo $t['hari']; ?>, <?php echo tgl_indo($t['tanggal']);?></span>
												<h2 align="left"><?php echo $t['judul']; ?></h2>
											</div>                     
										</a>
									</div><!-- .col-sm-12 -->
								</div><!-- .row -->
							</div><!-- .container-fluid -->           
						</div>
					<?php $no++;}  ?>
						
					</div>
					<!-- End Carousel Inner -->

					<style type="text/css">
						p.text-page {
						    overflow: hidden;
						    height: 77px;
						    margin-bottom: 8px;
						}
					</style>
					
					<!-- Start Control Thumbnails -->
					<div class="controls">
						<ul class="nav slider margin-left-0">
							<?php
							$terkini2=mysql_query("SELECT * FROM berita WHERE id_kategori='2' ORDER BY id_berita DESC LIMIT 5");
							$no=0;
							while($t=mysql_fetch_array($terkini2)){      
							$tgl = tgl_indo($t[tanggal]);
							?>
							<li data-target="#custom_carousel" data-slide-to="<?php echo $no; ?>" class="">
								<a href="#" class="slider-control">
									<div class="margin-bottom-10">
										<img class="img-responsive" src="foto_berita/small_<?php echo $t['gambar']; ?>"/>
									</div>
									<p class="hidden-xs hidden-sm text-page">
										<span><?php echo $t['judul']; ?></span>
									</p>
								</a>
							</li>
							<?php $no++;} ?>
						</ul>
					</div>
					<!-- End Control Thumbnails -->

				</div>
				<!-- End Carousel Slider Berita -->

				<script type="text/javascript">
					$(document).ready(function(ev){
					$('#custom_carousel').on('slide.bs.carousel', function (evt) {
						$('#custom_carousel .controls li.active').removeClass('active');
						$('#custom_carousel .controls li:eq('+$(evt.relatedTarget).index()+')').addClass('active');
					})
				});
				</script>

			</div> <!-- .col-md-8 -->

			<div class="col-md-4 right-column no-padding margin-bottom-10">
				<!--/////////////////////////- start sidebar atas -/////////////////////-->
				<ul class="nav nav-tabs tabs-v3 nav-justified social-tabs custom" role="tablist">
		
					<li role="presentation" class="myriadpro active">
						<a href="#beritaterbaru" class="sidebar-utama" role="tab" data-toggle="tab">
							<span>Terbaru</span>
						</a>
					</li>
					<li role="presentation" class="myriadpro">
						<a href="#beritaterpopuler" class="sidebar-utama kanan" role="tab" data-toggle="tab">
							<span>Populer</span>
						</a>
					</li>
				</ul>

				<div class="tab-content social-tabs no-border no-padding">
					<div class="tab-pane no-padding active" id="beritaterbaru">	
						<?php 
						$terbaru=mysql_query("SELECT * FROM berita WHERE id_kategori='2' ORDER BY id_berita DESC LIMIT 3");
						while($bt=mysql_fetch_array($terbaru)){      
						$tgl = tgl_indo($bt['tanggal']);
						?>
						<a href="baca-berita-<?php echo $bt['id_berita']."-".$bt['judul_seo'];?>.html" class="list-group-item custom">
							<div class="row">
								<div class="col-xs-4 no-padding">
									<img src="foto_berita/small_<?php echo $bt['gambar']; ?>" class="img-responsive padding-right-10">
								</div>
								<div class="col-xs-8 no-padding">
									<div style="overflow: hidden;height: 57px;">
										<h5 class="no-margin"><span style="color: #000000;"><?php echo $bt['judul']; ?></span></h5>
									</div>
								</div>  
							</div>
						</a>
						<?php } ?>
					</div>

					<div class="tab-pane no-padding" id="beritaterpopuler">
						<?php 
						$populer=mysql_query("SELECT * FROM berita WHERE id_kategori='2' ORDER BY dibaca DESC LIMIT 3");
						while($bp=mysql_fetch_array($populer)){      
						$tgl = tgl_indo($bp['tanggal']);
						?>
						<a href="baca-berita-<?php echo $bp['id_berita']."-".$bp['judul_seo'];?>.html" class="list-group-item custom">
							<div class="row">
								<div class="col-xs-4 no-padding">
									<img src="foto_berita/small_<?php echo $bp['gambar']; ?>" class="img-responsive padding-right-10">
								</div>
								<div class="col-xs-8 no-padding">
									<div style="overflow: hidden;height: 57px;">
										<h5 class="no-margin"><span style="color: #000000;"><?php echo $bp['judul']; ?></span></h5>
									</div>
								</div>  
							</div>
						</a>
						<?php } ?>
					</div>
				</div>
				<!--/////////////////////////- end sidebar atas -/////////////////////-->
			</div>

			<div class="col-md-4 right-column no-padding margin-bottom-10">
				<!--/////////////////////////- start sidebar atas -/////////////////////-->
				<ul class="nav nav-tabs tabs-v3 nav-justified social-tabs custom" role="tablist">
		
					<li role="presentation" class="myriadpro active">
						<a href="#sms" class="sidebar-utama" role="tab" data-toggle="tab">
							<span>BANNER</span>
						</a>
					</li>
				</ul>

				<style type="text/css">
					a.list-group-item {
						text-decoration: none;
						color: #00276C;
					}

					.atas-sms {
						border-bottom: solid 1px;
						margin-bottom: 0px;
					}

					@media (max-width: 770px) {
						.atas-sms small {
							font-size: 11px;
						}
					}

					@media (max-width: 330px) {
						.atas-sms small {
							font-size: 9px;
						}
					}
				</style>

				
				<div class="tab-content social-tabs no-border no-padding">
					<div class="tab-pane no-padding active" id="sms">
						<?php 
							$ambilbanner=mysql_query("SELECT * FROM banner LIMIT 1");
							$tban=mysql_fetch_array($ambilbanner);
						?>
						<a href="<?php echo $tban['link']; ?>" target="_blank">
							<img src="foto_banner/<?php echo $tban['gambar']; ?>" width="100%"/>
						</a>	
					</div>
				</div>
				<!--/////////////////////////- end sidebar atas -/////////////////////-->
			</div>

		</div> <!-- .row margin-bottom-10 -->
	</div> <!-- .container paddingnya -->
</section>
<section class="site-content padding-bottom-25 no-padding">
	<div class="container paddingnya">
		<div class="row">
			<div class="col-md-8 no-padding left-column">
			<!--/////////////////////////- start main -/////////////////////-->
			<ul class="nav nav-tabs tabs-v3 nav-justified social-tabs responsive-text" role="tablist">
				<li role="presentation" class="myriadpro uppercase active">
					<a href="#artikel" role="tab" data-toggle="tab">
						<i class="fa fa-folder-open"></i>
						<span>Artikel</span>
					</a>
				</li>
				<li role="presentation" class="myriadpro uppercase">
					<a href="#agendakegiatan" role="tab" data-toggle="tab">
						<i class="fa fa-folder-open"></i>
						<span>Agenda</span>
					</a>
				</li>
				<li role="presentation" class="myriadpro uppercase">
					<a href="#pengumuman" role="tab" data-toggle="tab">
						<i class="fa fa-clipboard"></i>
						<span>Pengumuman</span>
					</a>
				</li>
			</ul>

			<div class="tab-content bg-light social-tabs no-border no-padding">
				<div class="tab-pane no-padding active" id="artikel">
					<ul class="media-list">
						<?php 
						$terkiniARTIKEL=mysql_query("SELECT * FROM berita WHERE id_kategori='1' ORDER BY id_berita DESC LIMIT 9");
						$no=1;
						while($a=mysql_fetch_array($terkiniARTIKEL)){      
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
									<a href="baca-berita-<?php echo $a['id_berita']."-".$a['judul_seo'];?>.html">
										<?php echo $a['judul']; ?>
									</a>
								</h4>
							</div> <!-- .media-body -->
						</li>
						<?php $no++;} ?>
					</ul>
				</div>

				<div class="tab-pane no-padding" id="agendakegiatan">
					<ul class="media-list">
						<?php 
						$agenda = mysql_query("SELECT * FROM agenda ORDER BY id_agenda DESC LIMIT 5");
						while($tgd=mysql_fetch_array($agenda)){
							$tgl_posting = tgl_indo($tgd['tgl_posting']);
						    $tgl_mulai   = tgl_indo($tgd['tgl_mulai']);
						    $tgl_selesai = tgl_indo($tgd['tgl_selesai']);
						    $isi_agenda  = nl2br($tgd['isi_agenda']);
						?>
						<li class="media space margin-bottom-20">
							<div class="media-left">
								<div class="event-date margin-bottom-5">
									<p><?php echo konversi_tanggal("j",$tgd['tgl_posting']); ?> </p>
									<small class="uppercase"><?php echo konversi_tanggal("M",$tgd['tgl_posting']); ?></small>
								</div> <!-- .event-date -->
							</div> <!-- .media-left -->

							<div class="media-body">
								<h5><b><?php echo $tgd['tema']; ?></b></h5>

								<ul class="list-inline small">
									<li><b><i>
										<i class="fa fa-calendar"></i> <?php echo $tgl_posting; ?></i></b><b><i>
										<i class="fa fa-map-marker"></i> <?php echo $tgd['tempat']." - ".$tgl_mulai." s/d ".$tgl_selesai." Pukul ".$tgd['jam']; ?></i></b>
										<b>
										<i class="fa fa-user"></i> <?php echo $tgd['pengirim']; ?></b>
										</li>
									<li style="margin-top: 5px;">
			                            <?php echo $isi_agenda; ?>
									</li>
								</ul>
								</div> <!-- .media-body -->
						</li>
						<?php } ?>
					</ul>
				</div>

				<div class="tab-pane no-padding" id="pengumuman">
					<ul class="media-list">
					<?php 
						$pengumuman = mysql_query("SELECT * FROM pengumuman ORDER BY id_pengumuman DESC LIMIT 6");
						while($tpe=mysql_fetch_array($pengumuman)){
					?>
						<li class="media space margin-bottom-20">
							<div class="media-left">
								<div class="event-date margin-bottom-5">
									<i class="fa fa-bullhorn fa-3x"></i>
								</div>
							</div>

							<div class="media-body">
								<p class="small text-muted no-bottom-spacing">
									<i class="fa fa-calendar margin-right-5"></i>
									<?php echo konversi_tanggal("D, j M Y",$tpe['tgl_posting']); ?>
								</p>
								<h4 class="media-heading margin-top-5">
									<a href="baca-pengumuman-<?php echo $tpe['id_pengumuman']."-".$tpe['judul_seo']; ?>.html">
										<?php echo $tpe['judul']; ?>
									</a>
								</h4>
							</div>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<!--/////////////////////////- end main -/////////////////////-->
			</div>
		
		<div class="col-md-4 no-padding right-column margin-bottom-15">
				<!-- jajak pendapat -->
					
				<div class="content-box box-img bg-light no-margin featured-news jajak-pendapat">
					<div class="col-sm-12 no-padding">
						<div class="container-fluid no-margin no-padding">
							<div class="col-xs-12 padding-top-10 hal-kecil-heading">
								<!-- judul -->
								<h1 class="panel-title custom-font"><i class="fa fa-signal"></i> &nbsp;Polling</h1>
							</div>
						</div>
					</div>
					<div class="box-body custom">
						<?php $tanya=mysql_query("SELECT * FROM poling WHERE aktif='Y' and status='Pertanyaan'");
				                $t=mysql_fetch_array($tanya); ?>
						<p><?php echo $t['pilihan']; ?></p>
						<form action="hasil-poling.html" method="post" class="bs-example form-horizontal">
							<div class="form-group">
								<div class="col-lg-10">
									<?php 
									$poling=mysql_query("SELECT * FROM poling WHERE aktif='Y' and status='Jawaban' ORDER BY id_poling DESC");
					                while ($p=mysql_fetch_array($poling)){
					                  echo "<div class='radio'>
												<label>
												<input name='pilihan' type='radio' value='".$p['id_poling']."'/>".$p['pilihan']."</label>
											</div>";
					                }
									?>
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-12">
									<input type="submit" name="Submit" value="Vote" class="btn btn-sm btn-primary"/>
									<input type="button" name="lihat" value="Lihat Hasil" class="btn btn-sm btn-primary" onclick="window.location.href='lihat-poling.html'; return false;" />
									<input type="hidden" id="id" name="id" value="" />
								</div>
							</div>

						</form>

					</div> <!-- .box-body -->
				</div> <!-- .content-box .box-img -->

				<style type="text/css">
					.kritik-saran li a, .kritik-saran li p {
						color: #fff;
					}
				</style>

				<div class="margin-top-15">
					<div class="col-sm-12 no-padding">
						<div class="container-fluid no-margin no-padding">
							<div class="col-xs-12 padding-top-10 hal-kecil-heading">
								<!-- judul -->
								<h1 class="panel-title custom-font"><i class="fa fa-twitter"></i> &nbsp;Twitter</h1>
							</div>
							<div class="box-body">
								<?php echo $tiden['twitter_widget']; ?>
							</div>
						</div>
					</div>
				</div>


			</div>
			
		</div>
	</div>
</section>

<style type="text/css">
	.page-heading {
		color: #000;
		font-size: 30px;
		text-align: center;
		border-bottom: 1px solid;
	}
</style>
<section class="site-content padding-bottom-0">
	<div class="container no-padding margin-top-15">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-heading">Gallery Foto</h3>
			</div>
			<!-- Video -->
			<style type="text/css">
				div.content-box.box-clickable {
				    background-color: #414141;
				}

				.box-body h4 a {
					color: #fff;
				}
			</style>
			<?php 
			$album=mysql_query("SELECT * FROM album WHERE aktif='Y' ORDER BY id_album DESC LIMIT 4");
			while($tfab=mysql_fetch_array($album)){
			?>
			<div class="col-md-3 col-sm-6 col-xs-12 margin-bottom-15">
				<div class="content-box box-img no-margin text-center featured-news box-clickable">
					<img class="img-responsive" src="img_album/kecil_<?php echo $tfab['gbr_album']; ?>" alt="<?php echo $tfab['jdl_album']; ?>" width="100%" style="height:191.25px;">
					<div class="ua-square-logo overlap-top text-center">
						<center>
							<div class="overlay-custom" style="max-width: 150px;margin-top:30px;">
								<div class="overlay-post" style="background-color: #FE8C05;color: #fff;padding: 9px;"><b>Galeri Foto</b></div>
							</div>
						</center>
					</div> <!-- .overlay-post -->
					<div class="box-body">
						<h4>
							<a href="lihat-foto-<?php echo $tfab['id_album']."-".$tfab['album_seo']; ?>.html"><?php echo $tfab['jdl_album']; ?></a>
						</h4>
					</div> <!-- .box-body -->
				</div> <!-- .box-img -->
			</div> <!-- .col-md-3 -->
			<?php } ?>			
		<div class="col-md-12">
				<span class="pull-right">
					<a class="btn btn-sm btn-primary" href="arsip-foto.html">Lihat Gallery Foto Lainnya</a>
				</span>
				<br>
			</div>
		</div> <!-- .row -->
	</div>
</section>
 <?php
 }
//MODUL DETAIL BERITA 
elseif($_GET['module']=='detailberita'){
	$detail=mysql_query("SELECT * FROM berita,users,kategori    
                      WHERE users.username=berita.username 
                      AND kategori.id_kategori=berita.id_kategori 
                      AND id_berita = '".abs((int)$_GET[id])."'");
	$d   = mysql_fetch_array($detail);
	$tgl = tgl_indo($d[tanggal]);
	$baca = $d[dibaca]+1;

?>
<section class="site-content padding-bottom-0 margin-top-15">
	<div class="container">
		<div class="row">
			<div class="col-md-8 left-column no-padding">
				<div class="breadcrumb-wrapper bg-medium">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<ol class="breadcrumb">
									<li><a href="./">Beranda</a></li>
									<li><a href="#">Berita</a></li>
								</ol>
							</div> <!-- .col-md-12 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div>
				<h1 class="margin-top-15"><?php echo $d['judul']; ?></h1>
				<ul class="list-inline small font-weight-600 myriadpro">
					<li><i class="fa fa-calendar"></i> <?php echo $d['hari'].", ".$tgl." - ".$d['jam']; ?> WIB</li>
					<li><i class="fa fa-user"></i> <?php echo $d['nama_lengkap']; ?></li>
				</ul>

				<ul class="rrssb-buttons margin-bottom-15">
					<li class="rrssb-facebook">
						<!--  Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header:
							  https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $tiden['alamat_website']."/baca-berita-".$d['id_berita']."-".$d['judul_seo'].".html"; ?>" class="popup">
						  <span class="rrssb-icon">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg>
						  </span>
						  <span class="rrssb-text">facebook</span>
						</a>
					</li>

					<li class="rrssb-linkedin">
						<!-- Replace href with your meta and URL information -->
						<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $tiden['alamat_website']."/baca-berita-".$d['id_berita']."-".$d['judul_seo'].".html"; ?>" class="popup">
						  <span class="rrssb-icon">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M25.424 15.887v8.447h-4.896v-7.882c0-1.98-.71-3.33-2.48-3.33-1.354 0-2.158.91-2.514 1.802-.13.315-.162.753-.162 1.194v8.216h-4.9s.067-13.35 0-14.73h4.9v2.087c-.01.017-.023.033-.033.05h.032v-.05c.65-1.002 1.812-2.435 4.414-2.435 3.222 0 5.638 2.106 5.638 6.632zM5.348 2.5c-1.676 0-2.772 1.093-2.772 2.54 0 1.42 1.066 2.538 2.717 2.546h.032c1.71 0 2.77-1.132 2.77-2.546C8.056 3.593 7.02 2.5 5.344 2.5h.005zm-2.48 21.834h4.896V9.604H2.867v14.73z"/></svg>
						  </span>
						  <span class="rrssb-text">linkedin</span>
						</a>
					</li>

					<li class="rrssb-twitter">
						<!-- Replace href with your Meta and URL information  -->
						<a href="https://twitter.com/intent/tweet?text=<?php echo $tiden['alamat_website']."/baca-berita-".$d['id_berita']."-".$d['judul_seo'].".html"; ?>"
						class="popup">
						  <span class="rrssb-icon">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg>
						  </span>
						  <span class="rrssb-text">twitter</span>
						</a>
					  </li>

					  <li class="rrssb-googleplus">
						<!-- Replace href with your meta and URL information.  -->
						<a href="https://plus.google.com/share?url=<?php echo $tiden['alamat_website']."/baca-berita-".$d['id_berita']."-".$d['judul_seo'].".html"; ?>" class="popup">
						  <span class="rrssb-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 8.29h-1.95v2.6h-2.6v1.82h2.6v2.6H21v-2.6h2.6v-1.885H21V8.29zM7.614 10.306v2.925h3.9c-.26 1.69-1.755 2.925-3.9 2.925-2.34 0-4.29-2.016-4.29-4.354s1.885-4.353 4.29-4.353c1.104 0 2.014.326 2.794 1.105l2.08-2.08c-1.3-1.17-2.924-1.883-4.874-1.883C3.65 4.586.4 7.835.4 11.8s3.25 7.212 7.214 7.212c4.224 0 6.953-2.988 6.953-7.082 0-.52-.065-1.104-.13-1.624H7.614z"/></svg>            </span>
						  <span class="rrssb-text">google+</span>
						</a>
					  </li>

					  <li class="rrssb-whatsapp"><a href="whatsapp://send?text=<?php echo $tiden['alamat_website']."/baca-berita-".$d['id_berita']."-".$d['judul_seo'].".html"; ?>" data-action="share/whatsapp/share"><span class="rrssb-icon">
							  <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewbox="0 0 90 90">
								<path d="M90 43.84c0 24.214-19.78 43.842-44.182 43.842a44.256 44.256 0 0 1-21.357-5.455L0 90l7.975-23.522a43.38 43.38 0 0 1-6.34-22.637C1.635 19.63 21.415 0 45.818 0 70.223 0 90 19.628 90 43.84zM45.818 6.983c-20.484 0-37.146 16.535-37.146 36.86 0 8.064 2.63 15.533 7.076 21.61l-4.64 13.688 14.274-4.537A37.122 37.122 0 0 0 45.82 80.7c20.48 0 37.145-16.533 37.145-36.857S66.3 6.983 45.818 6.983zm22.31 46.956c-.272-.447-.993-.717-2.075-1.254-1.084-.537-6.41-3.138-7.4-3.495-.993-.36-1.717-.54-2.438.536-.72 1.076-2.797 3.495-3.43 4.212-.632.72-1.263.81-2.347.27-1.082-.536-4.57-1.672-8.708-5.332-3.22-2.848-5.393-6.364-6.025-7.44-.63-1.076-.066-1.657.475-2.192.488-.482 1.084-1.255 1.625-1.882.543-.628.723-1.075 1.082-1.793.363-.718.182-1.345-.09-1.884-.27-.537-2.438-5.825-3.34-7.977-.902-2.15-1.803-1.793-2.436-1.793-.63 0-1.353-.09-2.075-.09-.722 0-1.896.27-2.89 1.344-.99 1.077-3.788 3.677-3.788 8.964 0 5.288 3.88 10.397 4.422 11.113.54.716 7.49 11.92 18.5 16.223 11.01 4.3 11.01 2.866 12.996 2.686 1.984-.18 6.406-2.6 7.312-5.107.9-2.513.9-4.664.63-5.112z"></path>
							  </svg></span><span class="rrssb-text">Whatsapp</span>
						</a>
					</li>
				</ul>
				<article class="news margin-bottom-15">
					<!-- gambar konten -->
					<?php 
					if ($d[gambar]!=''){
						echo "<figure class='wp-caption margin-bottom-15'>
								<img style='align:center;width:100%;' class='size-medium img-responsive' 
									 src='foto_berita/$d[gambar]' 
									 alt='$d[judul]'/>
								</figure>";
					}
					?>
					<div class="divider-light"></div>
					<div style="text-align: justify;"><p><?php echo $d['isi_berita']; ?></p></div>
					<div class="clearfix"></div>
				</article>

				<ul class="rrssb-buttons margin-bottom-15">
		<li class="rrssb-facebook">
			<!--  Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header:
				  https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $tiden['alamat_website']."/baca-berita-".$d['id_berita']."-".$d['judul_seo'].".html"; ?>" class="popup">
			  <span class="rrssb-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg>
			  </span>
			  <span class="rrssb-text">facebook</span>
			</a>
		</li>

		<li class="rrssb-linkedin">
			<!-- Replace href with your meta and URL information -->
			<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $tiden['alamat_website']."/baca-berita-".$d['id_berita']."-".$d['judul_seo'].".html"; ?>" class="popup">
			  <span class="rrssb-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M25.424 15.887v8.447h-4.896v-7.882c0-1.98-.71-3.33-2.48-3.33-1.354 0-2.158.91-2.514 1.802-.13.315-.162.753-.162 1.194v8.216h-4.9s.067-13.35 0-14.73h4.9v2.087c-.01.017-.023.033-.033.05h.032v-.05c.65-1.002 1.812-2.435 4.414-2.435 3.222 0 5.638 2.106 5.638 6.632zM5.348 2.5c-1.676 0-2.772 1.093-2.772 2.54 0 1.42 1.066 2.538 2.717 2.546h.032c1.71 0 2.77-1.132 2.77-2.546C8.056 3.593 7.02 2.5 5.344 2.5h.005zm-2.48 21.834h4.896V9.604H2.867v14.73z"/></svg>
			  </span>
			  <span class="rrssb-text">linkedin</span>
			</a>
		</li>

		<li class="rrssb-twitter">
			<!-- Replace href with your Meta and URL information  -->
			<a href="https://twitter.com/intent/tweet?text=<?php echo $tiden['alamat_website']."/baca-berita-".$d['id_berita']."-".$d['judul_seo'].".html"; ?>"
			class="popup">
			  <span class="rrssb-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg>
			  </span>
			  <span class="rrssb-text">twitter</span>
			</a>
		  </li>

		  <li class="rrssb-googleplus">
			<!-- Replace href with your meta and URL information.  -->
			<a href="https://plus.google.com/share?url=<?php echo $tiden['alamat_website']."/baca-berita-".$d['id_berita']."-".$d['judul_seo'].".html"; ?>" class="popup">
			  <span class="rrssb-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 8.29h-1.95v2.6h-2.6v1.82h2.6v2.6H21v-2.6h2.6v-1.885H21V8.29zM7.614 10.306v2.925h3.9c-.26 1.69-1.755 2.925-3.9 2.925-2.34 0-4.29-2.016-4.29-4.354s1.885-4.353 4.29-4.353c1.104 0 2.014.326 2.794 1.105l2.08-2.08c-1.3-1.17-2.924-1.883-4.874-1.883C3.65 4.586.4 7.835.4 11.8s3.25 7.212 7.214 7.212c4.224 0 6.953-2.988 6.953-7.082 0-.52-.065-1.104-.13-1.624H7.614z"/></svg>            </span>
			  <span class="rrssb-text">google+</span>
			</a>
		  </li>

		  <li class="rrssb-whatsapp"><a href="whatsapp://send?text=<?php echo $tiden['alamat_website']."/baca-berita-".$d['id_berita']."-".$d['judul_seo'].".html"; ?>" data-action="share/whatsapp/share"><span class="rrssb-icon">
				  <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewbox="0 0 90 90">
					<path d="M90 43.84c0 24.214-19.78 43.842-44.182 43.842a44.256 44.256 0 0 1-21.357-5.455L0 90l7.975-23.522a43.38 43.38 0 0 1-6.34-22.637C1.635 19.63 21.415 0 45.818 0 70.223 0 90 19.628 90 43.84zM45.818 6.983c-20.484 0-37.146 16.535-37.146 36.86 0 8.064 2.63 15.533 7.076 21.61l-4.64 13.688 14.274-4.537A37.122 37.122 0 0 0 45.82 80.7c20.48 0 37.145-16.533 37.145-36.857S66.3 6.983 45.818 6.983zm22.31 46.956c-.272-.447-.993-.717-2.075-1.254-1.084-.537-6.41-3.138-7.4-3.495-.993-.36-1.717-.54-2.438.536-.72 1.076-2.797 3.495-3.43 4.212-.632.72-1.263.81-2.347.27-1.082-.536-4.57-1.672-8.708-5.332-3.22-2.848-5.393-6.364-6.025-7.44-.63-1.076-.066-1.657.475-2.192.488-.482 1.084-1.255 1.625-1.882.543-.628.723-1.075 1.082-1.793.363-.718.182-1.345-.09-1.884-.27-.537-2.438-5.825-3.34-7.977-.902-2.15-1.803-1.793-2.436-1.793-.63 0-1.353-.09-2.075-.09-.722 0-1.896.27-2.89 1.344-.99 1.077-3.788 3.677-3.788 8.964 0 5.288 3.88 10.397 4.422 11.113.54.716 7.49 11.92 18.5 16.223 11.01 4.3 11.01 2.866 12.996 2.686 1.984-.18 6.406-2.6 7.312-5.107.9-2.513.9-4.664.63-5.112z"></path>
				  </svg></span><span class="rrssb-text">Whatsapp</span>
			</a>
		</li>
	</ul>
		<ul class="list-inline small font-weight-600 myriadpro">
			<li><i class="fa fa-calendar"></i> <?php echo $d['hari'].", ".$tgl." - ".$d['jam']; ?> WIB</li>
			<li><i class="fa fa-user"></i> <?php echo $d['nama_lengkap']; ?></li>
		</ul>

		<div class="divider-light"></div>
				<div id="disqus_thread"></div>
		<div class="clearfix margin-bottom-15"></div>
				<div class="list-group-item bg-primary">
							<h4 class="list-group-item-heading">
								<i class="fa fa-newspaper-o margin-right-10"></i>
								<b>Berita Terkait Lainnya</b>
							</h4>
				</div>
				<?php artikelTerkait($d['id_berita']);?>
			</div>

			<div class="col-md-4 right-column no-padding">
				<?php include "sidebarkanan.php"; ?>
			</div>
		</div>
	</div>
</section>
<?php
}
// MODUDL HASIL POLLING
elseif($_GET['module']=='hasilpoling'){
?>
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
  $u=mysql_query("UPDATE poling SET rating=rating+1 WHERE id_poling='$_POST[pilihan]'");
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
		$pertanyaan=mysql_query("SELECT * FROM poling WHERE aktif='Y' and status='Pertanyaan'");
		$dperta=mysql_fetch_array($pertanyaan)
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
					     $jml=mysql_query("SELECT SUM(rating) as jml_vote FROM poling WHERE aktif='Y'");
						  $j=mysql_fetch_array($jml);
						  
						  $jml_vote=$j['jml_vote'];
						  
						  $sql=mysql_query("SELECT * FROM poling WHERE aktif='Y' and status='Jawaban'");
						  
						  while ($s=mysql_fetch_array($sql)){
						  	
						  	$prosentase = sprintf("%2.1f",(($s[rating]/$jml_vote)*100));
						  	$gbr_vote   = $prosentase * 3;
						 
					  ?>
					  <tr class="teks_utama">
						<td width="23%" align="left" valign="middle" bgcolor="#EFEFEF"><?php echo $s[pilihan]; ?>&nbsp;</td>
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
<?php
}
// MODUL LIHAT POLLING
elseif ($_GET['module']=='lihatpoling'){
?>
<section class="site-content">
  <div class="container">
	<div class="row">

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
		$pertanyaan=mysql_query("SELECT * FROM poling WHERE aktif='Y' and status='Pertanyaan'");
		$dperta=mysql_fetch_array($pertanyaan)
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
					     $jml=mysql_query("SELECT SUM(rating) as jml_vote FROM poling WHERE aktif='Y'");
						  $j=mysql_fetch_array($jml);
						  
						  $jml_vote=$j['jml_vote'];
						  
						  $sql=mysql_query("SELECT * FROM poling WHERE aktif='Y' and status='Jawaban'");
						  
						  while ($s=mysql_fetch_array($sql)){
						  	
						  	$prosentase = sprintf("%2.1f",(($s[rating]/$jml_vote)*100));
						  	$gbr_vote   = $prosentase * 3;
						 
					  ?>
					  <tr class="teks_utama">
						<td width="23%" align="left" valign="middle" bgcolor="#EFEFEF"><?php echo $s[pilihan]; ?>&nbsp;</td>
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
									
	</div>
  </div> <!-- .container -->
</section>
<?php           
}
// MODUL HALAMAN STATIS
elseif ($_GET['module']=='halamanstatis'){
	$detail=mysql_query("SELECT * FROM halamanstatis 
                      WHERE id_halaman='".$val->validasi($_GET['id'],'sql')."'");
	$d   = mysql_fetch_array($detail);
  	$tgl_posting   = tgl_indo($d[tgl_posting]);
?>
<section class="site-content padding-bottom-0 margin-top-15">
	<div class="container">
		<div class="row">
			<div class="col-md-8 left-column no-padding">
				<div class="breadcrumb-wrapper bg-medium">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<ol class="breadcrumb">
									<li><a href="./">Beranda</a></li>
									<li><a href="#">Berita</a></li>
								</ol>
							</div> <!-- .col-md-12 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div>
				<h1 class="margin-top-15"><?php echo $d['judul']; ?></h1>
				<ul class="list-inline small font-weight-600 myriadpro">
					<li><i class="fa fa-calendar"></i> <?php echo $tgl_posting; ?></li>
				</ul>
				
				<article class="news margin-bottom-15">
					<!-- gambar konten -->
					<?php 
					if ($d[gambar]!=''){
						echo "<figure class='wp-caption margin-bottom-15'>
								<img style='align:center;' class='size-medium img-responsive' 
									 src='foto_banner/$d[gambar]' 
									 alt='$d[judul]'/>
								</figure>";
					}
					?>
					<div class="divider-light"></div>
					<div style="text-align: justify;"><p><?php echo $d['isi_halaman']; ?></p></div>
					<div class="clearfix"></div>
				</article>

				<ul class="rrssb-buttons margin-bottom-15">
		<li class="rrssb-facebook">
			<!--  Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header:
				  https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $tiden['alamat_website']."/statis-".$d['id_halaman']."-".$d['judul_seo'].".html"; ?>" class="popup">
			  <span class="rrssb-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg>
			  </span>
			  <span class="rrssb-text">facebook</span>
			</a>
		</li>

		<li class="rrssb-linkedin">
			<!-- Replace href with your meta and URL information -->
			<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $tiden['alamat_website']."/statis-".$d['id_halaman']."-".$d['judul_seo'].".html"; ?>" class="popup">
			  <span class="rrssb-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M25.424 15.887v8.447h-4.896v-7.882c0-1.98-.71-3.33-2.48-3.33-1.354 0-2.158.91-2.514 1.802-.13.315-.162.753-.162 1.194v8.216h-4.9s.067-13.35 0-14.73h4.9v2.087c-.01.017-.023.033-.033.05h.032v-.05c.65-1.002 1.812-2.435 4.414-2.435 3.222 0 5.638 2.106 5.638 6.632zM5.348 2.5c-1.676 0-2.772 1.093-2.772 2.54 0 1.42 1.066 2.538 2.717 2.546h.032c1.71 0 2.77-1.132 2.77-2.546C8.056 3.593 7.02 2.5 5.344 2.5h.005zm-2.48 21.834h4.896V9.604H2.867v14.73z"/></svg>
			  </span>
			  <span class="rrssb-text">linkedin</span>
			</a>
		</li>

		<li class="rrssb-twitter">
			<!-- Replace href with your Meta and URL information  -->
			<a href="https://twitter.com/intent/tweet?text=<?php echo $tiden['alamat_website']."/statis-".$d['id_halaman']."-".$d['judul_seo'].".html"; ?>"
			class="popup">
			  <span class="rrssb-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg>
			  </span>
			  <span class="rrssb-text">twitter</span>
			</a>
		  </li>

		  <li class="rrssb-googleplus">
			<!-- Replace href with your meta and URL information.  -->
			<a href="https://plus.google.com/share?url=<?php echo $tiden['alamat_website']."/statis-".$d['id_halaman']."-".$d['judul_seo'].".html"; ?>" class="popup">
			  <span class="rrssb-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 8.29h-1.95v2.6h-2.6v1.82h2.6v2.6H21v-2.6h2.6v-1.885H21V8.29zM7.614 10.306v2.925h3.9c-.26 1.69-1.755 2.925-3.9 2.925-2.34 0-4.29-2.016-4.29-4.354s1.885-4.353 4.29-4.353c1.104 0 2.014.326 2.794 1.105l2.08-2.08c-1.3-1.17-2.924-1.883-4.874-1.883C3.65 4.586.4 7.835.4 11.8s3.25 7.212 7.214 7.212c4.224 0 6.953-2.988 6.953-7.082 0-.52-.065-1.104-.13-1.624H7.614z"/></svg>            </span>
			  <span class="rrssb-text">google+</span>
			</a>
		  </li>

		  <li class="rrssb-whatsapp"><a href="whatsapp://send?text=<?php echo $tiden['alamat_website']."/statis-".$d['id_halaman']."-".$d['judul_seo'].".html"; ?>" data-action="share/whatsapp/share"><span class="rrssb-icon">
				  <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewbox="0 0 90 90">
					<path d="M90 43.84c0 24.214-19.78 43.842-44.182 43.842a44.256 44.256 0 0 1-21.357-5.455L0 90l7.975-23.522a43.38 43.38 0 0 1-6.34-22.637C1.635 19.63 21.415 0 45.818 0 70.223 0 90 19.628 90 43.84zM45.818 6.983c-20.484 0-37.146 16.535-37.146 36.86 0 8.064 2.63 15.533 7.076 21.61l-4.64 13.688 14.274-4.537A37.122 37.122 0 0 0 45.82 80.7c20.48 0 37.145-16.533 37.145-36.857S66.3 6.983 45.818 6.983zm22.31 46.956c-.272-.447-.993-.717-2.075-1.254-1.084-.537-6.41-3.138-7.4-3.495-.993-.36-1.717-.54-2.438.536-.72 1.076-2.797 3.495-3.43 4.212-.632.72-1.263.81-2.347.27-1.082-.536-4.57-1.672-8.708-5.332-3.22-2.848-5.393-6.364-6.025-7.44-.63-1.076-.066-1.657.475-2.192.488-.482 1.084-1.255 1.625-1.882.543-.628.723-1.075 1.082-1.793.363-.718.182-1.345-.09-1.884-.27-.537-2.438-5.825-3.34-7.977-.902-2.15-1.803-1.793-2.436-1.793-.63 0-1.353-.09-2.075-.09-.722 0-1.896.27-2.89 1.344-.99 1.077-3.788 3.677-3.788 8.964 0 5.288 3.88 10.397 4.422 11.113.54.716 7.49 11.92 18.5 16.223 11.01 4.3 11.01 2.866 12.996 2.686 1.984-.18 6.406-2.6 7.312-5.107.9-2.513.9-4.664.63-5.112z"></path>
				  </svg></span><span class="rrssb-text">Whatsapp</span>
			</a>
		</li>
	</ul>
		<ul class="list-inline small font-weight-600 myriadpro">
			<li><i class="fa fa-calendar"></i> <?php echo $tgl_posting; ?></li>
		</ul>

		<div class="divider-light"></div>
				<div id="disqus_thread"></div>
		<div class="clearfix margin-bottom-15"></div>
		
			</div>

			<div class="col-md-4 right-column no-padding">
				<?php include "sidebarkanan.php"; ?>
			</div>
		</div>
	</div>
</section>
<?php         
}
// MODUL BERITA PERKATEGORI
elseif ($_GET['module']=='detailkategori'){
	// Tampilkan nama kategori
  $sq = mysql_query("SELECT nama_kategori from kategori where id_kategori='".$val->validasi($_GET['id'],'sql')."'");
  $n = mysql_fetch_array($sq);
?>
<section class="site-content">
	<div class="container">
		<div class="row">
			<div class="col-md-8 padding-bottom-20 left-column no-padding">
				<div class="breadcrumb-wrapper bg-medium margin-bottom-20">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<h1 class="breadcrumb-page-title">Direktori <?php echo $n['nama_kategori']; ?></h1>
							</div> <!-- .col-md-6 -->
							<div class="col-md-6 col-sm-6 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="./">Beranda</a></li>
									<li><?php echo $n['nama_kategori']; ?></li>
								</ol>
							</div> <!-- .col-md-6 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .breadcrumb-wrapper -->
				<div class="row">		
					<?php 
					  $p      = new Paging3;
					  $batas  = 10;
					  $posisi = $p->cariPosisi($batas);
					  
					  // Tampilkan daftar berita sesuai dengan kategori yang dipilih
					 	$sql   = "SELECT * FROM berita WHERE id_kategori='".$val->validasi($_GET['id'],'sql')."' 
					            ORDER BY id_berita DESC LIMIT $posisi,$batas";		 
						$hasil = mysql_query($sql);
						$jumlah = mysql_num_rows($hasil);
						// Apabila ditemukan berita dalam kategori
						if ($jumlah > 0){
					   while($r=mysql_fetch_array($hasil)){
						    // Tampilkan hanya sebagian isi berita
						    $isi_berita = htmlentities(strip_tags($r[isi_berita])); // membuat paragraf pada isi berita dan mengabaikan tag html
						    $isi = substr($isi_berita,0,200); // ambil sebanyak 220 karakter
						    $isi = substr($isi_berita,0,strrpos($isi," ")); // potong per spasi kalimat
						 ?>
						 	<div class="col-md-12 col-sm-12 col-xs-12 masonry-grid-item no-padding">
						<article class="content-box box-img bg-light box-clickable media">
							<div class="box-body media">
								<!-- image-mobile -->
								<div class="media-left foto-list-kecil visible-xs no-padding margin-bottom-10">
									<img class="img-responsive media-object borderthumb" src="foto_berita/<?php echo $r['gambar']; ?>" alt="<?php echo $r['judul']; ?>">
								</div>
								<!-- image-dekstop -->
								<div class="media-left hidden-xs">
									<img class="media-object foto-list-besar borderthumb" src="foto_berita/<?php echo $r['gambar']; ?>" alt="<?php echo $r['judul']; ?>" width="190" height="120">
								</div>
								<div class="media-body">
									<h3>
										<a href="baca-berita-<?php echo $r['id_berita']."-".$r['judul_seo'].".html"; ?>"><?php echo $r['judul']; ?></a>
									</h3>

									<ul class="list-inline small">
										<li><span class="label label-warning"><i class="fa fa-calendar"></i> 29 Oktober 2017</span></li>
										<li style="margin-top: 5px;"><?php echo $isi; ?> ...
											<a href="#">
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
						
					  $jmldata     = mysql_num_rows(mysql_query("SELECT * FROM berita WHERE id_kategori='".$val->validasi($_GET['id'],'sql')."'"));
					  $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
					  $linkHalaman = $p->navHalaman($_GET[halkategori], $jmlhalaman);

					  echo "<div class='col-md-12 col-sm-12 col-xs-12 text-center'>
							<div class='row' align='center'><center><ul class='pagination'>$linkHalaman</ul></center></div></div>";
					  }
					  else{
					    echo "<h3><center>Belum ada berita pada kategori ini.</center>";
					  }
					?>
				</div>
			</div> <!-- .col-md-9 -->
			<div class="col-md-4 right-column no-padding">
				<?php include "sidebarkanan.php"; ?>
			</div> <!-- .col-md-4 -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</section>
<?php           
}	
// Modul semua pengumuman
elseif ($_GET['module']=='semuapengumuman'){
?>
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
				  $batas  = 10;
				  $posisi = $p->cariPosisi($batas); 
				  // Tampilkan semua agenda
				 	$sql = mysql_query("SELECT * FROM pengumuman  
				                      ORDER BY id_pengumuman DESC LIMIT $posisi,$batas");		 
				  while($d=mysql_fetch_array($sql)){
				    $tgl_posting = tgl_indo($d['tgl_posting']);
				    
				    // Tampilkan hanya sebagian isi berita
				      $isi_pengumuman = htmlentities(strip_tags($d[isi_pengumuman])); // membuat paragraf pada isi berita dan mengabaikan tag html
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
					
				  $jmldata     = mysql_num_rows(mysql_query("SELECT * FROM agenda"));
				  $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
				  $linkHalaman = $p->navHalaman($_GET[halpengumuman], $jmlhalaman);
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
<?php             
}
// Modul semua agenda
elseif ($_GET['module']=='semuaagenda'){
?>
<section class="site-content">
	<div class="container">
		<div class="row">
			<div class="col-md-8 padding-bottom-20 left-column no-padding">
				<div class="breadcrumb-wrapper bg-medium margin-bottom-20">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<h1 class="breadcrumb-page-title">Daftar Agenda</h1>
							</div> <!-- .col-md-6 -->
							<div class="col-md-6 col-sm-6 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="./">Beranda</a></li>
									<li>Agenda Kegiatan</li>
								</ol>
							</div> <!-- .col-md-6 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div>
				<div class="row">
				<?php 
				  $p      = new Paging4;
				  $batas  = 6;
				  $posisi = $p->cariPosisi($batas); 
				  // Tampilkan semua agenda
				 	$sql = mysql_query("SELECT * FROM agenda  
				                      ORDER BY id_agenda DESC LIMIT $posisi,$batas");		 
				  while($d=mysql_fetch_array($sql)){
				    $tgl_posting = tgl_indo($d['tgl_posting']);
				    $tgl_mulai   = tgl_indo($d['tgl_mulai']);
				    $tgl_selesai = tgl_indo($d['tgl_selesai']);
				    $isi_agenda  = nl2br($d['isi_agenda']);
				    ?>
				          <div class="col-md-12 col-sm-12 col-xs-12 masonry-grid-item no-padding">
						<article class="content-box box-img bg-light box-clickable media">
							<div class="box-body media">
								<div class="media-left">
									<div class="event-date margin-bottom-5">
										<p><?php echo konversi_tanggal("j",$d['tgl_posting']); ?></p>
										<small class="uppercase"><?php echo konversi_tanggal("M",$d['tgl_posting']); ?></small>
									</div>
								</div> <!-- .media-left -->

								<div class="media-body">
								<h5><b><?php echo $d['tema']; ?></b></h5>

								<ul class="list-inline small">
									<li><b><i>
										<i class="fa fa-calendar"></i> <?php echo $tgl_posting; ?></i></b><b><i>
										<i class="fa fa-map-marker"></i> <?php echo $d['tempat']." - ".$tgl_mulai." s/d ".$tgl_selesai." Pukul ".$d['jam']; ?></i></b>
										<b>
										<i class="fa fa-user"></i> <?php echo $d['pengirim']; ?></b>
										</li>
									<li style="margin-top: 5px;">
			                            <?php echo $isi_agenda; ?>
									</li>
								</ul>
								</div>
							</div>
						</article>
					</div>
				          <?php
					 }
					
				  $jmldata     = mysql_num_rows(mysql_query("SELECT * FROM agenda"));
				  $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
				  $linkHalaman = $p->navHalaman($_GET[halagenda], $jmlhalaman);
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
<?php             
}
// MODUL DETAIL PENGUMUMAN
elseif ($_GET['module']=='detailpengumuman'){
	$detail=mysql_query("SELECT * FROM pengumuman,users 
                      WHERE pengumuman.username=users.username AND id_pengumuman='".$val->validasi($_GET['id'],'sql')."'");
	$d   = mysql_fetch_array($detail);
  	$tgl_posting   = tgl_indo($d['tgl_posting']);
?>
<section class="site-content padding-bottom-0 margin-top-15">
	<div class="container">
		<div class="row">
			<div class="col-md-8 left-column no-padding">
				<div class="breadcrumb-wrapper bg-medium">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<ol class="breadcrumb">
									<li><a href="./">Beranda</a></li>
									<li><a href="#">Pengumuman</a></li>
								</ol>
							</div> <!-- .col-md-12 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div>
				<h1 class="margin-top-15"><?php echo $d['judul']; ?></h1>
				<ul class="list-inline small font-weight-600 myriadpro">
					<li><i class="fa fa-calendar"></i> <?php echo $tgl_posting; ?></li>
					<li><i class="fa fa-user"></i> <?php echo $d['nama_lengkap']; ?></li>
				</ul>
				
				<article class="news margin-bottom-15">
					<div class="divider-light"></div>
					<div style="text-align: justify;"><p><?php echo $d['isi_pengumuman']; ?></p></div>
					<div class="clearfix"></div>
				</article>

				<ul class="rrssb-buttons margin-bottom-15">
		<li class="rrssb-facebook">
			<!--  Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header:
				  https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $tiden['alamat_website']."/baca-pengumuman-".$d['id_pengumuman']."-".$d['judul_seo'].".html"; ?>" class="popup">
			  <span class="rrssb-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg>
			  </span>
			  <span class="rrssb-text">facebook</span>
			</a>
		</li>

		<li class="rrssb-linkedin">
			<!-- Replace href with your meta and URL information -->
			<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $tiden['alamat_website']."/baca-pengumuman-".$d['id_pengumuman']."-".$d['judul_seo'].".html"; ?>" class="popup">
			  <span class="rrssb-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M25.424 15.887v8.447h-4.896v-7.882c0-1.98-.71-3.33-2.48-3.33-1.354 0-2.158.91-2.514 1.802-.13.315-.162.753-.162 1.194v8.216h-4.9s.067-13.35 0-14.73h4.9v2.087c-.01.017-.023.033-.033.05h.032v-.05c.65-1.002 1.812-2.435 4.414-2.435 3.222 0 5.638 2.106 5.638 6.632zM5.348 2.5c-1.676 0-2.772 1.093-2.772 2.54 0 1.42 1.066 2.538 2.717 2.546h.032c1.71 0 2.77-1.132 2.77-2.546C8.056 3.593 7.02 2.5 5.344 2.5h.005zm-2.48 21.834h4.896V9.604H2.867v14.73z"/></svg>
			  </span>
			  <span class="rrssb-text">linkedin</span>
			</a>
		</li>

		<li class="rrssb-twitter">
			<!-- Replace href with your Meta and URL information  -->
			<a href="https://twitter.com/intent/tweet?text=<?php echo $tiden['alamat_website']."/baca-pengumuman-".$d['id_pengumuman']."-".$d['judul_seo'].".html"; ?>"
			class="popup">
			  <span class="rrssb-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg>
			  </span>
			  <span class="rrssb-text">twitter</span>
			</a>
		  </li>

		  <li class="rrssb-googleplus">
			<!-- Replace href with your meta and URL information.  -->
			<a href="https://plus.google.com/share?url=<?php echo $tiden['alamat_website']."/baca-pengumuman-".$d['id_pengumuman']."-".$d['judul_seo'].".html"; ?>" class="popup">
			  <span class="rrssb-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 8.29h-1.95v2.6h-2.6v1.82h2.6v2.6H21v-2.6h2.6v-1.885H21V8.29zM7.614 10.306v2.925h3.9c-.26 1.69-1.755 2.925-3.9 2.925-2.34 0-4.29-2.016-4.29-4.354s1.885-4.353 4.29-4.353c1.104 0 2.014.326 2.794 1.105l2.08-2.08c-1.3-1.17-2.924-1.883-4.874-1.883C3.65 4.586.4 7.835.4 11.8s3.25 7.212 7.214 7.212c4.224 0 6.953-2.988 6.953-7.082 0-.52-.065-1.104-.13-1.624H7.614z"/></svg>            </span>
			  <span class="rrssb-text">google+</span>
			</a>
		  </li>

		  <li class="rrssb-whatsapp"><a href="whatsapp://send?text=<?php echo $tiden['alamat_website']."/baca-pengumuman-".$d['id_pengumuman']."-".$d['judul_seo'].".html"; ?>" data-action="share/whatsapp/share"><span class="rrssb-icon">
				  <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewbox="0 0 90 90">
					<path d="M90 43.84c0 24.214-19.78 43.842-44.182 43.842a44.256 44.256 0 0 1-21.357-5.455L0 90l7.975-23.522a43.38 43.38 0 0 1-6.34-22.637C1.635 19.63 21.415 0 45.818 0 70.223 0 90 19.628 90 43.84zM45.818 6.983c-20.484 0-37.146 16.535-37.146 36.86 0 8.064 2.63 15.533 7.076 21.61l-4.64 13.688 14.274-4.537A37.122 37.122 0 0 0 45.82 80.7c20.48 0 37.145-16.533 37.145-36.857S66.3 6.983 45.818 6.983zm22.31 46.956c-.272-.447-.993-.717-2.075-1.254-1.084-.537-6.41-3.138-7.4-3.495-.993-.36-1.717-.54-2.438.536-.72 1.076-2.797 3.495-3.43 4.212-.632.72-1.263.81-2.347.27-1.082-.536-4.57-1.672-8.708-5.332-3.22-2.848-5.393-6.364-6.025-7.44-.63-1.076-.066-1.657.475-2.192.488-.482 1.084-1.255 1.625-1.882.543-.628.723-1.075 1.082-1.793.363-.718.182-1.345-.09-1.884-.27-.537-2.438-5.825-3.34-7.977-.902-2.15-1.803-1.793-2.436-1.793-.63 0-1.353-.09-2.075-.09-.722 0-1.896.27-2.89 1.344-.99 1.077-3.788 3.677-3.788 8.964 0 5.288 3.88 10.397 4.422 11.113.54.716 7.49 11.92 18.5 16.223 11.01 4.3 11.01 2.866 12.996 2.686 1.984-.18 6.406-2.6 7.312-5.107.9-2.513.9-4.664.63-5.112z"></path>
				  </svg></span><span class="rrssb-text">Whatsapp</span>
			</a>
		</li>
	</ul>
		<ul class="list-inline small font-weight-600 myriadpro">
			<li><i class="fa fa-calendar"></i> <?php echo $tgl_posting; ?></li>
			<li><i class="fa fa-user"></i> <?php echo $d['nama_lengkap']; ?></li>
		</ul>

		<div class="divider-light"></div>
				<div id="disqus_thread"></div>
		<div class="clearfix margin-bottom-15"></div>
		
			</div>

			<div class="col-md-4 right-column no-padding">
				<?php include "sidebarkanan.php"; ?>
			</div>
		</div>
	</div>
</section>
<?php         
}
// Modul semua download
elseif ($_GET['module']=='semuadownload'){
?>
<section class="site-content">
	<div class="container">
		<div class="row">
			<div class="col-md-8 padding-bottom-20 left-column no-padding">
				<div class="breadcrumb-wrapper bg-medium margin-bottom-20">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<h1 class="breadcrumb-page-title">Direktori Download</h1>
							</div> <!-- .col-md-6 -->
							<div class="col-md-6 col-sm-6 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="./">Beranda</a></li>
									<li>Direktori Download</li>
								</ol>
							</div> <!-- .col-md-6 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div>
				<div class="row">
				<?php 
				  $p      = new Paging5;
				  $batas  = 10;
				  $posisi = $p->cariPosisi($batas);
				  // Tampilkan semua download
				 	$sql = mysql_query("SELECT * FROM download  
				                      ORDER BY id_download DESC LIMIT $posisi,$batas");			 
				  while($d=mysql_fetch_array($sql)){
				    $tgl_posting = tgl_indo($d['tgl_posting']);
				    $tgl_mulai   = tgl_indo($d['tgl_mulai']);
				    $tgl_selesai = tgl_indo($d['tgl_selesai']);
				    $isi_agenda  = nl2br($d['isi_agenda']);
				    ?>
				    <div class="col-md-12 col-sm-12 col-xs-12 masonry-grid-item no-padding">
						<article class="content-box box-img bg-light box-clickable media">
							<div class="box-body media">
								<div class="media-left">
									<div class="event-date margin-bottom-5">
										<img src="images/attachment.jpg" width="100%" />
									</div>
								</div>
								<div class="media-body">
									<h5><b><?php echo $d['judul']; ?></b></h5>
									<ul class="list-inline small">
										<li><b><a href="downlot.php?file=<?php echo $d['nama_file']; ?>">
											<i class="fa fa-download"></i> <?php echo " Telah di download sebanyak (".$d['hits'].") kali"; ?></a></b></li>
									</ul>
								</div>
							</div>
						</article>
					</div>
				          <?php
					 }
					
				  $jmldata     = mysql_num_rows(mysql_query("SELECT * FROM download"));
				  $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
				  $linkHalaman = $p->navHalaman($_GET[haldownload], $jmlhalaman);
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
<?php             
}
// Modul Detail Album (Lihat Gallery)
elseif ($_GET['module']=='detailalbum'){
	$ambilalbum=mysql_query("SELECT * FROM album WHERE id_album='".$val->validasi($_GET['id'],'sql')."'");
	$dalb=mysql_fetch_array($ambilalbum);
?>
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
						  $batas  = 10;
						  $posisi = $p->cariPosisi($batas);

						  $g = mysql_query("SELECT * FROM gallery WHERE id_album='".$val->validasi($_GET['id'],'sql')."' ORDER BY id_gallery DESC LIMIT $posisi,$batas");
  						  $ada = mysql_num_rows($g);
  						  if ($ada > 0) {
  						  while ($w = mysql_fetch_array($g)) {
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
						  $jmldata     = mysql_num_rows(mysql_query("SELECT * FROM gallery WHERE id_album='".$val->validasi($_GET['id'],'sql')."'"));
						  $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
						  $linkHalaman = $p->navHalaman($_GET[halgaleri], $jmlhalaman);	
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
<?php             
}
// Modul semua album
elseif ($_GET['module']=='semuaalbum'){
 ?>
<section class="site-content">
	<div class="container">
		<div class="row">

			<div class="col-md-8 padding-bottom-20 left-column no-padding">
				<div class="breadcrumb-wrapper bg-medium margin-bottom-20">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<h1 class="breadcrumb-page-title">Direktori Foto</h1>
							</div> <!-- .col-md-6 -->
							<div class="col-md-6 col-sm-6 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="index.html">Beranda</a></li>
									<li>Foto</li>
								</ol>
							</div> <!-- .col-md-6 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .breadcrumb-wrapper -->

				<div class="row">
				<?php
				$p      = new PagingAlbum;
				$batas  = 7;
				$posisi = $p->cariPosisi($batas);
				$a = mysql_query("SELECT jdl_album, album.id_album, gbr_album, album_seo,  
                  COUNT(gallery.id_gallery) as jumlah 
                  FROM album LEFT JOIN gallery 
                  ON album.id_album=gallery.id_album 
                  WHERE album.aktif='Y'  
                  GROUP BY jdl_album LIMIT $posisi, $batas");
				while ($w = mysql_fetch_array($a)) {
				?>				
				<div class="col-md-12 col-sm-12 col-xs-12 masonry-grid-item no-padding">

					<article class="content-box box-img bg-light box-clickable media">
						<div class="box-body media">
							<div class="media-left visible-xs no-padding margin-bottom-10">
								<img class="img-responsive media-object borderthumb" src="img_album/kecil_<?php echo $w['gbr_album']; ?>" alt="<?php echo $w['jdl_album']; ?>" style="width: 100%;height: auto; ">
							</div>
							<div style="float:left; margin-right: 10px;" class="media-left hidden-xs">
								<img class="media-object borderthumb" src="img_album/kecil_<?php echo $w['gbr_album']; ?>" alt="<?php echo $w['jdl_album']; ?>" width="190" height="120">
							</div>
							<div class="media-body">
							<h3>
								<a href="lihat-foto-<?php echo $w['id_album']."-".$w['album_seo']; ?>.html"><?php echo $w['jdl_album']; ?></a>
							</h3>
							<ul class="list-inline small">
									<i class="fa fa-images"></i> - Jumlah Foto: <span class="label label-default"><?php echo $w['jumlah']; ?></span>
								</li>
								<li style="margin-top: 5px;">
		                            <a href="#">
		                            	<span></span>
		                            </a>
								</li>
							</ul>
							</div>
						</div> <!-- .box-body -->

					</article> <!-- .content-box -->
				</div> <!-- .masonry-grid-item -->
				<?php } 
					$jmldata     = mysql_num_rows(mysql_query("SELECT * FROM album"));
					$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
					$linkHalaman = $p->navHalaman($_GET[halalbum], $jmlhalaman);	
				?>
							
									
				<div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <div class="row" align="center">
      				<ul class="pagination"><?php echo $linkHalaman; ?></ul></div>				</

				</div>

				</div>

				</div>
				</div>
			
			<div class="col-md-4 right-column no-padding">
				<?php include "sidebarkanan.php"; ?>
			</div> <!-- .col-md-4 -->

		</div> <!-- .row -->
	</div> <!-- .container -->
</section>
 <?php           
}
// Modul hubungi kami
elseif ($_GET['module']=='hubungikami'){
?>
<section class="site-content">
	<div class="container">
		<div class="row">

			<div class="col-md-8 padding-bottom-20 left-column no-padding">
				<div class="breadcrumb-wrapper bg-medium margin-bottom-20">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<h1 class="breadcrumb-page-title">Contact Us</h1>
							</div> <!-- .col-md-6 -->
							<div class="col-md-6 col-sm-6 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="index.html">Beranda</a></li>
									<li>Contact Us</li>
								</ol>
							</div> <!-- .col-md-6 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .breadcrumb-wrapper -->

				<div class="row">
					<div class="col-md-12 col-sm-12 no-padding">
						<div class="well">
							<form method="post" action="hubungi-aksi.html">
								<div class="col-md-12 col-xs-12">
									<label>Nama Anda</label>
									<input type="text" name="nama" class="form-control" id="nama">&nbsp;
								</div>
								<div class="col-md-12 col-xs-12">
									<label>Email Anda</label>
									<input type="text" name="email" class="form-control" id="email">&nbsp;
								</div>
								<div class="col-md-12 col-xs-12">
									<label>Subjek</label>
									<input type="text" name="subjek" class="form-control" id="subjek">&nbsp;
								</div>
								<div class="col-md-12 col-xs-12">
									<label>Pesan</label>
									<textarea class="form-control" name="pesan" id="pesan"></textarea>&nbsp;
								</div>
								<div class="col-md-12 col-xs-12">
									<img src='captcha.php' width="20%"><br><br>
									<label>Masukkan 6 kode diatas</label>&nbsp;
									<input type="text" name="kode" size="6" maxlength="6" style="width: 30%;" class="form-control" id="subjek">&nbsp;
								</div>
								<hr />
								<input value="Kirim Pesan" name="kirim" id="submit" type="submit" class="btn btn-primary btn-lg btn-block"/>
							</form>
						</div>
					</div> <!-- .col-md-6 -->

				</div> <!-- .row -->
			</div> <!-- .col-md-9 -->

			<div class="col-md-4 right-column no-padding">
				<?php include "sidebarkanan.php"; ?>
			</div> <!-- .col-md-4 -->


		</div> <!-- .row -->
	</div> <!-- .container -->
</section>
<?php            
}
// Modul hubungi aksi
elseif ($_GET['module']=='hubungiaksi'){
?>
<section class="site-content">
	<div class="container">
		<div class="row">

			<div class="col-md-8 padding-bottom-20 left-column no-padding">
				<div class="breadcrumb-wrapper bg-medium margin-bottom-20">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<h1 class="breadcrumb-page-title">Contact Us</h1>
							</div> <!-- .col-md-6 -->
							<div class="col-md-6 col-sm-6 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="index.html">Beranda</a></li>
									<li>Contact Us</li>
								</ol>
							</div> <!-- .col-md-6 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .breadcrumb-wrapper -->

				<div class="row">
					<div class="col-md-12 col-sm-12 no-padding">
						<div class="well">
<?php
$nama=trim($_POST[nama]);
$email=trim($_POST[email]);
$subjek=trim($_POST[subjek]);
$pesan=trim($_POST[pesan]);

if (empty($nama)){
  echo "Anda belum mengisikan NAMA<br />
  	      <a href=javascript:history.go(-1)><b>Ulangi Lagi</b>";
}
elseif (empty($email)){
  echo "Anda belum mengisikan EMAIL<br />
  	      <a href=javascript:history.go(-1)><b>Ulangi Lagi</b>";
}
elseif (empty($subjek)){
  echo "Anda belum mengisikan SUBJEK<br />
  	      <a href=javascript:history.go(-1)><b>Ulangi Lagi</b>";
}
elseif (empty($pesan)){
  echo "Anda belum mengisikan PESAN<br />
  	      <a href=javascript:history.go(-1)><b>Ulangi Lagi</b>";
}
else{
	if(!empty($_POST['kode'])){
		if($_POST['kode']==$_SESSION['captcha_session']){

  mysql_query("INSERT INTO hubungi(nama_pengirim,
                                   email,
                                   subjek,
                                   pesan,
                                   tanggal) 
                        VALUES('$_POST[nama]',
                               '$_POST[email]',
                               '$_POST[subjek]',
                               '$_POST[pesan]',
                               '$tgl_sekarang')");
  echo "<span class=posting>&#187; <b>Hubungi Kami</b></span><br /><br />"; 
  echo "<p align=center><b>Terimakasih telah menghubungi kami. <br /> Kami akan segera meresponnya.</b></p>";
		}else{
			echo "Kode yang Anda masukkan tidak cocok<br />
			      <a href=javascript:history.go(-1)><b>Ulangi Lagi</b></a>";
		}
	}else{
		echo "Anda belum memasukkan kode<br />
  	      <a href=javascript:history.go(-1)><b>Ulangi Lagi</b></a>";
	}
}
?>
						</div>
					</div> 
				</div> <!-- .row -->
			</div> <!-- .col-md-9 -->

			<div class="col-md-4 right-column no-padding">
				<?php include "sidebarkanan.php"; ?>
			</div> <!-- .col-md-4 -->


		</div> <!-- .row -->
	</div> <!-- .container -->
</section>
<?php            
}
// Modul hasil pencarian berita 
elseif ($_GET['module']=='hasilcari'){
?>
<section class="site-content">
	<div class="container">
		<div class="row">

			<div class="col-md-8 padding-bottom-20 left-column no-padding">
				<div class="breadcrumb-wrapper bg-medium margin-bottom-20">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<h1 class="breadcrumb-page-title">Hasil Pencarian</h1>
							</div> <!-- .col-md-6 -->
							<div class="col-md-6 col-sm-6 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="index.html">Beranda</a></li>
									<li>Hasil Pencarian</li>
								</ol>
							</div> <!-- .col-md-6 -->
						</div> <!-- .row -->
					</div> <!-- .container -->
				</div> <!-- .breadcrumb-wrapper -->

				<div class="row">
					<div class="col-md-12 col-sm-12 no-padding">
						<div class="well">
<?php
  // menghilangkan spasi di kiri dan kanannya
  $kata = trim($_POST['kata']);
  // mencegah XSS
  $kata = htmlentities(htmlspecialchars($kata), ENT_QUOTES);

  // pisahkan kata per kalimat lalu hitung jumlah kata
  $pisah_kata = explode(" ",$kata);
  $jml_katakan = (integer)count($pisah_kata);
  $jml_kata = $jml_katakan-1;

  $cari = "SELECT * FROM berita WHERE " ;
    for ($i=0; $i<=$jml_kata; $i++){
      $cari .= "judul OR isi_berita LIKE '%$pisah_kata[$i]%'";
      if ($i < $jml_kata ){
        $cari .= " OR ";
      }
    }
  $cari .= " ORDER BY id_berita DESC LIMIT 7";
  $hasil  = mysql_query($cari);
  $ketemu = mysql_num_rows($hasil);

  if ($ketemu > 0){
    echo "<p>Ditemukan <b>$ketemu</b> berita dengan kata <font style='background-color:#00FFFF'><b>$kata</b></font> : </p>"; 
    while($t=mysql_fetch_array($hasil)){
		echo "<table><tr><td><span class=judul><a href=baca-berita-$t[id_berita]-$t[judul_seo].html>$t[judul]</a></span><br />";
      // Tampilkan hanya sebagian isi berita
      $isi_berita = htmlentities(strip_tags($t[isi_berita])); // membuat paragraf pada isi berita dan mengabaikan tag html
      $isi = substr($isi_berita,0,250); // ambil sebanyak 150 karakter
      $isi = substr($isi_berita,0,strrpos($isi," ")); // potong per spasi kalimat

      echo "$isi ... <a href=baca-berita-$t[id_berita]-$t[judul_seo].html>Selengkapnya</a>
            <br /></td></tr>
            </table><hr color=#CCC noshade=noshade />";
    }                                                          
  }
  else{
    echo "<p></p><p align=center>Tidak ditemukan berita dengan kata <b>$kata</b></p>";
  }
?>
		</div>
					</div> 
				</div> <!-- .row -->
			</div> <!-- .col-md-9 -->

			<div class="col-md-4 right-column no-padding">
				<?php include "sidebarkanan.php"; ?>
			</div> <!-- .col-md-4 -->


		</div> <!-- .row -->
	</div> <!-- .container -->
</section>
<?php          
}

else{
	echo "<h1><center>HALAMAN TIDAK DITEMUKAN ATAU MODUL BELUM TERSEDIA</center></h1>";
}
 ?>