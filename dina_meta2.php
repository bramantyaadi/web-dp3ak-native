<?php
if (isset($_GET['id'])){
  $sql = mysqli_query($koneksi, "select tag from berita where id_berita='$_GET[id]'");
  $j   = mysqli_fetch_array($sql);
	echo "$j[tag]";
}
else{
      $sql2 = mysqli_query($koneksi, "select meta_keyword from identitas LIMIT 1");
      $j2   = mysqli_fetch_array($sql2);
		  echo "$j2[meta_keyword]";
}
?>
