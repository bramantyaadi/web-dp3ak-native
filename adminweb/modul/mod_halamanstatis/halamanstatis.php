<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_halamanstatis/aksi_halamanstatis.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : '';  
?>
	<section class="content-header">
		<h1>Halaman Statis</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=halamanstatis&act=tambahhalamanstatis"><i class="fa fa-plus"></i>Tambah Halaman Statis</a></li>
        </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
<?php

  switch($act){
    // Tampil Halaman Statis
    default:
?>
              <div class="box">
                <div class="box-body">
                  <table id="datahalamanstatis" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Link</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM halamanstatis ORDER BY id_halaman DESC";
					$tampil = mysqli_query($koneksi, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						$tgl_posting=tgl_indo($r['tanggal']);
						echo "<tr><td>$no</td>
							<td>$r[judul]</td>
							<td>statis-$r[id_halaman]-$r[judul_seo].html</td>
							<td align=\"center\"><a href=\"?module=halamanstatis&act=edithalamanstatis&id=$r[id_halaman]\" title=\"Edit Data\"><i class=\"fa fa-pencil\"></i></a> &nbsp; 
							<a href=\"$aksi?module=halamanstatis&act=hapus&id=$r[id_halaman]\" onclick=\"return confirm('APAKAH ANDA YAKIN AKAN MENGHAPUS HALAMAN INI ?')\" title=\"Hapus Data\"><i class=\"fa fa-trash text-red\"></i></a></td>
							</tr>";
						$no++;
					}
					?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
				<div class="box-footer">
					*) Link akan terisi otomatis, nanti Link tersebut di-isikan pada saat membuat Menu Website untuk Halaman Statis.
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
<?php
	break;
	
	case "tambahhalamanstatis":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Halaman Statis</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=halamanstatis&act=input" class="form-horizontal" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="judul" class="col-sm-2 control-label">Judul</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="judul" name="judul" />
							</div>
						</div>
						<div class="form-group">
							<label for="isi_halaman" class="col-sm-2 control-label">Isi Halaman</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="isi_halamanstatis" name="isi_halaman"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Gambar</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="fupload" name="fupload" />
								<small>- Tipe gambar harus JPG (disarankan lebar gambar 600 px).</small>
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
	
	case "edithalamanstatis":
      $query = "SELECT * FROM halamanstatis WHERE id_halaman='$_GET[id]'";
      $hasil = mysqli_query($koneksi, $query);

      $r = mysqli_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Halaman Statis</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=halamanstatis&act=update" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $r['id_halaman']; ?>" />
					<div class="box-body">
						<div class="form-group">
							<label for="judul" class="col-sm-2 control-label">Judul</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="judul" name="judul" value="<?php echo $r['judul']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="isi_halaman" class="col-sm-2 control-label">Isi Halaman</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="isi_halamanstatis" name="isi_halaman"><?php echo $r['isi_halaman']; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Gambar</label>
							<div class="col-sm-10">
								<?php
								if ($r['gambar']!=''){
									echo "<img src=\"../foto_banner/$r[gambar]\">";  
								}
								else{
									echo "Tidak ada gambar";
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Ganti Gambar</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="fupload" name="fupload" />
								<small>- Apabila gambar tidak diganti, dikosongkan saja.<br />- Tipe gambar harus JPG (disarankan lebar gambar 600 px).</small>
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