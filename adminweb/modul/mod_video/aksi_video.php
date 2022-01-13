<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  include "../../../config/koneksiadmin.php";
  include "../../../config/fungsi_seo.php";  
  include "../../../config/fungsi_thumbnail.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Hapus video
  if ($module=='video' AND $act=='hapus'){
    $query = "SELECT gambar FROM video WHERE id_video='$_GET[id]'";
    $hapus = mysqli_query($konek, $query);
    $r     = mysqli_fetch_array($hapus);
    
    if ($r['gambar']!=''){
      $namafile = $r['gambar'];
      
      // hapus filenya
      unlink("../../../foto_video/$namafile");   
      unlink("../../../foto_video/small_$namafile");   

      // hapus data video di database 
      $query2 = "DELETE FROM video WHERE id_video='$_GET[id]'";
    }
    else{
      $query2 = "DELETE FROM video WHERE id_video='$_GET[id]'";
    }
	mysqli_query($konek, $query2);
    header("location:../../media.php?module=".$module);
  }

  // Input video
  elseif ($module=='video' AND $act=='input'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $nama_file   = $_FILES['fupload']['name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file; 

    $judul_video  = $_POST['judul_video'];
    $video_seo    = seo_title($_POST['judul_video']);
    $deskripsi    = $_POST['deskripsi']; 
    $link_youtube = explode("watch?v=",$_POST['link_youtube']);
    
    // Apabila tidak ada gambar yang di upload
    if (empty($lokasi_file)){
      $input = "INSERT INTO video(judul_video, 
                                  video_seo,
                                  link_youtube, 
                                  deskripsi) 
	                        VALUES('$judul_video',
                                 '$video_seo', 
                                 '$link_youtube[1]', 
                                 '$deskripsi')";
      mysqli_query($konek, $input);
      header("location:../../media.php?module=".$module);
    }
    // Apabila ada gambar yang di upload
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=album')</script>";
      }
      else{
        $folder = "../../../foto_video/"; // folder untuk gambar video
        $ukuran = 180;                    // gambar diperkecil jadi 180px (thumb)
        UploadFoto($nama_gambar, $folder, $ukuran);
        
        $input = "INSERT INTO video(judul_video,
                                    video_seo,  
                                    link_youtube, 
                                    deskripsi,
                                    gambar) 
	                          VALUES('$judul_video',
                                   '$video_seo', 
                                   '$link_youtube[1]', 
                                   '$deskripsi',
                                   '$nama_gambar')";
        mysqli_query($konek, $input);

        header("location:../../media.php?module=".$module);
      }
    }
  }

  // Update video
  elseif ($module=='video' AND $act=='update'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $nama_file   = $_FILES['fupload']['name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file; 

    $id           = $_POST['id'];
    $judul_video  = $_POST['judul_video']; 
    $video_seo    = seo_title($_POST['judul_video']);
    $deskripsi    = $_POST['deskripsi'];
    $link_youtube = explode("watch?v=",$_POST['link_youtube']);

    // Apabila gambar tidak diganti
    if (empty($lokasi_file)){ 
      $update = "UPDATE video SET judul_video  = '$judul_video',
                                  video_seo    = '$video_seo',
                                  link_youtube = '$link_youtube[1]',
                                  deskripsi    = '$deskripsi'   
                            WHERE id_video     = '$id'";
      mysqli_query($konek, $update);
      header("location:../../media.php?module=".$module);
    }
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=video)</script>";
      }
      else{
        $folder = "../../../foto_video/"; // folder untuk gambar video
        $ukuran = 180;                    // gambar diperkecil jadi 180px (thumb)
        UploadFoto($nama_gambar, $folder, $ukuran);

        $update = "UPDATE video SET judul_video  = '$judul_video',
                                    video_seo    = '$video_seo',
                                    link_youtube = '$link_youtube[1]',
                                    deskripsi    = '$deskripsi',   
                                    gambar       = '$nama_gambar' 
                              WHERE id_video     = '$id'";
  
        mysqli_query($konek, $update);
      
        header("location:../../media.php?module=".$module);
      }
    } 
    
  }
}
?>
