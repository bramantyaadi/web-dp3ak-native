<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  include "../../../config/koneksi.php";
  include "../../../config/fungsi_thumb.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Hapus banner
  if ($module=='banner' AND $act=='hapus'){    
    header("location:../../media.php?module=".$module);
  }

  // Input banner
  elseif ($module=='banner' AND $act=='input'){
        header("location:../../media.php?module=".$module); 
  }

  // Update banner
  elseif ($module=='banner' AND $act=='update'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file; 

    $id    = $_POST['id'];    
    $judul = $_POST['judul'];
    $link  = $_POST['link'];

    // Apabila gambar tidak diganti
    if (empty($lokasi_file)){
      echo "<script>window.alert('Anda belum memilih gambar...!');
              window.location=('../../media.php?module=banner')</script>";
    }
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=banner')</script>";
      }
      else{
        UploadBanner($nama_gambar, $folder, $ukuran);

        $update = "UPDATE banner SET judul       = '$judul',
                                     link        = '$link', 
                                     gambar      = '$nama_gambar' 
                               WHERE id_banner   = '$id'";
        mysqli_query($koneksi, $update);
      
        header("location:../../media.php?module=".$module);
      }
    }
  }
}
?>
