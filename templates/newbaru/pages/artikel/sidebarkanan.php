<aside class="sidebar no-top-spacing">
					<div class="content-box margin-top-0 no-padding">
					    				    <div class="responsive-youtube">
				    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/6PBzJ49Yt4k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				    </div>
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
						$terbaru=mysqli_query($koneksi, "SELECT * FROM berita WHERE id_kategori='2' ORDER BY id_berita DESC LIMIT 3");
						while($bt=mysqli_fetch_array($terbaru)){      
						$tgl = tgl_indo($bt['tanggal']);
						?>
						<a href="detail-artikel-<?php echo $bt['id_berita']."-".$bt['judul_seo'];?>.html" class="list-group-item custom">
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
						$populer=mysqli_query($koneksi, "SELECT * FROM berita WHERE id_kategori='2' ORDER BY dibaca DESC LIMIT 3");
						while($bp=mysqli_fetch_array($populer)){      
						$tgl = tgl_indo($bp['tanggal']);
						?>
						<a href="detail-artikel-<?php echo $bp['id_berita']."-".$bp['judul_seo'];?>.html" class="list-group-item custom">
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
</div> <!-- .content-box -->

<div class="content-box margin-top-0 no-padding">
	<div class="row">
	<!--/////////////////////////- start main -/////////////////////-->
	<ul class="nav nav-tabs tabs-v3 nav-justified social-tabs responsive-text" role="tablist">

		<li role="presentation" class="myriadpro uppercase active">
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
		<div class="tab-pane no-padding active" id="agendakegiatan">
					<ul class="media-list">
						<?php 
						$agenda = mysqli_query($koneksi, "SELECT * FROM agenda ORDER BY id_agenda DESC LIMIT 3");
						while($tgd=mysqli_fetch_array($agenda)){
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
			$pengumuman = mysqli_query($koneksi, "SELECT * FROM pengumuman ORDER BY id_pengumuman DESC LIMIT 6");
			while($tpe=mysqli_fetch_array($pengumuman)){
			?>	
				<li class="media space margin-bottom-20">
					<div class="media-left">
						<div class="event-date margin-bottom-5">
							<i class="fa fa-bullhorn fa-3x"></i>
						</div> <!-- .event-date -->
					</div> <!-- .media-left -->

					<div class="media-body">
						<p class="small text-muted no-bottom-spacing">
							<i class="fa fa-calendar margin-right-5"></i>
							<?php echo konversi_tanggal("D, j M Y",$tpe['tgl_posting']); ?>
						</p>
						<h4 class="media-heading margin-top-5">
							<a href="baca-pengumuman-<?php echo $tpe['id_pengumuman']."-".$tpe['judul_seo']; ?>.html"><?php echo $tpe['judul']; ?></a>
						</h4>
					</div> <!-- .media-body -->
				</li>
			<?php } ?>
			</ul>
		</div>
	</div>
	<!--/////////////////////////- end main -/////////////////////-->
	</div>
</div>

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
		<?php $tanya=mysqli_query($koneksi, "SELECT * FROM poling WHERE aktif='Y' and status='Pertanyaan'");
                $t=mysqli_fetch_array($tanya); ?>
		<p><?php echo $t['pilihan']; ?></p>
		<form action="hasil-poling.html" method="post" class="bs-example form-horizontal">
			<div class="form-group">
				<div class="col-lg-10">
					<?php 
					$poling=mysqli_query($koneksi, "SELECT * FROM poling WHERE aktif='Y' and status='Jawaban' ORDER BY id_poling DESC");
	                while ($p=mysqli_fetch_array($poling)){
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

<div class="content-box no-padding">
	<div class="col-sm-12 no-padding">
		<div class="container-fluid no-margin no-padding">
			<div class="col-xs-12 padding-top-10 hal-kecil-heading">
				<!-- judul -->
				

			</div>
		</div>
	</div>

</div>
</aside>
