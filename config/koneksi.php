<?php
// panggil fungsi validasi xss dan injection
require_once('fungsi_validasi.php');

// definisikan koneksi ke database
// $server = "192.168.1.25";
$server = "localhost";
$username = "root";
$password = "";
$database = "dp3akjat_dp3ak";

// $base_url = "https://dp3ak.jatimprov.go.id";
$base_url = "https://localhost";

$key="SU5ESElAIyE=";
// Koneksi dan memilih database di server
$koneksi = mysqli_connect($server,$username,$password) or die(mysqli_error($koneksi));
mysqli_select_db($koneksi,$database) or die("Database tidak bisa dibuka");

// buat variabel untuk validasi dari file fungsi_validasi.php
$val = new DP3AKjatimprov;
?>
