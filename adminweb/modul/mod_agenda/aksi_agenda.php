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

  // Hapus agenda
  if ($module=='agenda' AND $act=='hapus'){
    $query = "SELECT id_agenda FROM agenda WHERE id_agenda='$_GET[id]'";
    $hapus = mysqli_query($koneksi, $query);
    $r     = mysqli_fetch_array($hapus);
  
    mysqli_query($koneksi, "DELETE FROM agenda WHERE id_agenda='$_GET[id]'");

    header("location:../../media.php?module=".$module);
  }

  // Input agenda
  elseif ($module=='agenda' AND $act=='input'){
    $tema        = $_POST['tema'];
    $tema_seo    = seo_title($_POST['tema']);
    $isi_agenda  = $_POST['isi_agenda'];
    $tempat      = $_POST['tempat'];
    $tgl_mulai   = ubah_tgl($_POST['tgl_mulai']);
    $tgl_selesai = ubah_tgl($_POST['tgl_selesai']);
    $jam         = $_POST['jam'];
    $pengirim    = $_POST['pengirim'];
    
    $input = "INSERT INTO agenda(tema, 
                                   tema_seo, 
                                   isi_agenda,
                                   tempat, 
                                   tgl_mulai,
                                   tgl_selesai,
                                   tgl_posting,
                                   jam,
                                   pengirim,
                                   username) 
                           VALUES('$tema', 
                                  '$tema_seo', 
                                  '$isi_agenda',
                                  '$tempat',
                                  '$tgl_mulai',
                                  '$tgl_selesai',
                                  '$tgl_sekarang',
                                  '$jam',
                                  '$pengirim',
                                  '$_SESSION[namauser]')";
      mysqli_query($koneksi, $input) or die('Ada kesalahan pada query insert : '.mysqli_error($koneksi));
    
	header("location:../../media.php?module=".$module);
  }

  // Update agenda
  elseif ($module=='agenda' AND $act=='update'){

    $id          = $_POST['id'];
    $tema        = $_POST['tema'];
    $tema_seo    = seo_title($_POST['tema']);
    $isi_agenda  = $_POST['isi_agenda'];
    $tempat      = $_POST['tempat'];
    $tgl_mulai   = ubah_tgl($_POST['tgl_mulai']);
    $tgl_selesai = ubah_tgl($_POST['tgl_selesai']);
    $jam         = $_POST['jam'];
    $pengirim    = $_POST['pengirim'];

    $update = "UPDATE agenda SET tema        = '$tema',
                                   tema_seo    = '$tema_seo',
                                   isi_agenda  = '$isi_agenda',
                                   tempat      = '$tempat',  
                                   tgl_mulai   = '$tgl_mulai',
                                   tgl_selesai = '$tgl_selesai',
                                   jam         = '$jam',  
                                   pengirim    = '$pengirim',
                                   username    = '$_SESSION[namauser]'
                             WHERE id_agenda   = '$id'";
      mysqli_query($koneksi, $update) or die('Ada kesalahan pada query update : '.mysqli_error($koneksi)) ;
      
      header("location:../../media.php?module=".$module);
   
    }
  }

?>
