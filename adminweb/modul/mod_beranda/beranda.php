<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
		$tgl=date("Y-m-d");
		$tgl_skrg = date("Ymd"); // dapatkan tanggal sekarang saat online
		//$tgl_skrg = date("20140117"); // untuk simulasi saja sesuai dengan di database  17 Januari 2014
			
		// dapatkan 6 hari sblm tgl sekarang 
		$seminggu = strtotime("-1 week +1 day",strtotime($tgl_skrg));
		$hasilnya = date("Y-m-d", $seminggu);
		$tanggal = "";
		$pengunjung = "";
		$hits = "";
		$tabelgrafik = "";
		for($i=0; $i<=6; $i++) {
			$urutan_tgl   = strtotime("+$i day",strtotime($hasilnya));
			$hasil_urutan = date("d-M-Y", $urutan_tgl);
			$tgl_pengujung   = strtotime("+$i day",strtotime($hasilnya));
			$hasil_pengujung = date("Y-m-d", $tgl_pengujung);
			$query_pengujung = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM statistik WHERE tanggal='$hasil_pengujung' GROUP BY ip"));
			$tgl_hits   = strtotime("+$i day",strtotime($hasilnya));
			$hasil_hits = date("Y-m-d", $tgl_hits);
			$query_hits = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(hits) as hitstoday FROM statistik WHERE tanggal='$hasil_hits' GROUP BY tanggal"));
			$hits_today = $query_hits['hitstoday'];
			
			if ($hits_today==""){ 
				$hits_today="0"; 
			}
			
			if($i==6) {
				$tanggal .= "'$hasil_urutan'";
				$pengunjung .= "$query_pengujung";
				$hits .= "$hits_today";
			} else {
				$tanggal .= "'$hasil_urutan',";
				$pengunjung .= "$query_pengujung,";
				$hits .= "$hits_today,";
			}
			$tabelgrafik .= "<tr><th>$hasil_urutan</th><td align=\"center\">$query_pengujung</td><td align=\"center\">$hits_today</td></tr>";
		}
		?>
	<section class="content-header">
		<h1>Selamat Datang di Halaman Administrator</h1>
	</section>
	
	<!-- Main content -->
	<section class="content">
		<p>Hai, <b><?php echo $_SESSION['namalengkap']; ?></b> Anda login saat ini pada tanggal <b><?php echo tgl_indo($tgl); ?></b>. </p> 
		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Statistik Pengunjung Website (Seminggu Terakhir)</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-8">
						<div class="chart">
							<!-- Sales Chart Canvas -->
							<canvas id="salesChart" style="height: 250x;"></canvas>
						</div><!-- /.chart-responsive -->
					</div>	<!-- /.col-md-8 -->
					<div class="col-md-4">
						<table class="table table-striped table-bordered">
							<tr><td></td><th>Pengunjung</th><th>Hits</th></tr>
							<?php echo $tabelgrafik; ?>
						</table>
					</div>	<!-- /.col-md-4 -->
				</div> <!-- /.row -->
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</section><!-- /.content -->
<?php
}
?>