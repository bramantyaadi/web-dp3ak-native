<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = 'index.php'</script>"; 
}
// Apabila user sudah login dengan benar, maka terbentuklah session

else{
	$ambiliden = mysqli_query($koneksi, "SELECT * FROM identitas LIMIT 1");
	$tdin	   = mysqli_fetch_array($ambiliden);
	
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Administrator <?php echo $tdin['nama_pemilik']; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/font-awesome.min.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        @media (max-width: 767px) {
          #dropmen{background-color: #000000;}
        }
    </style>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <a href="media.php?module=beranda" class="logo">
          <span class="logo-mini"><b>A</b>dmin</span>
          <span class="logo-lg">Admin<b>istrator</b></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
		  <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="../" target="_blank" title="Lihat Website"><i class="fa fa-laptop"></i></a>
              </li>
			  <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Tambah"><i class="fa fa-plus"></i></a>
				<ul class="dropdown-menu" id="dropmen">
          <li><a href="?module=berita&act=tambahberita" title="Tambah Berita">Berita</a></li>
          <li><a href="?module=halamanstatis&act=tambahhalamanstatis" title="Tambah Halaman">Halaman</a></li>
          <li><a href="?module=agenda&act=tambahagenda" title="Agenda">Agenda</a></li>
					<li><a href="?module=pengumuman&act=tambahpengumuman" title="Pengumuman">Pengumuman</a></li>
          <li><a href="?module=album&act=tambahalbum" title="Berita Photo">Berita Photo</a></li>
          <li><a href="?module=galerifoto&act=tambahgalerifoto" title="Tambah Galeri Berita">Galeri Berita</a></li>
          <li><a href="?module=download&act=tambahdownload" title="Tambah Download">Download</a></li>
				</ul>
			  </li>
              <li class="dropdown user user-menu">
                <a href="#">
					<i class="fa fa-user"></i>
                  <span class="hidden-xs"><?php echo $_SESSION['namalengkap']; ?></span>
                </a>
              </li>
			  <li>
                <a href="logout.php" title="KELUAR"><i class="fa fa-sign-out"></i></a>
              </li>
			  <!--<li>
                <a href="#" data-toggle="control-sidebar" title="Option"><i class="fa fa-gears"></i></a>
              </li>-->
            </ul>
          </div>
        </nav>
      </header>
<?php
}
?>