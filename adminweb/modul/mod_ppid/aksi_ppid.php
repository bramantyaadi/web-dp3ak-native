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
  include "../../../config/fungsi_indotgl.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];
  
  // Input ppid
  if ($module=='ppid' AND $act=='input'){
    
    $input = "INSERT INTO ppid (nama_pemohon, 
                                no_ktp_1, 
                                alamat_1, 
                                no_tlp_1, 
                                email_1,
                                y_d_informasi,
                                alasan_1,
                                nama_pengguna,
                                no_ktp_2,
                                alamat_2,
                                no_tlp_2,
                                email_2,
                                alasan_2,
                                c_m_informasi,
                                f_b_informasi,
                                c_m_b_informasi,
                                created_at) 
                        VALUES('$_POST[a]', 
                               '$_POST[b]', 
                               '$_POST[c]', 
                               '$_POST[d]', 
                               '$_POST[e]',
                               '$_POST[f]',
                               '$_POST[g]',
                               '$_POST[h]',
                               '$_POST[i]',
                               '$_POST[j]',
                               '$_POST[k]',
                               '$_POST[l]',
                               '$_POST[m]',
                               '$_POST[n]',
                               '$_POST[o]',
                               '$_POST[p]',
                               '$tgl_sekarang')";
        mysqli_query($koneksi, $input) or die('Ada kesalahan pada query insert : '.mysqli_error($koneksi));
    
    header("location:../../media.php?module=".$module);
  }

  // Update kategori
  elseif ($module=='ppid' AND $act=='update'){
    $id = $_POST['id'];
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $d = $_POST['d'];
    $e = $_POST['e'];
    $f = $_POST['f'];
    $g = $_POST['g'];
    $h = $_POST['h'];
    $i = $_POST['i'];
    $j = $_POST['j'];
    $k = $_POST['k'];
    $l = $_POST['l'];
    $m = $_POST['m'];
    $n = $_POST['n'];
    $o = $_POST['o'];
    $p = $_POST['p'];

    $update = "UPDATE ppid SET nama_pemohon='$a', no_ktp_1='$b', 
    alamat_1='$c', no_tlp_1='$d', email_1='$e', y_d_informasi='$f', alasan_1='$g',
    nama_pengguna='$h', no_ktp_2='$i', alamat_2='$j', no_tlp_2='$k', email_2='$l',
    alasan_2='$m', c_m_informasi='$n', f_b_informasi='$o', c_m_b_informasi='$p' WHERE id_ppid='$id'";
    mysqli_query($koneksi, $update) or die('Ada kesalahan pada query update : '.mysqli_error($koneksi));
    
    header("location:../../media.php?module=".$module);
  }
}
?>
