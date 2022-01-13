<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  include "../../../config/koneksi.php";
  include "../../../config/fungsi_seo.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];
  
  // Input kategori
  if ($module=='situsterkait' AND $act=='input'){
    $nama_situs = $_POST['nama_situs'];
    $url  = $_POST['url'];
    
    $input = "INSERT INTO situs(nama_situs, url) VALUES('$nama_situs', '$url')";
    mysqli_query($koneksi, $input);
    
    header("location:../../media.php?module=".$module);
  }

  // Update kategori
  elseif ($module=='situsterkait' AND $act=='update'){
    $id            = $_POST['id'];
    $nama_situs = $_POST['nama_situs'];
    $url = $_POST['url'];
    $aktif         = $_POST['aktif'];

    $update = "UPDATE situs SET nama_situs='$nama_situs', url='$url', aktif='$aktif' WHERE id_situs='$id'";
    mysqli_query($koneksi, $update);
    
    header("location:../../media.php?module=".$module);
  }
}
?>
