<?php
// panggil fungsi validasi xss dan injection
require_once('fungsi_validasi.php');

// definisikan koneksi ke database
//$server = "156.67.215.151";
//$username = "u4581710_dp3ak";
//$password = "LcE,jh0M{mrJ";
//$database = "u4581710_dp3ak";
$server = "192.168.1.25";
$username = "dp3akjat_artux";
$password = "cdp17s1850913";
$database = "dp3akjat_dp3ak";

$base_url = "https://dp3ak.jatimprov.go.id";
$key="SU5ESElAIyE=";

// Koneksi dan memilih database di server
// Create connection
$koneksi = mysqli_connect($server, $username, $password,$database);
// Check connection
if (!$koneksi) {
   die("Connection failed: " . mysqli_connect_error());
}

// buat variabel untuk validasi dari file fungsi_validasi.php
$val = new DP3AKjatimprov;
?>
