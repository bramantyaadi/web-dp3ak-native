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
  $nama_pemilik   = $_POST['nama_pemilik'];
  $judul_website  = $_POST['judul_website'];
  $alamat_website = $_POST['alamat_website']; 
  $meta_deskripsi = $_POST['meta_deskripsi'];
  $meta_keyword   = $_POST['meta_keyword'];
  $email          = $_POST['email'];
  $twitter        = $_POST['twitter'];
  $twitter_widget = addslashes($_POST['twitter_widget']);
  $wtemp          = $_POST['wtemp'];
  $facebook       = $_POST['facebook'];

  $fb             = $_POST['fb'];
  $tube           = $_POST['tube'];
  $ig             = $_POST['ig'];
  $telpon         = $_POST['telpon'];
  $alamat         = $_POST['alamat'];
  
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $nama_file      = $_FILES['fupload']['name'];

  // Apabila gambar favicon tidak diganti (atau tidak ada gambar yang di upload)
  if (empty($lokasi_file)){
    $edit = "UPDATE identitas SET nama_pemilik   = '$nama_pemilik',
                                  nama_website  = '$judul_website',
                                  alamat_website = '$alamat_website',
                                  meta_deskripsi = '$meta_deskripsi',
                                  meta_keyword   = '$meta_keyword',
                                  email          = '$email',
                                  facebook       = '$facebook',
                                  twitter        = '$twitter',
                                  fb             = '$fb',
                                  tube           = '$tube',
                                  ig             = '$ig',
                                  twitter_widget = '$twitter_widget',
                                  wtemp        = '$wtemp',
                                  telpon        = '$telpon',
                                  alamat        = '$alamat'
                            WHERE id_identitas   = '$id'";
    $update=mysqli_query($koneksi, $edit);
  }
  else{
    // folder untuk gambar favicon ada di root
    $folder = "../../../";
    $file_upload = $folder . $nama_file;
    // upload gambar favicon
    move_uploaded_file($_FILES["fupload"]["tmp_name"], $file_upload);

    $edit = "UPDATE identitas SET nama_pemilik   = '$nama_pemilik',
                                  nama_website  = '$judul_website',
                                  alamat_website = '$alamat_website',
                                  meta_deskripsi = '$meta_deskripsi',
                                  meta_keyword   = '$meta_keyword',
                                  email          = '$email',
                                  twitter        = '$twitter',
                                  twitter_widget = '$twitter_widget',
                                  wtemp   		 = '$wtemp',
                                  facebook       = '$facebook',
								  favicon		 = '$nama_file'
                            WHERE id_identitas   = '$id'";
    $update=mysqli_query($koneksi, $edit);
  }
  if($update) 
		header('location:../../media.php?module='.$module.'&r=sukses');
	else 
		header('location:../../media.php?module='.$module.'&r=gagal');
}
?>
