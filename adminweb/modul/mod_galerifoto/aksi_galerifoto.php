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
  include "../../../config/fungsi_thumb.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Hapus galeri foto
  if ($module=='galerifoto' AND $act=='hapus'){
    // cari informasi nama file foto yang ada di tabel galeri
    $query = "SELECT gbr_gallery FROM gallery WHERE id_gallery='$_GET[id]'";
    $hapus = mysqli_query($koneksi, $query);
    $r     = mysqli_fetch_array($hapus);
    
    // kalau ada file fotonya
    if ($r['gbr_gallery']!=''){
      $namafile = $r['gbr_gallery'];
      
      // hapus file foto yang berhubungan dengan galeri tersebut
      unlink("../../../img_galeri/$namafile");   
      unlink("../../../img_galeri/kecil_$namafile");   

      // kemudian baru hapus data galeri di database 
      mysqli_query($koneksi, "DELETE FROM gallery WHERE id_gallery='$_GET[id]'");      
    }
    // kalau tidak ada file fotonya
    else{
      mysqli_query($koneksi, "DELETE FROM gallery WHERE id_gallery='$_GET[id]'");
    }
    header("location:../../media.php?module=".$module);
  }


  // Input galeri foto
  elseif ($module=='galerifoto' AND $act=='input'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,99);
    $nama_foto   = $acak.$nama_file; 
  
    $judul_galeri = $_POST['judul_galeri'];
    $galeri_seo   = seo_title($_POST['judul_galeri']);
    $album        = $_POST['album'];
    $keterangan   = $_POST['keterangan'];

    // Apabila tidak ada foto yang di upload
    if (empty($lokasi_file)){
      $input = "INSERT INTO gallery(jdl_gallery, 
                                   gallery_seo,
                                   id_album, 
                                   keterangan) 
                            VALUES('$judul_galeri', 
                                   '$galeri_seo',
                                   '$album',
                                   '$keterangan')";
      mysqli_query($koneksi, $input);

      header("location:../../media.php?module=".$module);
    }
    // Apabila ada foto yang di upload
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=galerifoto')</script>";
      }
      else{
        //$folder = "../../../foto_galeri/"; // folder untuk foto galeri
        //$ukuran = 180;                     // foto diperkecil jadi 180px (thumb)
        //UploadFoto($nama_foto, $folder, $ukuran);
		UploadGallery($nama_foto);
        
        $input = "INSERT INTO gallery(jdl_gallery, 
                                     gallery_seo,
                                     id_album, 
                                     keterangan,
                                     gbr_gallery) 
                              VALUES('$judul_galeri', 
                                     '$galeri_seo',
                                     '$album',
                                     '$keterangan',
                                     '$nama_foto')";
        mysqli_query($koneksi, $input);

        header("location:../../media.php?module=".$module);
      }
    }
  }

  // Update galeri foto
  elseif ($module=='galerifoto' AND $act=='update'){
    $lokasi_file    = $_FILES['fupload']['tmp_name'];
    $tipe_file      = $_FILES['fupload']['type'];
    $nama_file      = $_FILES['fupload']['name'];
    $acak           = rand(1,99);
    $nama_foto      = $acak.$nama_file; 

    $id           = $_POST['id'];
    $judul_galeri = $_POST['judul_galeri'];
    $galeri_seo   = seo_title($_POST['judul_galeri']);
    $album        = $_POST['album'];
    $keterangan   = $_POST['keterangan'];

    // Apabila foto tidak diganti
    if(empty($lokasi_file)){
      $update = "UPDATE gallery SET jdl_gallery = '$judul_galeri',
                                   gallery_seo   = '$galeri_seo', 
                                   id_album     = '$album',
                                   keterangan   = '$keterangan' 
                             WHERE id_gallery    = '$id'";
      mysqli_query($koneksi, $update);
      
      header("location:../../media.php?module=".$module);
    }
    else{
      if($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG'); window.location=('../../media.php?module=galerifoto')</script>";
		
      }
      else{
        //$folder = "../../../foto_galeri/"; // folder untuk foto galeri
        //$ukuran = 180;                     // foto diperkecil jadi 180px (thumb)
        //UploadFoto($nama_foto, $folder, $ukuran);
		UploadGallery($nama_foto);

        $update = "UPDATE gallery SET jdl_gallery = '$judul_galeri',
                                     gallery_seo   = '$galeri_seo', 
                                     id_album     = '$album',
                                     keterangan   = '$keterangan', 
                                     gbr_gallery         = '$nama_foto' 
                               WHERE id_gallery    = '$id'";
        mysqli_query($koneksi, $update);
      
        header("location:../../media.php?module=".$module);
      }
    }
  }
}
?>
