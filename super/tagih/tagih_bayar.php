<?php
if (isset($_GET['kode'])) {
    $id_tagihan = $_GET['kode'];
    
    // Use prepared statement for security
    $stmt = $koneksi->prepare("SELECT p.id_pelanggan, p.nama_pelanggan, t.id_tagihan, t.tagihan, t.status, 
                                k.tahun, k.pakai, b.nama_bulan
                                FROM tb_pelanggan p 
                                INNER JOIN tb_pakai k ON p.id_pelanggan = k.id_pelanggan
                                INNER JOIN tb_tagihan t ON k.id_pakai = t.id_pakai
                                INNER JOIN tb_bulan b ON k.bulan = b.id_bulan
                                WHERE t.id_tagihan = ?");
    $stmt->bind_param("s", $id_tagihan);
    $stmt->execute();
    $result = $stmt->get_result();
    $data_cek = $result->fetch_assoc();
    $stmt->close();
}

$tanggal = date("Y-m-d");
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <b>Pembayaran tagihan</b>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td>ID | Nama Plg</td>
                                <td width="80%">: <?php echo htmlspecialchars($data_cek['id_pelanggan']); ?> - <?php echo htmlspecialchars($data_cek['nama_pelanggan']); ?></td>
                            </tr>
                            <tr>
                                <td>Bulan | Tahun</td>
                                <td>: <?php echo htmlspecialchars($data_cek['nama_bulan']); ?> - <?php echo htmlspecialchars($data_cek['tahun']); ?></td>
                            </tr>
                            <tr>
                                <td>Pemakaian</td>
                                <td>: <?php echo htmlspecialchars($data_cek['pakai']); ?> Meter</td>
                            </tr>
                            <tr>
                                <td>Tagihan</td>
                                <td>: <?php echo rupiah($data_cek['tagihan']); ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:
                                    <?php if ($data_cek['status'] == 'Belum Bayar') { ?>
                                        <span class="label label-danger">Belum Bayar</span>
                                    <?php } elseif ($data_cek['status'] == 'Lunas') { ?>
                                        <span class="label label-primary">Lunas</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <form method="POST">
                        <?php if ($data_cek['status'] == 'Belum Bayar') { ?>
                            <div class="form-group">
                                <input type='hidden' class="form-control" name="id_tagihan" value="<?php echo htmlspecialchars($data_cek['id_tagihan']); ?>" readonly/>
                            </div>

                            <div class="form-group">
                                <input type='hidden' class="form-control" name="tagih" id="tagih" value="<?php echo htmlspecialchars($data_cek['tagihan']); ?>" readonly/>
                            </div>

                            <div class="form-group">
                                <label>Uang Pembayaran</label>
                                <input type='text' class="form-control" name="bayar" id="bayar" placeholder="Uang pembayaran" required/>
                            </div>

                            <div class="form-group">
                                <label>Uang Kembalian</label>
                                <input type='text' class="form-control" name="kembali" id="kembali" readonly/>
                            </div>

                            <div>
                                <input type="submit" name="Bayar" value="Bayar" class="btn btn-primary"/>
                                <a href="?halaman=tagih_tampil" title="Kembali" class="btn btn-default">Batal</a>
                            </div>
                        <?php } elseif ($data_cek['status'] == 'Lunas') { ?>
                            <div>
                                <a href="?halaman=lunas_tampil" title="Pembayaran Lunas" class="btn btn-default">Tagihan Lunas</a>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['Bayar'])) {
    $id_tagihan = intval($_POST['id_tagihan']);
    $uang_bayar = floatval($_POST['bayar']);
    $tagihan = floatval($_POST['tagih']);
    $kembali = $uang_bayar - $tagihan;
    
    if ($uang_bayar < $tagihan) {
        echo "<script>
                Swal.fire({title: 'Pembayaran Gagal', text: 'Uang pembayaran kurang dari tagihan', icon: 'error', confirmButtonText: 'OK'}
                ).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?halaman=tagih_bayar&kode=" . urlencode($id_tagihan) . "';
                    }})</script>";
        exit;
    }
    
    // Use prepared statements with transaction
    $koneksi->begin_transaction();
    
    try {
        $stmt1 = $koneksi->prepare("INSERT INTO tb_pembayaran (id_tagihan, tgl_bayar, uang_bayar, kembali) VALUES (?, ?, ?, ?)");
        $stmt1->bind_param("isdd", $id_tagihan, $tanggal, $uang_bayar, $kembali);
        $stmt1->execute();
        
        $stmt2 = $koneksi->prepare("UPDATE tb_tagihan SET status='Lunas' WHERE id_tagihan = ?");
        $stmt2->bind_param("i", $id_tagihan);
        $stmt2->execute();
        
        $koneksi->commit();
        
        echo "<script>
                Swal.fire({title: 'Pembayaran Berhasil', text: '', icon: 'success', confirmButtonText: 'OK'}
                ).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?halaman=tagih_bayar&kode=" . urlencode($id_tagihan) . "';
                    }})</script>";
    } catch (Exception $e) {
        $koneksi->rollback();
        echo "<script>
                Swal.fire({title: 'Pembayaran Gagal', text: '" . addslashes($e->getMessage()) . "', icon: 'error', confirmButtonText: 'OK'}
                ).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?halaman=tagih_bayar&kode=" . urlencode($id_tagihan) . "';
                    }})</script>";
    }
}
?>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#tagih, #bayar").keyup(function() {
            var tagih = parseFloat($("#tagih").val()) || 0;
            var bayar = parseFloat($("#bayar").val()) || 0;
            var kembali = bayar - tagih;
            $("#kembali").val(kembali);
        });
    });
</script>
