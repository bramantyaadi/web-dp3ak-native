<?php 
				$ambiliden = mysqli_query($koneksi, "SELECT * FROM identitas LIMIT 1");
				$tiden = mysqli_fetch_array($ambiliden);
				?>
 <?php 

 function konversi_tanggal($format, $tanggal="now", $bahasa="id"){
	$en=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Okt","Nov","Dec");
	$id=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	
	return str_replace($en,$$bahasa,date($format,strtotime($tanggal)));
}
function artikelTerkait($id, $koneksi){
	//Batas threshold
	$threshold = 40;
	//Jumlah maksimum artikel terkait
	$maksArtikel = 5;
	// Membaca judul artikel dari ID tertentu (ID artikel acuan)
	// array yang nantinya diisi judul artikel terkait
	$listArtikel = Array();
	$query = "SELECT judul FROM berita WHERE id_berita = '$id'";
	$hasil = mysqli_query($koneksi, $query);
	$data  = mysqli_fetch_array($hasil);
	$judul = $data['judul'];

	// Membaca semua data artikel selain ID artikel acuan
	$query = "SELECT * FROM berita WHERE id_berita <> '$id'";
	$hasil = mysqli_query($koneksi, $query);
	while($data = mysqli_fetch_array($hasil)){
		// Cek similaritas judul artikel acuan dengan judul artikel lainya
		similar_text($judul, $data['judul'], $percent);
		if($percent >= $threshold){
			// Jika prosentase kemiripan judul di atas threshold
			if(count($listArtikel) <= $maksArtikel){
				// jika jumlah artikel belum sampai batas maksimum, tambahkan
				$listArtikel[] = "<a href='baca-berita-".$data['id_berita']."-".$data['judul_seo'].".html' class='list-group-item'><h4 class='list-group-item-heading'>".$data['judul']."</h4></a>";
			}
		}
	}
	if(count($listArtikel)>0){
		echo "<div class='list-group margin-top-0'>";
		for($i=0;$i<=count($listArtikel)-1;$i++){
			echo $listArtikel[$i];
		}
		echo "</div>";
	} 
	else{
		echo "<p><center>Tidak ada artikel terkait</center></p>";
	} 
}?>
<?php
if ($_GET['page'] == '') {
	include "pages/home/view.php";
}

// fungsi untuk pemanggilan file halaman konten
// jika halaman konten yang dipilih home, panggil file view home
if ($_GET['page'] == 'artikel') {
	include "pages/artikel/view.php";
}
if ($_GET['page'] == 'detailartikel') {
	include "pages/artikel/detailartikel.php";
}
// jika halaman konten yang dipilih about, panggil file view about
if ($_GET['page'] == 'halaman') {
	include "pages/halaman/view.php";
}

// jika halaman konten yang dipilih service, panggil file view service
if ($_GET['page'] == 'agenda') {
	include "pages/agenda/view.php";
}
// jika halaman konten yang dipilih portfolio, panggil file view portfolio
if ($_GET['page'] == 'pengumuman') {
	include "pages/pengumuman/view.php";
}
if ($_GET['page'] == 'detailpengumuman') {
	include "pages/pengumuman/detailpengumuman.php";
}
// jika halaman konten yang dipilih contact, panggil file view contact
if ($_GET['page'] == 'galeri') {
	include "pages/galeri/view.php";
}
if ($_GET['page'] == 'detailgaleri') {
	include "pages/galeri/detailgaleri.php";
}
// jika halaman konten yang dipilih contact, panggil file view contact
if ($_GET['page'] == 'download') {
	include "pages/download/view.php";
}
// jika halaman konten yang dipilih contact, panggil file view contact
if ($_GET['page'] == 'polling') {
	include "pages/polling/view.php";
}
if ($_GET['page'] == 'lihatpolling') {
	include "pages/polling/lihatpolling.php";
}
// jika halaman konten yang dipilih contact, panggil file view contact
if ($_GET['page'] == 'kategori') {
	include "pages/kategori/view.php";
}
// jika halaman konten yang dipilih contact, panggil file view contact
if ($_GET['page'] == 'ppid') {
	include "pages/ppid/view.php";
}
if ($_GET['page'] == 'prosesppid') {
	include "pages/ppid/proses_ppid.php";
}
// jika halaman konten yang dipilih contact, panggil file view contact
if ($_GET['page'] == 'situsterkait') {
	include "pages/situsterkait/view.php";
}
if ($_GET['page'] == 'hasilcari') {
	include "pages/cari/view.php";
}
?>
