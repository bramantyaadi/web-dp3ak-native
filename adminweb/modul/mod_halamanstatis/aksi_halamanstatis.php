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
  include "../../../config/fungsi_seo.php";
  include "../../../config/fungsi_thumb.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Hapus halaman statis
  if ($module=='halamanstatis' AND $act=='hapus'){
    $query = "SELECT gambar FROM halamanstatis WHERE id_halaman='$_GET[id]'";
    $hapus = mysqli_query($koneksi, $query);
    $r     = mysqli_fetch_array($hapus);
    
    if ($r['gambar']!=''){
      $namafile = $r['gambar'];
      
      // hapus filenya
      unlink("../../../foto_banner/$namafile");   
      unlink("../../../foto_banner/small_$namafile");   

      // hapus data banner di database 
      mysqli_query($koneksi, "DELETE FROM halamanstatis WHERE id_halaman='$_GET[id]'");      
    }
    else{
      mysqli_query($koneksi, "DELETE FROM halamanstatis WHERE id_halaman='$_GET[id]'");      
    }
    header("location:../../media.php?module=".$module);
  }

  // Input halaman statis
  elseif ($module=='halamanstatis' AND $act=='input'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file; 
    
    $judul       = $_POST['judul'];
    $judul_seo   = seo_title($_POST['judul']);
    $isi_halaman = $_POST['isi_halaman'];

    // Apabila tidak ada gambar yang di upload
    if (empty($lokasi_file)){
      $input = "INSERT INTO halamanstatis(judul, 
                                          judul_seo,
                                          tgl_posting,  
                                          isi_halaman) 
                                  VALUES('$judul', 
                                          '$judul_seo',
                                          '$tgl_sekarang',  
                                          '$isi_halaman')";
      mysqli_query($koneksi, $input);

      header("location:../../media.php?module=".$module);
    }
    // Apabila ada gambar yang di upload
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=halamanstatis')</script>";
      }
      else{
        //$folder = "../../../foto_banner/"; // folder untuk gambar halaman statis
        //$ukuran = 200;                     // gambar diperkecil jadi 200px (thumb)
        //UploadFoto($nama_gambar, $folder, $ukuran);
		    UploadBanner($nama_gambar);
        
        $input = "INSERT INTO halamanstatis(judul, 
                                            judul_seo, 
                                            isi_halaman,
                                            tgl_posting, 
                                            gambar) 
                                    VALUES('$judul', 
                                           '$judul_seo', 
                                           '$isi_halaman',
                                           '$tgl_sekarang',                                           
                                           '$nama_gambar')";
        mysqli_query($koneksi, $input);

        header("location:../../media.php?module=".$module);
      }
    }
  }


  // Update halaman statis
  elseif ($module=='halamanstatis' AND $act=='update'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file;
     
    $id          = $_POST['id'];    
    $judul       = $_POST['judul'];
    $judul_seo   = seo_title($_POST['judul']);
    $isi_halaman = $_POST['isi_halaman'];

    // Apabila gambar tidak diganti
    if (empty($lokasi_file)){
      $update = "UPDATE halamanstatis SET judul       = '$judul',
                                          judul_seo   = '$judul_seo', 
                                          isi_halaman = '$isi_halaman'
                                    WHERE id_halaman  = '$id'";
      mysqli_query($koneksi, $update);
      
      header("location:../../media.php?module=".$module);
    }
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=halamanstatis')</script>";
      }
      else{
        //$folder = "../../../foto_banner/"; // folder untuk gambar halaman statis
        //$ukuran = 200;                    // gambar diperkecil jadi 200px (thumb)
        //UploadFoto($nama_gambar, $folder, $ukuran);
		UploadBanner($nama_gambar);

        $update = "UPDATE halamanstatis SET judul       = '$judul',
                                            judul_seo   = '$judul_seo', 
                                            isi_halaman = '$isi_halaman',
                                            gambar      = '$nama_gambar'
                                      WHERE id_halaman  = '$id'";
        mysqli_query($koneksi, $update);
      
        header("location:../../media.php?module=".$module);
      }
    }
  }
}
?>
