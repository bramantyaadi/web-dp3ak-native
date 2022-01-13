<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  // fungsi untuk check box Tag (Berita Terkait) di form input dan edit berita 
  function GetCheckBox($table, $key, $Label, $Nilai='') {
    include "../config/koneksi.php";
    $s = "SELECT * FROM $table ORDER BY $Label";
    $u = mysqli_query($koneksi, $s);
    $_arrNilai = explode(',', $Nilai);
    $str = '';
    while ($t = mysqli_fetch_array($u)) {
      $_ck = (array_search($t[$key], $_arrNilai) === false)? '' : 'checked';
      $str .= "<input type=\"checkbox\" class=\"minimal\" name='".$key."[]' value=\"$t[$key]\" $_ck> $t[$Label] &nbsp; ";
    }
    return $str;
  }

  $aksi = "modul/mod_berita/aksi_berita.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : '';  
?>
	<section class="content-header">
		<h1>Berita</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=berita&act=tambahberita"><i class="fa fa-plus"></i>Tambah Berita</a></li>
        </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
<?php

  switch($act){
    // Tampil Berita
    default:
?>
              <div class="box">
                <div class="box-body">
                  <table id="databerita" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tgl. Posting</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					if ($_SESSION['leveluser']=='admin'){
						$query  = "SELECT * FROM berita,kategori WHERE berita.id_kategori=kategori.id_kategori ORDER BY id_berita DESC";
						$tampil = mysqli_query($koneksi, $query);
					}
					else{
						$query  = "SELECT * FROM berita,kategori WHERE berita.id_kategori=kategori.id_kategori AND username='$_SESSION[namauser]' ORDER BY id_berita DESC";
						$tampil = mysqli_query($koneksi, $query);
					}
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						$tgl_posting=tgl_indo($r['tanggal']);
						echo "<tr><td>$no</td>
							<td width=\"350\">$r[judul]</td>
							<td>$r[nama_kategori]</td>
							<td>$tgl_posting</td>
							<td align=\"center\"><a href=\"?module=berita&act=editberita&id=$r[id_berita]\" title=\"Edit Berita\"><i class=\"fa fa-pencil\"></i></a> &nbsp; 
							<a href=\"$aksi?module=berita&act=hapus&id=$r[id_berita]\" onclick=\"return confirm('APAKAH ANDA YAKIN AKAN MENGHAPUS BERITA INI ?')\" title=\"Hapus Berita\"><i class=\"fa fa-trash text-red\"></i></a></td>
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
	
	case "tambahberita":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Berita</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=berita&act=input" class="form-horizontal" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="judul" class="col-sm-2 control-label">Judul</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="judul" name="judul" />
							</div>
						</div>
						<div class="form-group">
							<label for="kategori" class="col-sm-2 control-label">Kategori</label>
							<div class="col-sm-10">
								<select class="form-control select2" id="kategori" name="kategori" required>
									<option value="0" selected>- Pilih Kategori -</option>
									<?php
									$query  = "SELECT * FROM kategori ORDER BY nama_kategori";
									$tampil = mysqli_query($koneksi, $query);
									while($r=mysqli_fetch_array($tampil)){
										echo "<option value=\"$r[id_kategori]\">$r[nama_kategori]</option>";
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="isi_berita" class="col-sm-2 control-label">Isi Berita</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="isi_berita" name="isi_berita"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Gambar</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="fupload" name="fupload" />
								<small>- Tipe gambar harus JPG (disarankan lebar gambar 350 px).</small>
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
	
	case "editberita":
      if ($_SESSION['leveluser']=='admin'){
        $query = "SELECT * FROM berita WHERE id_berita='$_GET[id]'";
        $hasil = mysqli_query($koneksi, $query);
      }
      else{
        $query = "SELECT * FROM berita WHERE id_berita='$_GET[id]' AND username='$_SESSION[namauser]'";
        $hasil = mysqli_query($koneksi, $query);
      }

      $r = mysqli_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Berita</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=berita&act=update" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $r['id_berita']; ?>" />
					<div class="box-body">
						<div class="form-group">
							<label for="judul" class="col-sm-2 control-label">Judul</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="judul" name="judul" value="<?php echo $r['judul']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="kategori" class="col-sm-2 control-label">Kategori</label>
							<div class="col-sm-10">
								<select class="form-control select2" id="kategori" name="kategori" required>
									<?php if ($r['id_kategori']==0){ ?>
										<option value="0" selected>- Pilih Kategori -</option>
									<?php 
									}
									$query2  = "SELECT * FROM kategori ORDER BY nama_kategori";
									$tampil2 = mysqli_query($koneksi, $query2);
									while($w=mysqli_fetch_array($tampil2)){
										if ($r['id_kategori']==$w['id_kategori']){
											echo "<option value=\"$w[id_kategori]\" selected>$w[nama_kategori]</option>";
										}
										else{
											echo "<option value=\"$w[id_kategori]\">$w[nama_kategori]</option>";
										}
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="isi_berita" class="col-sm-2 control-label">Isi Berita</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="isi_berita" name="isi_berita"><?php echo $r['isi_berita']; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Gambar</label>
							<div class="col-sm-10">
								<?php
								if ($r['gambar']!=''){
									echo "<img src=\"../foto_berita/small_$r[gambar]\">";  
								}
								else{
									echo "Berita tidak ada gambarnya";
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<label for="fupload" class="col-sm-2 control-label">Ganti Gambar</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="fupload" name="fupload" />
								<small>- Apabila gambar tidak diganti, dikosongkan saja.<br />- Tipe gambar harus JPG (disarankan lebar gambar 350 px).</small>
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