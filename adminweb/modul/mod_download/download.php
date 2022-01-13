<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_download/aksi_download.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : '';  
?>
	<section class="content-header">
		<h1>Download</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=download&act=tambahdownload"><i class="fa fa-plus"></i>Tambah Download</a></li>
        </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
<?php

  switch($act){
    // Tampil Download
    default:
?>
              <div class="box">
                <div class="box-body">
                  <table id="datadownload" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Nama File</th>
                        <th>Tgl. Posting</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM download ORDER BY id_download DESC";
					$tampil = mysqli_query($koneksi, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						$tgl_posting=tgl_indo($r['tgl_posting']);
						echo "<tr><td>$no</td>
							<td>$r[judul]</td>
							<td>$r[nama_file]</td>
							<td>$tgl_posting</td>
							<td align=\"center\"><a href=\"?module=download&act=editdownload&id=$r[id_download]\"><i class=\"fa fa-pencil\"></i></a> &nbsp; <a href=\"$aksi?module=download&act=hapus&id=$r[id_download]\" onclick=\"return confirm('APAKAH ANDA YAKIN AKAN MENGHAPUS FILE INI ?')\"><i class=\"fa fa-trash text-red\"></i></a></td>
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
	
	case "tambahdownload":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Download</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=download&act=input" class="form-horizontal" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="judul" class="col-sm-2 control-label">Judul</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="judul" name="judul" />
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">File</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="fupload" name="fupload" />
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
	
	case "editdownload":
      $query = "SELECT * FROM download WHERE id_download='$_GET[id]'";
      $hasil = mysqli_query($koneksi, $query);

      $r = mysqli_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Download</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=download&act=update" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $r['id_download']; ?>" />
					<div class="box-body">
						<div class="form-group">
							<label for="judul" class="col-sm-2 control-label">Judul</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="judul" name="judul" value="<?php echo $r['judul']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="nama_file" class="col-sm-2 control-label">Nama File</label>
							<div class="col-sm-10">
								<?php echo $r['nama_file']; ?>
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Ganti Gambar</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="fupload" name="fupload" />
								<small>- Apabila gambar tidak diganti, dikosongkan saja.</small>
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