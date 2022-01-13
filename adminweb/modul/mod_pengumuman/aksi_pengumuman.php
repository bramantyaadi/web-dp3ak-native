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

  // Hapus pengumuman
  if ($module=='pengumuman' AND $act=='hapus'){
      mysqli_query($koneksi, "DELETE FROM pengumuman WHERE id_pengumuman='$_GET[id]'");
	  header("location:../../media.php?module=".$module);
  }

  // Input pengumuman
  elseif ($module=='pengumuman' AND $act=='input'){
    $judul        = $_POST['judul'];
    $judul_seo    = seo_title($_POST['judul']);
    $isi_pengumuman  = $_POST['isi_pengumuman'];
    
      $input = "INSERT INTO pengumuman(judul, 
                                   judul_seo, 
                                   isi_pengumuman,
								   tgl_posting,
                                   username) 
                           VALUES('$judul', 
                                  '$judul_seo', 
                                  '$isi_pengumuman',
								  '$tgl_sekarang',
                                  '$_SESSION[namauser]')";
      mysqli_query($koneksi, $input) or die('Ada kesalahan pada query insert : '.mysqli_error($koneksi));
    
	  header("location:../../media.php?module=".$module);
  }

  // Update pengumuman
  elseif ($module=='pengumuman' AND $act=='update'){
    $id          = $_POST['id'];
    $judul        = $_POST['judul'];
    $judul_seo    = seo_title($_POST['judul']);
    $isi_pengumuman  = $_POST['isi_pengumuman'];
    
      $input = "UPDATE pengumuman SET judul = '$judul', 
                                      judul_seo = '$judul_seo', 
                                      isi_pengumuman = '$isi_pengumuman',
                                      username = '$_SESSION[namauser]' WHERE id_pengumuman='$id'";
      mysqli_query($koneksi, $input) or die('Ada kesalahan pada query insert : '.mysqli_error($koneksi));
    
	  header("location:../../media.php?module=".$module);
  }
}
?>
