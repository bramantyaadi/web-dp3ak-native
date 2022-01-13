<div class="sticky-header-container">
		<div id="sticky-header" class="header-main header-transparent navbar mega-menu" data-spy="affix" data-offset-top="10">
			<div class="container">
				<div class="navbar-container">
					<div class="navbar-header">
						<!-- logo utama -->
						<a href="./" class="navbar-brand hidden-xs hidden-sm">
							<img class="img-responsive logo" src="./images/<?php echo $tiden['logo']; ?>">
						</a>

						<!-- logo mobile -->
						<a href="./" class="visible-xs visible-sm">
							<img class="img-responsive mbl" src="./images/<?php echo $tiden['logo']; ?>">
						</a>

						<!-- tombol menu mobile -->
						<a class="btn btn-default nav-toggle visible-xs visible-sm" ontouchstart>
							<span class="sr-only">Toggle navigation</span>
							<i class="fa fa-bars"></i>
						</a>
					</div><!-- .navbar-header -->

					<nav class="navbar-left">
						<ul class="nav navbar-nav main-nav">

							<!-- mobile menu visible -->
							<li class="visible-xs visible-sm">
								<!-- tombol close -->
								<a class="nav-toggle text-center">
									<i class="fa fa-times"></i>
									<span class="sr-only">Close navigation</span>
								</a>
							</li>
							<li class="visible-sm visible-xs">
								<!-- Form Pencarian Mobile -->
								<form action="hasil-pencarian.html" method="post">
									<label class="sr-only" for="search-site-2">
										Pencarian
									</label>
									<input id="search-site-2" type="text" class="form-control" autocomplete="off" placeholder="Pencarian" name="kata" />
								</form>
								<ul class="nav nav-mobile-cta">
									<!-- Menu untuk mobile -->
								</ul>
							</li>
							<li class="nav-info-for visible-xs visible-sm">
								<h3>Menu&hellip;</h3>
							</li>
							<!-- <li class="visible-xs visible-sm"><a href="#">Download</a></li>
							<li class="visible-xs visible-sm"><a href="#">Kontak</a></li> -->
							<!-- .mobile menu visible -->
							<?php               
							  $main=mysql_query("SELECT * FROM menu WHERE id_parent=0 AND aktif='Y'");
							  while($r=mysql_fetch_array($main)){
								$sub=mysql_query("SELECT * FROM menu WHERE id_parent=$r[id_menu] AND aktif='Y'");
								$jml=mysql_num_rows($sub);
								// apabila sub menu ditemukan                
								if ($jml > 0){
								  echo "<li class='dropdown'><a href='$r[link]' class='dropdown-toggle' style='text-transform: uppercase;' data-toggle='dropdown'>$r[nama_menu]</a>";
								  echo "<ul class='dropdown-menu'>";                 
									while($w=mysql_fetch_array($sub)){
									echo "<li><a href='$w[link]'>$w[nama_menu]</a></li>";
									}           
								 echo "</ul>
									   </li>";
								}
								else{
								  echo "<li class='dropdown'><a href='$r[link]' style='text-transform: uppercase;'>$r[nama_menu]</a></li>";
								}
							  }        
							?>	
					</ul>
					</nav>
				</div> <!-- .navbar-container -->
			</div> <!-- .container -->
		</div> <!-- .header-main -->
</div> <!-- .sticky-header-container -->
	<div class="header-top header-primary hidden-xs hidden-sm">
		<div class="top-search-container">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<form action="hasil-pencarian.html" method="POST">
							<label class="sr-only" for="search-site">
							Pencarian
							</label>
							<div class="input-group">
								<input id="search-site" type="text" class="form-control" autocomplete="off" placeholder="Pencarian" name="kata" />
								<span class="input-group-btn">
									<button class="btn btn-light" type="submit">Cari</button>
								</span>
							</div> <!-- .input-group -->
						</form>
					</div> <!-- .col-md-12 -->
				</div> <!-- .row -->
			</div> <!-- .container -->
		</div> <!-- .top-search-container -->

		<div class="container">
			<div class="row">
				<div class="col-md-9">

						<!-- get marquee css -->
						<link type="text/css" href="<?php echo "$f[folder]/"; ?>assets/css/jquery.marquee.min.css" rel="stylesheet" title="default" media="all">
						
						<div class="row-fluid running-text">
							<div class="media-left">
								<i class="fa fa-file-text" style="color: #fff;"></i>
							</div>
							<div class="media-body">
							<!-- ul running text -->
							<ul id="marquee1" class="marquee">
								<?php 
								$sekilas=mysql_query("SELECT info FROM sekilasinfo ORDER BY id_sekilas DESC LIMIT 10");
								while($ts=mysql_fetch_array($sekilas)){
								?>
								<li class="myriadpro kecil"><?php echo $ts['info']; ?></li>
								<?php } ?>
							</ul>
							<!-- .ul running text -->
							</div>
						</div>
				</div> <!-- .col-md-offset-2 col-md-6 -->

				<div class="col-md-3">
					<!-- nav pencarian -->
					<nav class="navbar-right hidden-xs hidden-sm">
						<form class="no-margin" action="hasil-pencarian.html" method="POST">
							<input class="search" name="kata" type="text" placeholder="Pencarian Berita" required="">
							<button class="button" type="submit"><i class="fa fa-search"></i></button>
						</form>
					</nav>
					<!-- .nav pencarian -->
				</div> <!-- .col-md-4 -->
			</div> <!-- .row -->
		</div> <!-- .container -->
	</div> <!-- .header-top -->