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

  // Hapus slider
  if ($module=='slider' AND $act=='hapus'){
    $query = "SELECT gmb_slider FROM slider WHERE id_slider='$_GET[id]'";
    $hapus = mysqli_query($koneksi, $query);
    $r     = mysqli_fetch_array($hapus);
    
    if ($r['gmb_slider']!=''){
      $namafile = $r['gmb_slider'];
      
      // hapus filenya
      unlink("../../../foto_slider/$namafile");   
      unlink("../../../foto_slider/small_$namafile");   

      // hapus data slider di database 
      mysqli_query($koneksi, "DELETE FROM slider WHERE id_slider='$_GET[id]'");      
    }
    else{
      mysqli_query($koneksi, "DELETE FROM slider WHERE id_slider='$_GET[id]'");      
    }
    header("location:../../media.php?module=".$module);
  }

  // Input slider
  elseif ($module=='slider' AND $act=='input'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,999999);
    $nama_gambar = $acak.'-'.$nama_file; 
    
    $link  = $_POST['link'];

    // Apabila tidak ada gambar yang di upload
    if (empty($lokasi_file)){
          echo "<script>window.alert('Gambar belum dipilih');
              window.location=('../../media.php?module=".$module."')</script>";
    }
    // Apabila ada gambar yang di upload
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=".$module."')</script>";
      }
      else{
       
        UploadSlider($nama_gambar);
        
        $input = "INSERT INTO slider(gmb_slider,link) VALUES('$nama_gambar','$link')";
        mysqli_query($koneksi, $input);

        header("location:../../media.php?module=".$module);
      }
    }
  }

  // Update slider
  elseif ($module=='slider' AND $act=='update'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,999999);
    $nama_gambar = $acak.'-'.$nama_file; 
    
    $id    = $_POST['id'];    
    $link  = $_POST['link'];

    // Apabila gambar tidak diganti
    if (empty($lokasi_file)){
      $update = "UPDATE slider SET link      = '$link'
                             WHERE id_slider = '$id'";
      mysqli_query($koneksi, $update);
      
      header("location:../../media.php?module=".$module);
    }
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=".$module."')</script>";
      }
      else{
        
        UploadSlider($nama_gambar);

        $update = "UPDATE slider SET gmb_slider  = '$nama_gambar',
                                     link        = '$link' 
                               WHERE id_slider   = '$id'";
        mysqli_query($koneksi, $update);
      
        header("location:../../media.php?module=".$module);
      }
    }
  }
}
?>
