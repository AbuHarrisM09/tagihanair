<?php
$data_nama_lengkap = $_SESSION["ses_nama"];

?>

<h2>Selamat Datang</h2>
<h3>
	<?php echo $data_nama_lengkap; ?>, Di Aplikasi Peendataan Tagihan Air.</h3>
<hr/>

<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-6">
		<div class="panel panel-back noti-box">
			<span class="icon-box bg-color-green set-icon">
				<i class="fa fa-tags"></i>
			</span>
			<p class="main-text">
				Data Tagihan
			</p>
			<br>
			<hr/>

			<div class="text-box">
				<p class="main-text">
					<?php // menghitung
                    $sql_hitung = "SELECT COUNT(id_tagihan) from tb_tagihan where status='Belum Bayar'";
                    $q_hit= mysqli_query($koneksi, $sql_hitung);
                    while($row = mysqli_fetch_array($q_hit)) {
                        echo  $row[0]." Tagihan Belum Bayar";
                    }
                    ?>
				</p>
				<h5>
					<b>
						<a href="?halaman=tagih_tampil">Selengkapnya</a>
					</b>
				</h5>
			</div>

			<div class="text-box">
				<p class="main-text">
					<?php // menghitung
                    $sql_hitung = "SELECT COUNT(id_tagihan) from tb_tagihan where status='Lunas'";
                    $q_hit= mysqli_query($koneksi, $sql_hitung);
                    while($row = mysqli_fetch_array($q_hit)) {
                        echo  $row[0]." Tagihan Lunas";
                    }
                    ?>
				</p>
				<h5>
					<b>
						<a href="?halaman=lunas_tampil">Selengkapnya</a>
					</b>
				</h5>
			</div>