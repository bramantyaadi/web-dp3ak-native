<?php
if (isset($_GET['id'])){
    $sql = mysqli_query($koneksi, "SELECT judul FROM berita WHERE id_berita='$_GET[id]'");
    $j   = mysqli_fetch_array($sql);
    if ($j) {
        echo "$j[judul]";
    } else{
      $sql2 = mysqli_query($koneksi, "SELECT nama_website FROM identitas LIMIT 1");
      $j2   = mysqli_fetch_array($sql2);
		  echo "$j2[nama_website]";
  }
}
else{
      $sql2 = mysqli_query($koneksi, "SELECT nama_website FROM identitas LIMIT 1");
      $j2   = mysqli_fetch_array($sql2);
		  echo "$j2[nama_website]";
}
?>
