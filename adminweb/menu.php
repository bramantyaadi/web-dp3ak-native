<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = 'index.php'</script>"; 
}
// Apabila user sudah login dengan benar, maka terbentuklah session

else{
	$module=$_GET['module'];
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="<?php if($module=="beranda") echo "active"; ?>"><a href="?module=beranda" title="beranda"><i class="fa fa-dashboard"></i> <span>Beranda</span></a></li>
            <li class="treeview <?php if($module=="identitas" || $module=="modul" || $module=="user" || $module=="slider" || $module=="menu" || $module=="logo" || $module=="fopim" || $module=="listslider") echo "active"; ?>">
				<a href="#">
					<i class="fa fa-gear"></i>
					<span><b>Setting Web</b></span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php
					if($_SESSION['leveluser']=="admin"){
					?>
					<li class="<?php if($module=="identitas") echo "active"; ?>"><a href="?module=identitas"><i class="fa fa-circle-o"></i> <span>Identitas Web</span></a></li>
					<li class="<?php if($module=="logo") echo "active"; ?>"><a href="?module=logo"><i class="fa fa-circle-o"></i> <span>Logo Header</span></a></li>
					<li class="<?php if($module=="fopim") echo "active"; ?>"><a href="?module=fopim"><i class="fa fa-circle-o"></i> <span>Foto Pimpinan</span></a></li>
					<li class="<?php if($module=="user") echo "active"; ?>"><a href="?module=user"><i class="fa fa-circle-o"></i> <span>Manajemen User</span></a></li>
					<li class="<?php if($module=="menu") echo "active"; ?>"><a href="?module=menu"><i class="fa fa-circle-o"></i> <span>Manajemen Menu</span></a></li>
					<li class="<?php if($module=="listslider") echo "active"; ?>"><a href="?module=listslider"><i class="fa fa-circle-o"></i> <span>List Slider</span></a></li>
					<li class="<?php if($module=="situsterkait") echo "active"; ?>"><a href="?module=situsterkait"><i class="fa fa-circle-o"></i> <span>Situs Terkait</span></a></li>
					<li class="<?php if($module=="slider") echo "active"; ?>"><a href="?module=slider"><i class="fa fa-circle-o"></i> <span>Slider Beranda</span></a></li>
					<li class="<?php if($module=="templates") echo "active"; ?>"><a href="?module=templates"><i class="fa fa-circle-o"></i> <span>Templates</span></a></li>
					<?php }
					else{
					?>
					<li class="<?php if($module=="user") echo "active"; ?>"><a href="?module=user"><i class="fa fa-circle-o"></i> <span>Manajemen User</span></a></li>
					<?php	
					}
					?>
				</ul>
			</li>			
            <li class="treeview <?php if($module=="berita" || $module=="kategori" || $module=="tag") echo "active"; ?>">
				<a href="#">
					<i class="fa fa-edit"></i>
					<span><b>Manajemen Berita</b></span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if($module=="berita") echo "active"; ?>"><a href="?module=berita"><i class="fa fa-circle-o"></i> <span>Berita</span></a></li>
					<li class="<?php if($module=="kategori") echo "active"; ?>"><a href="?module=kategori"><i class="fa fa-circle-o"></i> <span>Kategori</span></a></li>
				</ul>
			</li>
			<?php
			if($_SESSION['leveluser']=="admin"){
			?>
			<li class="<?php if($module=="halamanstatis") echo "active"; ?>"><a href="?module=halamanstatis" title="Halaman Statis"><i class="fa fa-tag"></i> <span>Halaman Statis</span></a></li>
			<?php } ?>
			<li class="treeview <?php if($module=="album" || $module=="galerifoto" || $module=="sekilasinfo") echo "active"; ?>">
				<a href="#">
					<i class="fa fa-edit"></i>
					<span><b>Media</b></span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if($module=="album") echo "active"; ?>"><a href="?module=album"><i class="fa fa-circle-o"></i> <span>Album Photo</span></a></li>
					<li class="<?php if($module=="galerifoto") echo "active"; ?>"><a href="?module=galerifoto"><i class="fa fa-circle-o"></i> <span>Galeri Photo</span></a></li>
					<li class="<?php if($module=="sekilasinfo") echo "active"; ?>"><a href="?module=sekilasinfo"><i class="fa fa-circle-o"></i> <span>Sekilas Info</span></a></li>
				</ul>
			</li>
			<li class="<?php if($module=="download") echo "active"; ?>"><a href="?module=download" title="Download"><i class="fa fa-download"></i> <span>Download</span></a></li>
            <li class="treeview <?php if($module=="agenda" || $module=="pengumuman" || $module=="polling" || $module=="hubungi") echo "active"; ?>">
				<a href="#">
					<i class="fa fa-edit"></i>
					<span><b>Interaksi</b></span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if($module=="agenda") echo "active"; ?>"><a href="?module=agenda"><i class="fa fa-circle-o"></i> <span>Agenda</span></a></li>
					<li class="<?php if($module=="pengumuman") echo "active"; ?>"><a href="?module=pengumuman"><i class="fa fa-circle-o"></i> <span>Pengumuman</span></a></li>
					<li class="<?php if($module=="polling") echo "active"; ?>"><a href="?module=polling"><i class="fa fa-circle-o"></i> <span>Polling</span></a></li>
					<li class="<?php if($module=="hubungi") echo "active"; ?>"><a href="?module=hubungi"><i class="fa fa-circle-o"></i> <span>Hubungi Kami</span></a></li>
				</ul>
			</li>
			<li class="<?php if($module=="banner") echo "active"; ?>"><a href="?module=banner" title="Banner"><i class="fa fa-tag"></i> <span>Banner</span></a></li>
			<li class="<?php if($module=="ppid") echo "active"; ?>"><a href="?module=ppid" title="Ppid"><i class="fa fa-paper-plane"></i> <span>Ppid</span></a></li>
			<li><a href="logout.php" title="Keluar"><i class="fa fa-sign-out"></i> <span>Keluar</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<?php
}
?>