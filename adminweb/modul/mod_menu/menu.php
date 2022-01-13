<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_menu/aksi_menu.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : '';  
?>
	<section class="content-header">
		<h1>Menu Website</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=menu&act=tambahmenu"><i class="fa fa-plus"></i>Tambah Menu</a></li>
        </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
<?php

	switch($act){  
		// Tampil Menu 
		default:
?>
              <div class="box">
                <div class="box-body">
                  <table id="datamenu" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Menu</th>
                        <th>Link</th>
                        <th>Level Menu</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM menu";
					$tampil = mysqli_query($koneksi, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  
						echo "<tr><td>$no</td>
							<td>$r[nama_menu]</td><td>$r[link]</td>";
						$query2 = "SELECT * FROM menu WHERE id_menu=$r[id_parent]";
						$hasil  = mysqli_query($koneksi, $query2);
						$jumlah = mysqli_num_rows($hasil); 	
						if ($jumlah > 0){
							while($s=mysqli_fetch_array($hasil)){
								echo "<td>$s[nama_menu]</td>"; 
							}
						}
						else{
							echo "<td>Menu Utama</td>";
						}
						echo "<td align=\"center\">$r[aktif]</td>
						<td align=\"center\"><a href=\"?module=menu&act=editmenu&id=$r[id_menu]\" title=\"Edit Data\"><i class=\"fa fa-pencil\"></i></a> &nbsp; 
						<a href=\"$aksi?module=menu&act=hapus&id=$r[id_menu]\" onclick=\"return confirm('APAKAH ANDA YAKIN AKAN MENGHAPUS MENU INI ?')\" title=\"Hapus Data\"><i class=\"fa fa-trash text-red\"></i></a></td></tr>";
						$no++;
					}
					?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
<?php
		break;
		
		case "tambahmenu":
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Menu</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=menu&act=input" class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<label for="nama_menu" class="col-sm-2 control-label">Nama Menu</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_menu" name="nama_menu" />
							</div>
						</div>
						<div class="form-group">
							<label for="link" class="col-sm-2 control-label">Link</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="link" name="link" />
							</div>
						</div>
						<div class="form-group">
							<label for="id_parent" class="col-sm-2 control-label">Level Menu</label>
							<div class="col-sm-6">
								<select class="form-control select2" id="id_parent" name="id_parent">
									<option value="0" selected>Menu Utama</option>
									<?php
									$query  = "SELECT * FROM menu WHERE id_parent=0 ORDER BY id_menu";
									$tampil = mysqli_query($koneksi, $query);
									while($r=mysqli_fetch_array($tampil)){
										echo "<option value=\"$r[id_menu]\">$r[nama_menu]</option>";
									}
									?>
								</select>
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
		
		case "editmenu":
			$query = "SELECT * FROM menu WHERE id_menu='$_GET[id]'";
			$hasil = mysqli_query($koneksi, $query);
			$r     = mysqlI_fetch_array($hasil);
?>
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Menu</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=menu&act=update" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $r['id_menu']; ?>">
					<div class="box-body">
						<div class="form-group">
							<label for="nama_menu" class="col-sm-2 control-label">Nama Menu</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_menu" name="nama_menu" value="<?php echo $r['nama_menu']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="link" class="col-sm-2 control-label">Link</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="link" name="link" value="<?php echo $r['link']; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label for="id_parent" class="col-sm-2 control-label">Level Menu</label>
							<div class="col-sm-6">
								<select class="form-control select2" id="id_parent" name="id_parent">
									<?php if ($r['parent_id']==0){ ?>
										<option value="0" selected>Menu Utama</option>
									<?php } else { ?>
										<option value="0">Menu Utama</option>
									<?php
									}
									$query2  = "SELECT * FROM menu WHERE id_parent=0 ORDER BY id_menu";
									$tampil2 = mysqli_query($koneksi, $query2);
									while($w=mysqli_fetch_array($tampil2)){
										if ($r['id_parent']==$w['id_menu']){
											echo "<option value=\"$w[id_menu]\" selected>$w[nama_menu]</option>";
										} else {
											if ($w['id_menu']==$r['id_menu']){
												echo "<option value=\"0\">Tanpa Level</option>";
											}
											else{
												echo "<option value=\"$w[id_menu]\">$w[nama_menu]</option>";
											}
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="aktif" class="col-sm-2 control-label">Aktif</label>
							<div class="col-sm-6">
								<?php
								if($r['aktif']=="Y") {
								?>
									<label><input type="radio" class="minimal" id="aktif" name="aktif" value="Y" checked> Y &nbsp; </label>
									<label><input type="radio" class="minimal" id="aktif" name="aktif" value="N"> N </label>
								<?php
								}
								elseif($r['aktif']=="N") {
								?>
									<label><input type="radio" class="minimal" id="aktif" name="aktif" value="Y"> Y &nbsp; </label>
									<label><input type="radio" class="minimal" id="aktif" name="aktif" value="N" checked> N </label>
								<?php
								}
								?>
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