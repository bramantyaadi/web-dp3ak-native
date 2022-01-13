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

  $id             = $_POST['id'];

  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $nama_file      = $_FILES['fupload']['name'];

  // Apabila gambar favicon tidak diganti (atau tidak ada gambar yang di upload)
  if (empty($lokasi_file)){
		header('location:../../media.php?module='.$module.'&r=gagal');
  }
  else{
    // folder untuk gambar favicon ada di root
    $folder = "../../../images/";
    $file_upload = $folder . $nama_file;
    // upload gambar favicon
    move_uploaded_file($_FILES["fupload"]["tmp_name"], $file_upload);

    $edit = "UPDATE identitas SET logo = '$nama_file' WHERE id_identitas = '$id'";
    $update=mysqli_query($koneksi, $edit);
  }
  if($update) 
		header('location:../../media.php?module='.$module.'&r=sukses');
  else 
		header('location:../../media.php?module='.$module.'&r=gagal');
}
?>
