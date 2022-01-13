<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = 'index.php'</script>"; 
}
// Apabila user sudah login dengan benar, maka terbentuklah session

else{
	include "../config/library.php";

  // Home (Beranda)
  if ($_GET['module']=='beranda'){   
     include "modul/mod_beranda/beranda.php"; 
  }
  

  // Identitas Website
  elseif ($_GET['module']=='identitas'){
    if($_SESSION['leveluser']=="admin"){
      include "modul/mod_identitas/identitas.php";
    }
  }

  // Manajemen User
  elseif ($_GET['module']=='user'){
      include "modul/mod_user/user.php";
  }

  // Manajemen Modul
  elseif ($_GET['module']=='modul'){
    if($_SESSION['leveluser']=="admin"){
      include "modul/mod_modul/modul.php";
    }
  }

  // Kategori
  elseif ($_GET['module']=='kategori'){
      include "modul/mod_kategori/kategori.php";
  }

  // Bagian Berita
  elseif ($_GET['module']=='berita'){
      include "modul/mod_berita/berita.php";                            
  }

  // Tag (Berita Terkait)
  elseif ($_GET['module']=='tag'){
      include "modul/mod_tag/tag.php";
  }

  // Agenda
  elseif ($_GET['module']=='agenda'){
      include "modul/mod_agenda/agenda.php";
  }
  
  // Pengumuman
  elseif ($_GET['module']=='pengumuman'){
      include "modul/mod_pengumuman/pengumuman.php";
  }

  // Sekilasinfo
  elseif ($_GET['module']=='sekilasinfo'){
    if($_SESSION['leveluser']=="admin"){
      include "modul/mod_sekilasinfo/sekilasinfo.php";
    }
  }
  
  // Slider
  elseif ($_GET['module']=='listslider'){
    if($_SESSION['leveluser']=="admin"){
      include "modul/mod_listslider/listslider.php";
    }
  }

  // Banner
  elseif ($_GET['module']=='banner'){
      include "modul/mod_banner/banner.php";
  }

  // Slider
  elseif ($_GET['module']=='slider'){
    if($_SESSION['leveluser']=="admin"){
      include "modul/mod_slider/slider.php";
    }
  }

  // Polling
  elseif ($_GET['module']=='polling'){
      include "modul/mod_polling/polling.php";
  }
 
  // Download
  elseif ($_GET['module']=='download'){
      include "modul/mod_download/download.php";
  }

  // Hubungi Kami
  elseif ($_GET['module']=='hubungi'){
      include "modul/mod_hubungi/hubungi.php";
  }

  // Templates
  elseif ($_GET['module']=='templates'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_templates/templates.php";
    }
  }

  // Album
  elseif ($_GET['module']=='album'){
      include "modul/mod_album/album.php";
  }

  // Galeri Foto
  elseif ($_GET['module']=='galerifoto'){
      include "modul/mod_galerifoto/galerifoto.php";
  }

  // Menu Website
  elseif ($_GET['module']=='menu'){
    if($_SESSION['leveluser']=="admin"){
      include "modul/mod_menu/menu.php";
    }
  }

  // Halaman Statis
  elseif ($_GET['module']=='halamanstatis'){
    if($_SESSION['leveluser']=="admin"){
      include "modul/mod_halamanstatis/halamanstatis.php";
    }
  }
  
  // Logo Header
  elseif ($_GET['module']=='logo'){
    if($_SESSION['leveluser']=="admin"){
      include "modul/mod_logo/logo.php";
    }
  }

  // Foto Pimpinan dibawah Slider
  elseif ($_GET['module']=='fopim'){
    if($_SESSION['leveluser']=="admin"){
      include "modul/mod_fopim/fopim.php";
    }
  }
  // Foto Pimpinan dibawah Slider
  elseif ($_GET['module']=='ppid'){
    if($_SESSION['leveluser']=="admin"){
      include "modul/mod_ppid/ppid.php";
    }
  }
  // Foto Pimpinan dibawah Slider
  elseif ($_GET['module']=='situsterkait'){
    if($_SESSION['leveluser']=="admin"){
      include "modul/mod_situsterkait/situsterkait.php";
    }
  }


  // Apabila modul tidak ditemukan
  else{
?>
        <!-- Content Header (Page header) 
        <section class="content-header">
          <h1>
            Modul tidak ada.
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
          </ol>
        </section>-->

        <!-- Main content 
        <section class="content">-->

          <!-- Default box 
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Title</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              Start creating your amazing application!
            </div>--><!-- /.box-body 
            <div class="box-footer">
              Footer
            </div>--><!-- /.box-footer
          </div>--><!-- /.box -->
<!--
        </section> /.content -->

<?php
	}
}
?>