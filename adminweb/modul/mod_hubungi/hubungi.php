<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_hubungi/aksi_hubungi.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 
?>
	<section class="content-header">
		<h1>Hubungi Kami</h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
<?php

  switch($act){
    // Tampil Hubungi Kami
    default:
?>
              <div class="box">
                <div class="box-header with-border">
					<i>Untuk menjawab/membalas email, klik pada alamat email yang ada di kolom Email.</i>
				</div>
                <div class="box-body">
                  <table id="datahubungi" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Pengirim</th>
                        <th>Email</th>
                        <th>Subjek</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM hubungi ORDER BY id_hubungi DESC";
					$tampil = mysqli_query($koneksi, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						$tanggal=tgl_indo($r['tanggal']);
						echo "<tr><td class=\"text-center\">$no</td>
								<td>$r[nama_pengirim]</td>
								<td><a href=\"?module=hubungi&act=balasemail&id=$r[id_hubungi]\">$r[email]</a></td>
								<td>$r[subjek]</td>
								<td class=\"text-center\">$tanggal</td>
								<td class=\"text-center\"><a href=\"$aksi?module=hubungi&act=hapus&id=$r[id_hubungi]\" onclick=\"return confirm('APAKAH ANDA YAKIN AKAN MENGHAPUS DATA INI ?')\"><i class=\"fa fa-trash text-red\"></i></a></td>
								</tr>";
						$no++;
					}
					?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
<?php
	break;
	
	case "balasemail":
		$query = "SELECT * FROM hubungi WHERE id_hubungi='$_GET[id]'";
		$hasil = mysqli_query($koneksi, $query);
		$r     = mysqli_fetch_array($hasil);
?>
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Balas Email</h3>
			</div>
			<form class="form-horizontal" method="POST" action="?module=hubungi&act=kirimemail">
				<div class="box-body">
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Kepada</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="email" name="email" value="<?php echo $r['email']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="subjek" class="col-sm-2 control-label">Subjek</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="subjek" name="subjek" value="Re: <?php echo $r['subjek']; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="pesan" class="col-sm-2 control-label">Pesan</label>
						<div class="col-sm-10">
							<textarea class="form-control" id="isi_hubungi" name="pesan"><br><br>    
          -----------------------------------------------------------------------------------------------------------------------------------------------<br><?php echo $r['pesan']; ?></textarea>
						</div>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<button type="submit" class="btn btn-primary">Kirim</button> <button type="button" onclick="self.history.back()" class="btn">Batal</button>
				</div><!-- /.box-footer -->
			</form>
		</div><!-- /.box -->
		
<?php
	break;
	
	case "kirimemail":
      $query = "SELECT nama_pemilik,email FROM identitas LIMIT 1";
      $hasil = mysqli_query($koneksi, $query);
      $r     = mysqli_fetch_array($hasil);
      
      $kepada = $_POST['email']; 
      $subjek = $_POST['subjek'];
      $pesan  = $_POST['pesan'];
       
      $dari  = "from: $r[nama_pemilik] <$r[email]> \r\n";
      $dari .= "Content-type: text/html \r\n"; // isi email support html

      mail($kepada,$subjek,$pesan,$dari);
      
	  echo "<script>alert('Selamat!! Email telah terkirim.'); window.location = '?module=hubungi'</script>";
	break;
  }
?>
            </div><!-- /.col -->
		</div>
	</section>
<?php
}
?>