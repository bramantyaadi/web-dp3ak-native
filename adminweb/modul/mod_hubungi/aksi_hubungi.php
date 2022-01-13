<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  include "../../../config/koneksi.php";
  include "../../../config/library.php";
  include "../../../config/fungsi_seo.php";
  include "../../../config/fungsi_thumb.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Hapus halaman statis
  if ($module=='hubungi' AND $act=='hapus'){
    
      mysqli_query($koneksi, "DELETE FROM hubungi WHERE id_hubungi='$_GET[id]'") or die('Ada kesalahan pada query hapus : '.mysqli_error($koneksi));      
    
    header("location:../../media.php?module=".$module);
  }

  
}
?>
