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
  include "../../../config/library.php";
	function ubah_tgl($tglnyo){
		$fm=explode('/',$tglnyo);
		$tahun=$fm[2];
		$bulan=$fm[1];
		$tgll=$fm[0];
		
		$sekarang=$tahun."-".$bulan."-".$tgll;
		return $sekarang;
	}
  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Hapus listslider
  if ($module=='listslider' AND $act=='hapus'){
      mysqli_query($koneksi, "DELETE FROM listslider WHERE id_list='$_GET[id]'");
	  header("location:../../media.php?module=".$module);
  }

  // Input listslider
  elseif ($module=='listslider' AND $act=='input'){
    $nama_menu    = $_POST['nama_menu'];
    $keterangan   = $_POST['keterangan'];
    $link  		  = $_POST['link_menu'];
    
      $input = "INSERT INTO listslider(nama_menu, 
                                   keterangan, 
                                   link) 
                           VALUES('$nama_menu', 
                                  '$keterangan', 
                                  '$link')";
      mysqli_query($koneksi, $input);
    
	  header("location:../../media.php?module=".$module);
  }

  // Update listslider
  elseif ($module=='listslider' AND $act=='update'){
    $id          = $_POST['id'];
    $nama_menu    = $_POST['nama_menu'];
    $keterangan   = $_POST['keterangan'];
    $link  		  = $_POST['link_menu'];
    
      $input = "UPDATE listslider SET nama_menu = '$nama_menu', 
                                      keterangan = '$keterangan', 
                                      link = '$link' WHERE id_list='$id'";
      mysqli_query($koneksi, $input);
    
	  header("location:../../media.php?module=".$module);
  }
}
?>
