<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = '../../index.php'</script>";
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
	
	$aksi = "modul/mod_ppid/aksi_ppid.php";
	// mengatasi variabel yang belum di definisikan (notice undefined index)
	$act = isset($_GET['act']) ? $_GET['act'] : ''; 
?>
	
<?php
	switch($act){
		// Tampil Kategori
		default:
?>
<section class="content-header">
		<h1>Data PPID (Pengelola Informasi dan Dokumentasi)</h1>
		<ol class="breadcrumb">
            <li><a class="btn btn-warning btn-sm" href="?module=ppid&act=tambahppid"><i class="fa fa-plus"></i>Tambah ppid</a></li>
        </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
		<div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <table id="datappid" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Pemohon</th>
						<th>Email Pemohon</th>
						<th>No.HP (Mobile Phone)</th>
						<th>Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
					$query  = "SELECT * FROM ppid ORDER BY id_ppid DESC";
					$tampil = mysqli_query($koneksi, $query);
					$no=1;
					while ($r=mysqli_fetch_array($tampil)){  ?>
					    <tr><td class="text-center"><?php echo $no; ?></td>
								<td><?php echo $r['nama_pemohon'];?></td>
								<td><?php echo $r['email_1'];?></td>
								<td><?php echo $r['no_tlp_1'];?></td>
								<td><?php echo tgl_indo($r['created_at']);?></td>
								<td class="text-center"><a href="?module=ppid&act=editppid&id=<?php echo $r['id_ppid'];?>" title="Edit Data"><i class="fa fa-pencil"></i></a></td>
								</tr>
						<?php $no++; ?>
					<?php } ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
				
			  </div><!-- /.box -->
			  </div><!-- /.col -->
		</div>
	</section>
<?php
		break;
		
		case "tambahppid":
?>
	<!-- Main content -->
	<section class="content">
		<div class="row">
		<div class="col-xs-12">
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data PPID</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=ppid&act=input" class="form-horizontal">
					<div class="box-body">
						<div class="form-group">
							<label for="nama_pemohon" class="col-sm-2 control-label">Nama Pemohon</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_pemohon" name="a" required/>
								<p>Sesuai KTP <code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="no_ktp_1" class="col-sm-2 control-label">No.KTP (Kartu Tanda Penduduk) Pemohon</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="no_ktp_1" name="b" required/>
								<p>Sesuai KTP <code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat_1" class="col-sm-2 control-label">Alamat Pemohon Informasi</label>
							<div class="col-sm-6">
							<textarea class="form-control" rows="2" id="alamat_1" name="c" required></textarea>
							<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="no_tlp_1" class="col-sm-2 control-label">No.HP (Mobile Phone)/WA Pemohon</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="no_tlp_1" name="d" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="email_1" class="col-sm-2 control-label">Email Pemohon</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="email_1" name="e" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="y_d_informasi" class="col-sm-2 control-label">Informasi Yang dibutuhkan </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="y_d_informasi" name="f" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="alasan_1" class="col-sm-2 control-label">Alasan Permintaan  </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="alasan_1" name="g" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label for="nama_pengguna" class="col-sm-2 control-label">Nama Pengguna</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_pengguna" name="h" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="no_ktp_2" class="col-sm-2 control-label">No.KTP (Kartu Tanda Penduduk) Pengguna</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="no_ktp_2" name="i" required/>
								<p>Sesuai KTP <code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat_2" class="col-sm-2 control-label">Alamat Pengguna Informasi</label>
							<div class="col-sm-6">
							<textarea class="form-control" rows="2" id="alamat_2" name="j" required></textarea>
							<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="no_tlp_1" class="col-sm-2 control-label">No.HP (Mobile Phone)/WA Pengguna</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="no_tlp_2" name="k" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="email_1" class="col-sm-2 control-label">Email Pengguna</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="email_2" name="l" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="alasan_2" class="col-sm-2 control-label">Alasan Penggunaan Informasi  </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="alasan_2" name="m" required/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="c_m_informasi" class="col-sm-2 control-label">Cara Memperoleh Informasi  </label>
							<div class="col-sm-6">
								<select class="form-control" name="n" required>
									<option value="">-- Pilih --</option>
									<option value="langsung">Langsung</option>
									<option value="website">Website</option>
									<option value="email">Email</option>
									<option value="fax">Fax</option>
									<option value="via_pos">Via Pos</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="f_b_informasi" class="col-sm-2 control-label">Format Bahan Informasi   </label>
							<div class="col-sm-6">
								<select class="form-control" name="o" required>
									<option value="">-- Pilih --</option>
									<option value="tercetak">Tercetak</option>
									<option value="terekam">Terekam</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="c_m_b_informasi" class="col-sm-2 control-label">Cara Memperoleh Informasi  </label>
							<div class="col-sm-6">
								<select class="form-control" name="p" required>
									<option value="">-- Pilih --</option>
									<option value="langsung">Langsung</option>
									<option value="via_pos">Via Pos</option>
									<option value="email">Email</option>
								</select>
							</div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Simpan</button> 
						<button type="button" onclick="self.history.back(-1)" class="btn">Batal</button>
					</div><!-- /.box-footer -->
				</form>
			  </div><!-- /.box -->
			  </div><!-- /.col -->
		</div>
	</section>
<?php
		break;
		
		case "editppid":
			$query = "SELECT * FROM ppid WHERE id_ppid='$_GET[id]'";
			$hasil = mysqli_query($koneksi, $query);
			$r     = mysqli_fetch_array($hasil);
?>
<!-- Main content -->
<section class="content">
		<div class="row">
		<div class="col-xs-12">
			<div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit/View Data PPID</h3>
                </div><!-- /.box-header -->
                <form method="POST" action="<?php echo $aksi; ?>?module=ppid&act=update" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $r['id_ppid']; ?>">
					<div class="box-body">
						<div class="form-group">
							<label for="nama_pemohon" class="col-sm-2 control-label">Nama Pemohon</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_pemohon" name="a" value="<?php echo $r['nama_pemohon']; ?>" />
								<p>Sesuai KTP <code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="no_ktp_1" class="col-sm-2 control-label">No.KTP (Kartu Tanda Penduduk) Pemohon</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="no_ktp_1" name="b" value="<?php echo $r['no_ktp_1']; ?>"/>
								<p>Sesuai KTP <code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat_1" class="col-sm-2 control-label">Alamat Pemohon Informasi</label>
							<div class="col-sm-6">
							<textarea class="form-control" rows="2" id="alamat_1" name="c"><?php echo $r['alamat_1']; ?></textarea>
							<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="no_tlp_1" class="col-sm-2 control-label">No.HP (Mobile Phone)/WA Pemohon</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="no_tlp_1" name="d" value="<?php echo $r['no_tlp_1']; ?>"/>
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="email_1" class="col-sm-2 control-label">Email Pemohon</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="email_1" name="e" value="<?php echo $r['email_1']; ?>"/>
							</div>
						</div>
						<div class="form-group">
							<label for="y_d_informasi" class="col-sm-2 control-label">Informasi Yang dibutuhkan </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="y_d_informasi" name="f" value="<?php echo $r['y_d_informasi']; ?>"/>
							</div>
						</div>
						<div class="form-group">
							<label for="alasan_1" class="col-sm-2 control-label">Alasan Permintaan  </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="alasan_1" name="g" value="<?php echo $r['alasan_1']; ?>"/>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label for="nama_pengguna" class="col-sm-2 control-label">Nama Pengguna</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama_pengguna" name="h" value="<?php echo $r['nama_pengguna']; ?>"/>
							</div>
						</div>
						<div class="form-group">
							<label for="no_ktp_2" class="col-sm-2 control-label">No.KTP (Kartu Tanda Penduduk) Pengguna</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="no_ktp_2" name="i" value="<?php echo $r['no_ktp_2']; ?>"/>
								<p>Sesuai KTP <code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="alamat_2" class="col-sm-2 control-label">Alamat Pengguna Informasi</label>
							<div class="col-sm-6">
							<textarea class="form-control" rows="2" id="alamat_2" name="j"><?php echo $r['alamat_2']; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="no_tlp_1" class="col-sm-2 control-label">No.HP (Mobile Phone)/WA Pengguna</label>
							<div class="col-sm-6">
								<input type="number" class="form-control" id="no_tlp_2" name="k" value="<?php echo $r['no_tlp_2']; ?>">
								<p><code> *)Jangan dikosongkan</code></p>
							</div>
						</div>
						<div class="form-group">
							<label for="email_1" class="col-sm-2 control-label">Email Pengguna</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="email_2" name="l" value="<?php echo $r['email_2']; ?>"/>
							</div>
						</div>
						<div class="form-group">
							<label for="alasan_2" class="col-sm-2 control-label">Alasan Penggunaan Informasi  </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="alasan_2" name="m" value="<?php echo $r['alasan_2']; ?>"/>
							</div>
						</div>
						<div class="form-group">
							<label for="c_m_informasi" class="col-sm-2 control-label">Cara Memperoleh Informasi  </label>
							<div class="col-sm-6">
								<select class="form-control" name="n" required>
									<option value="<?php echo $r['c_m_informasi']; ?>"><?php echo $r['c_m_informasi']; ?></option>
									<option value="">-- PILIH --</option>
									<option value="langsung">Langsung</option>
									<option value="website">Website</option>
									<option value="email">Email</option>
									<option value="fax">Fax</option>
									<option value="via_pos">Via Pos</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="f_b_informasi" class="col-sm-2 control-label">Format Bahan Informasi   </label>
							<div class="col-sm-6">
								<select class="form-control" name="o" required>
									<option value="<?php echo $r['f_b_informasi']; ?>"><?php echo $r['f_b_informasi']; ?></option>
									<option value="">-- Pilih --</option>
									<option value="tercetak">Tercetak</option>
									<option value="terekam">Terekam</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="c_m_b_informasi" class="col-sm-2 control-label">Cara Memperoleh Informasi  </label>
							<div class="col-sm-6">
								<select class="form-control" name="p" required>
									<option value="<?php echo $r['c_m_b_informasi']; ?>"><?php echo $r['c_m_b_informasi']; ?></option>
									<option value="">-- Pilih --</option>
									<option value="langsung">Langsung</option>
									<option value="via_pos">Via Pos</option>
									<option value="email">Email</option>
								</select>
							</div>
						</div>
					</div><!-- /.box-body -->
					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Simpan</button> 
						<button type="button" onclick="self.history.back(-1)" class="btn">Batal</button>
					</div><!-- /.box-footer -->
				</form>
			  </div><!-- /.box -->
			  </div><!-- /.col -->
		</div>
	</section>
<?php			
		break;
	}
?>
          
<?php
}
?>