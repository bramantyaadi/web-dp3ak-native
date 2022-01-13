<?php
  include "config/koneksi.php";
 
 
  // Input ppid
  if (isset($_POST['input'])){
    
    $sql = mysqli_query($koneksi, "INSERT INTO ppid (nama_pemohon, 
                                           no_ktp_1, 
                                           alamat_1, 
                                           no_tlp_1, 
                                           email_1, 
                                           y_d_informasi, 
                                           alasan_1, 
                                           nama_pengguna, 
                                           no_ktp_2, 
                                           alamat_2, 
                                           no_tlp_2, 
                                           email_2, 
                                           alasan_2, 
                                           c_m_informasi, 
                                           f_b_informasi, 
                                           c_m_b_informasi, 
                                           created_at,
                                           update_at) 
                                    VALUES ('$_POST[a]', 
                                            '$_POST[b]', 
                                            '$_POST[c]', 
                                            '$_POST[d]', 
                                            '$_POST[e]',
                                            '$_POST[f]',
                                            '$_POST[g]',
                                            '$_POST[h]',
                                            '$_POST[i]',
                                            '$_POST[j]',
                                            '$_POST[k]',
                                            '$_POST[l]',
                                            '$_POST[m]',
                                            '$_POST[n]',
                                            '$_POST[o]',
                                            '$_POST[p]',
                                            '$tgl_sekarang',
                                            '$tgl_sekarang')") or die('Ada kesalahan pada query insert : '.mysqli_error($koneksi));
   if ($sql) {                           
        header('location:media.php?page=ppid&alert=1');
  } else {
    header('location:media.php?page=ppid&alert=2');
  }
}
?>