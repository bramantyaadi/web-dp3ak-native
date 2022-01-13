<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  include "../../../config/koneksi.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Hapus polling
  if ($module=='polling' AND $act=='hapus'){
    $hapus = "DELETE FROM poling WHERE id_poling='$_GET[id]'";
    mysqli_query($koneksi, $hapus) or die('Ada kesalahan pada query hapus : '.mysqli_error($koneksi));
    
    header("location:../../media.php?module=".$module);
  }

  // Input polling
  elseif ($module=='polling' AND $act=='input'){
    $pilihan = $_POST['pilihan'];
    $status  = $_POST['status'];
    
    $input = "INSERT INTO poling(pilihan, status) VALUES('$pilihan', '$status')";
    mysqli_query($koneksi, $input) or die('Ada kesalahan pada query insert : '.mysqli_error($koneksi));
    
    header("location:../../media.php?module=".$module);
  }

  // Update polling
  elseif ($module=='polling' AND $act=='update'){
    $id      = $_POST['id'];
    $pilihan = $_POST['pilihan'];
    $status  = $_POST['status'];
    $aktif   = $_POST['aktif'];
    
    $update = "UPDATE poling SET pilihan='$pilihan', status='$status', aktif='$aktif' WHERE id_poling='$id'";
    mysqli_query($koneksi, $update) or die('Ada kesalahan pada query update : '.mysqli_error($koneksi));
    
    header("location:../../media.php?module=".$module);
  }
}
?>
