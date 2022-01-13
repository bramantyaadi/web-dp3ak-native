<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_agenda/aksi_agenda.php";
  function ubah_tgl2($tglnyo){
		$fm=explode('-',$tglnyo);
		$tahun=$fm[0];
		$bulan=$fm[1];
		$tgll=$fm[2];
		
		$sekarang=$tgll."/".$bulan."/".$tahun;
		return $sekarang;
	}
  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : '';  
?>
	<section class="content-header">
		<h1>Agenda</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=agenda&act=tambahagenda"><i class="fa fa-plus"></i>Tambah Agenda</a></li>
        </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
<?php

  switch($act){
    // Tampil Agenda
    default:
?>
              <div class="box">
                <div class="box-body">
                  <table id="dataagenda" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tema Acara</th>
                        <th>Tgl. Acara</th>
                        <th>Tgl. Posting</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					if ($_SESSION['leveluser']=='admin'){
						$query  = "SELECT * FROM agenda ORDER BY id_agenda DESC";
						$tampil = mysqli_query($koneksi, $query);
					}
					else{
						$query  = "SELECT * FROM agenda WHERE username='$_SESSION[namauser]' ORDER BY id_agenda DESC";
						$tampil = mysqli_query($koneksi, $query);
					}
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						$tgl_mulai   = tgl_indo($r['tgl_mulai']);
						$tgl_selesai = tgl_indo($r['tgl_selesai']);
						$tgl_posting = tgl_indo($r['tgl_posting']);
						echo "<tr><td>$no</td>
							<td width=\"350\">$r[tema]</td>";
						if ($tgl_mulai==$tgl_selesai){
							echo "<td>$tgl_mulai</td>";
						} 
						else{
							echo "<td>$tgl_mulai s/d $tgl_selesai</td>";
						}
						echo "<td align=\"center\">$tgl_posting</td>
							<td align=\"center\"><a href=\"?module=agenda&act=editagenda&id=$r[id_agenda]\" title=\"Edit Data\"><i class=\"fa fa-pencil\"></i></a> &nbsp; 
							<a href=\"$aksi?module=agenda&act=hapus&id=$r[id_agenda]\" onclick=\"return confirm('APAKAH ANDA YAKIN AKAN MENGHAPUS AGENDA INI ?')\" title=\"Hapus Data\"><i class=\"fa fa-trash text-red\"></i></a></td>
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
	
	case "tambahagenda":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Agenda</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=agenda&act=input" class="form-horizontal" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="tema" class="col-sm-2 control-label">Tema Acara</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="tema" name="tema" />
							</div>
						</div>
						<div class="form-group">
							<label for="isi_agenda" class="col-sm-2 control-label">Isi Agenda</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="isi_agenda" name="isi_agenda"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="tempat" class="col-sm-2 control-label">Tempat Acara</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="tempat" name="tempat" />
							</div>
						</div>
						<div class="form-group">
							<label for="tgl_mulai" class="col-sm-2 control-label">Tgl. Mulai</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="tgl_mulai" name="tgl_mulai" />
							</div>
						</div>
						<div class="form-group">
							<label for="tgl_selesai" class="col-sm-2 control-label">Tgl. Selesai</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="tgl_selesai" name="tgl_selesai" />
								<small>- Apabila acara hanya sehari, isikan tanggal yang sama dengan Tgl. Mulai.</small>
							</div>
						</div>
						<div class="form-group">
							<label for="jam" class="col-sm-2 control-label">Pukul</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="jam" name="jam" />
							</div>
						</div>
						<div class="form-group">
							<label for="pengirim" class="col-sm-2 control-label">Pengirim</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="pengirim" name="pengirim"/>
							</div>	
					</div><!-- /.box-body -->
					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Simpan</button> <button type="button" onclick="self.history.back()" class="btn">Batal</button>
					</div><!-- /.box-footer -->
				</form>
            </div><!-- /.box -->
<?php
	break;
	
	case "editagenda":
      if ($_SESSION['leveluser']=='admin'){
        $query = "SELECT * FROM agenda WHERE id_agenda='$_GET[id]'";
        $hasil = mysqli_query($koneksi, $query);
      }
      else{
        $query = "SELECT * FROM agenda WHERE id_agenda='$_GET[id]' AND username='$_SESSION[namauser]'";
        $hasil = mysqli_query($koneksi, $query);
      }

      $r = mysqli_fetch_array($hasil);
	  $tgl_mulai   = ubah_tgl2($r['tgl_mulai']);
      $tgl_selesai = ubah_tgl2($r['tgl_selesai']);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Agenda</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=agenda&act=update" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $r['id_agenda']; ?>" />
					<div class="box-body">
						<div class="form-group">
							<label for="tema" class="col-sm-2 control-label">Tema Acara</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="tema" name="tema" value="<?php echo $r['tema']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="isi_agenda" class="col-sm-2 control-label">Isi Agenda</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="isi_agenda" name="isi_agenda"><?php echo $r['isi_agenda']; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="tempat" class="col-sm-2 control-label">Tempat Acara</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="tempat" name="tempat" value="<?php echo $r['tempat']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="tgl_mulai" class="col-sm-2 control-label">Tgl. Mulai</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="tgl_mulai" name="tgl_mulai" value="<?php echo $tgl_mulai; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="tgl_selesai" class="col-sm-2 control-label">Tgl. Selesai</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="tgl_selesai" name="tgl_selesai" value="<?php echo $tgl_selesai; ?>" />
								<small>- Apabila acara hanya sehari, isikan tanggal yang sama dengan Tgl. Mulai.</small>
							</div>
						</div>
						<div class="form-group">
							<label for="jam" class="col-sm-2 control-label">Pukul</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="jam" name="jam" value="<?php echo $r['jam']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="pengirim" class="col-sm-2 control-label">Pengirim</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="pengirim" name="pengirim" value="<?php echo $r['pengirim']; ?>"/>
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
		</div><!-- /.row -->
	</section><!-- /.section -->
<?php
}
?>