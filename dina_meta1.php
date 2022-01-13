<?php    
    if (isset($_GET['id'])){
      $sql = mysqli_query($koneksi, "select judul from berita where id_berita='$_GET[id]'");
      $j   = mysqli_fetch_array($sql);
		  echo "$j[judul]";
    }
    else{
      $sql2 = mysqli_query($koneksi, "select meta_deskripsi from identitas LIMIT 1");
      $j2   = mysqli_fetch_array($sql2);
		  echo "$j2[meta_deskripsi]";
    }
?>
