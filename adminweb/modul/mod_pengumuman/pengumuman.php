<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_pengumuman/aksi_pengumuman.php";
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
		<h1>Pengumuman</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=pengumuman&act=tambahpengumuman"><i class="fa fa-plus"></i>Tambah Pengumuman</a></li>
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
                        <th>Judul</th>
                        <th>Tanggal Posting</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					if ($_SESSION['leveluser']=='admin'){
						$query  = "SELECT * FROM pengumuman ORDER BY id_pengumuman DESC";
						$tampil = mysqli_query($koneksi, $query);
					}
					else{
						$query  = "SELECT * FROM pengumuman WHERE username='$_SESSION[namauser]' ORDER BY id_pengumuman DESC";
						$tampil = mysqli_query($koneksi, $query);
					}
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						$tgl_posting = tgl_indo($r['tgl_posting']);
						echo "<tr><td>$no</td>
							<td width=\"350\">$r[judul]</td>";
						echo "<td align=\"center\">$tgl_posting</td>
							<td align=\"center\"><a href=\"?module=pengumuman&act=editpengumuman&id=$r[id_pengumuman]\" title=\"Edit Data\"><i class=\"fa fa-pencil\"></i></a> &nbsp; 
							<a href=\"$aksi?module=pengumuman&act=hapus&id=$r[id_pengumuman]\" onclick=\"return confirm('APAKAH ANDA YAKIN AKAN MENGHAPUS PENGUMUMAN INI ?')\" title=\"Hapus Data\"><i class=\"fa fa-trash text-red\"></i></a></td>
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
	
	case "tambahpengumuman":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Pengumuman</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=pengumuman&act=input" class="form-horizontal" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="tema" class="col-sm-2 control-label">Judul</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="judul" name="judul" />
							</div>
						</div>
						<div class="form-group">
							<label for="isi_agenda" class="col-sm-2 control-label">Isi Pengumuman</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="isi_pengumuman" name="isi_pengumuman"></textarea>
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
	
	case "editpengumuman":
      if ($_SESSION['leveluser']=='admin'){
        $query = "SELECT * FROM pengumuman WHERE id_pengumuman='$_GET[id]'";
        $hasil = mysqli_query($koneksi, $query);
      }
      else{
        $query = "SELECT * FROM pengumuman WHERE id_pengumuman='$_GET[id]' AND username='$_SESSION[namauser]'";
        $hasil = mysqli_query($koneksi, $query);
      }

      $r = mysqli_fetch_array($hasil);

?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Pengumuman</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=pengumuman&act=update" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $r['id_pengumuman']; ?>" />
					<div class="box-body">
						<div class="form-group">
							<label for="tema" class="col-sm-2 control-label">Judul</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="judul" name="judul" value="<?php echo $r['judul']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="isi_agenda" class="col-sm-2 control-label">Isi Pengumuman</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="isi_pengumuman" name="isi_pengumuman"><?php echo $r['isi_pengumuman']; ?></textarea>
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