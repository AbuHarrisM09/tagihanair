<?php
$data_nama_lengkap = $_SESSION["ses_nama"];
?>

<h2>Selamat Datang</h2>
<h3><?php echo htmlspecialchars($data_nama_lengkap); ?>, Di Aplikasi Pendataan Tagihan Air.</h3>
<hr/>

<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-6">
        <div class="panel panel-back noti-box">
            <span class="icon-box bg-color-green set-icon">
                <i class="fa fa-tags"></i>
            </span>
            <p class="main-text">Data Tagihan</p>
            <br>
            <hr/>

            <div class="text-box">
                <p class="main-text">
                    <?php
                    $sql_hitung = "SELECT COUNT(id_tagihan) as count FROM tb_tagihan WHERE status='Belum Bayar'";
                    $q_hit = $koneksi->query($sql_hitung);
                    $row = $q_hit->fetch_assoc();
                    echo $row['count'] . " Tagihan Belum Bayar";
                    ?>
                </p>
                <h5>
                    <b><a href="?halaman=tagih_tampil">Selengkapnya</a></b>
                </h5>
            </div>

            <div class="text-box">
                <p class="main-text">
                    <?php
                    $sql_hitung = "SELECT COUNT(id_tagihan) as count FROM tb_tagihan WHERE status='Lunas'";
                    $q_hit = $koneksi->query($sql_hitung);
                    $row = $q_hit->fetch_assoc();
                    echo $row['count'] . " Tagihan Lunas";
                    ?>
                </p>
                <h5>
                    <b><a href="?halaman=lunas_tampil">Selengkapnya</a></b>
                </h5>
            </div>
        </div>
    </div>
</div>
