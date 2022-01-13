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

  // Hapus sekilasinfo
  if ($module=='sekilasinfo' AND $act=='hapus'){
      mysqli_query($koneksi, "DELETE FROM sekilasinfo WHERE id_sekilas='$_GET[id]'");
	  header("location:../../media.php?module=".$module);
  }

  // Input sekilasinfo
  elseif ($module=='sekilasinfo' AND $act=='input'){
    $info  = $_POST['info'];
    
      $input = "INSERT INTO sekilasinfo(info,
								                        tgl_posting) 
                           VALUES('$info',
                                  '$tgl_sekarang')";
      mysqli_query($koneksi, $input);
    
	  header("location:../../media.php?module=".$module);
  }

  // Update sekilasinfo
  elseif ($module=='sekilasinfo' AND $act=='update'){
    $id          = $_POST['id'];
    $info        = $_POST['info'];
    
      $input = "UPDATE sekilasinfo SET info = '$info' WHERE id_sekilas='$id'";
      mysqli_query($koneksi, $input);
    
	  header("location:../../media.php?module=".$module);
  }
}
?>
