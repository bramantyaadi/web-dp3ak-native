<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
	$aksi = "modul/mod_polling/aksi_polling.php";

	// mengatasi variabel yang belum di definisikan (notice undefined index)
	$act = isset($_GET['act']) ? $_GET['act'] : ''; 
?>
	<section class="content-header">
		<h1>Polling</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=polling&act=tambahpolling"><i class="fa fa-plus"></i>Tambah Polling</a></li>
        </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
<?php
	switch($act){
		// Tampil Polling
		default:
?>
              <div class="box">
                <div class="box-body">
                  <table id="datapolling" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Pilihan</th>
                        <th>Status</th>
                        <th>Aktif</th>
                        <th>Rating</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM poling ORDER BY id_poling DESC";
					$tampil = mysqli_query($koneksi, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						echo "<tr><td class=\"text-center\">$no</td>
								<td>$r[pilihan]</td>
								<td>$r[status]</td>
								<td class=\"text-center\">$r[aktif]</td>
								<td class=\"text-center\">$r[rating]</td>
								<td class=\"text-center\"><a href=\"?module=polling&act=editpolling&id=$r[id_poling]\" title=\"Edit Data\"><i class=\"fa fa-pencil\"></i></a> &nbsp; <a href=\"$aksi?module=polling&act=hapus&id=$r[id_poling]\" onclick=\"return confirm('APAKAH ANDA YAKIN AKAN MENGHAPUS DATA INI ?')\"><i class=\"fa fa-trash text-red\"></i></a></td>
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
		
		case "tambahpolling":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Polling</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=polling&act=input" class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<label for="pilihan" class="col-sm-2 control-label">Pilihan</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="pilihan" name="pilihan" />
							</div>
						</div>
						<div class="form-group">
							<label for="status" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10">
								<label><input type="radio" class="minimal" id="status" name="status" value="Jawaban" checked /> Jawaban &nbsp; </label>
								<label><input type="radio" class="minimal" id="status" name="status" value="Pertanyaan" /> Pertanyaan </label>
							</div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Simpan</button> <button type="button" onclick="self.history.back()" class="btn">Batal</button>
					</div><!-- /.box-footer -->
				</form>
              </div><!-- /.box -->
<?php
		break;
		
		case "editpolling":
			$query = "SELECT * FROM poling WHERE id_poling='$_GET[id]'";
			$hasil = mysqli_query($koneksi, $query);
			$r     = mysqli_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Polling</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=polling&act=update" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $r['id_poling']; ?>">
					<div class="box-body">
						<div class="form-group">
							<label for="pilihan" class="col-sm-2 control-label">Pilihan</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="pilihan" name="pilihan" value="<?php echo $r['pilihan']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="status" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10">
								<?php if($r['status']=="Jawaban") { ?>
								<label><input type="radio" class="minimal" id="status" name="status" value="Jawaban" checked /> Jawaban &nbsp; </label>
								<label><input type="radio" class="minimal" id="status" name="status" value="Pertanyaan" /> Pertanyaan </label>
								<?php } else { ?>
								<label><input type="radio" class="minimal" id="status" name="status" value="Jawaban" /> Jawaban &nbsp; </label>
								<label><input type="radio" class="minimal" id="status" name="status" value="Pertanyaan" checked /> Pertanyaan </label>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label for="aktif" class="col-sm-2 control-label">Aktif</label>
							<div class="col-sm-6">
								<?php if($r['aktif']=="Y") { ?>
								<label><input type="radio" class="minimal" id="aktif" name="aktif" value="Y" checked> Y &nbsp; </label>
								<label><input type="radio" class="minimal" id="aktif" name="aktif" value="N"> N </label>
								<?php } else { ?>
								<label><input type="radio" class="minimal" id="aktif" name="aktif" value="Y"> Y &nbsp; </label>
								<label><input type="radio" class="minimal" id="aktif" name="aktif" value="N" checked> N </label>
								<?php } ?>
							</div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Update</button> <button type="button" onclick="self.history.back()" class="btn">Batal</button>
					</div><!-- /.box-footer -->
				</form>
              </div><!-- /.box -->
<?php			
		break;
	}
?>
            </div><!-- /.col -->
		</div>
	</section>
<?php
}
?>