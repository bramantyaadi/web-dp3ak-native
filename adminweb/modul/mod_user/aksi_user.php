<?php
session_start();

function anti_injection($data){
  $filter  = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
  return $filter;
}

// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  include "../../../config/koneksi.php";

  $key="SU5ESElAIyE=";

  $kunci=base64_decode($key);

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Input user
  if ($module=='user' AND $act=='input'){
    $username     = $_POST['username'];
    $password     = anti_injection(md5($_POST['password'].$kunci));
    $nama_lengkap = $_POST['nama_lengkap']; 
    $email        = $_POST['email'];
    $no_telp      = $_POST['no_telp'];
    $level      = $_POST['level'];
    $sessid       = session_id();
    
    $input = mysqli_query($koneksi, "INSERT INTO users(username, password, nama_lengkap, email, no_telp, level, id_session) VALUES('$username', '$password', '$nama_lengkap', '$email', '$no_telp', '$level','$sessid')")
    or die('Ada kesalahan pada query insert : '.mysqli_error($koneksi));
    if ($input) {
      header("location:../../media.php?module=".$module."&alert=1");
    } else {
      header("location:../../media.php?module=".$module."&alert=2");
    }
  }

  // Update user
  elseif ($module=='user' AND $act=='update'){
    $id           = $_POST['id'];
    $nama_lengkap = $_POST['nama_lengkap']; 
    $email        = $_POST['email'];
    $blokir       = $_POST['blokir'];
 
    // Apabila password tidak diubah (kosong)
    if (empty($_POST['password'])) {
      $update = "UPDATE users SET nama_lengkap = '$nama_lengkap',
                                         email = '$email',
                                        blokir = '$blokir'   
                              WHERE id_session = '$id'";
      mysqli_query($koneksi, $update);
    }
    // Apabila password diubah
    else{
      $password = md5($_POST['password'].$kunci);
      $update = "UPDATE users SET nama_lengkap = '$nama_lengkap',
                                        email  = '$email',
                                        blokir = '$blokir',
                                      password = '$password'    
                              WHERE id_session = '$id'";
      mysqli_query($koneksi, $update);

    }
    header("location:../../media.php?module=".$module);
  }
}
?>
