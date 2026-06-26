<?php
include "inc/koneksi.php";
include "inc/kode.php";
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <b>Tambah Pemakaian</b>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>ID Pemakaian</label>
                        <input class="form-control" type="text" name="id_pakai" value="<?php echo htmlspecialchars($format); ?>" readonly/>
                    </div>

                    <div class="form-group">
                        <label>Pelanggan</label>
                        <select name="id_pelanggan" id="id_pelanggan" class="form-control" required>
                            <option value=""></option>
                            <?php
                            $query = "SELECT * FROM tb_pelanggan WHERE status='Aktif' ORDER BY id_pelanggan";
                            $hasil = $koneksi->query($query);
                            while ($row = $hasil->fetch_assoc()) {
                            ?>
                            <option value="<?php echo htmlspecialchars($row['id_pelanggan']); ?>">
                                <?php echo htmlspecialchars($row['id_pelanggan']); ?>| <?php echo htmlspecialchars($row['nama_pelanggan']); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Bulan</label>
                        <select name="id_bulan" id="id_bulan" class="form-control" required>
                            <option value="">-- Pilih Bulan --</option>
                            <?php
                            $query = "SELECT * FROM tb_bulan ORDER BY id_bulan ASC";
                            $hasil = $koneksi->query($query);
                            while ($row = $hasil->fetch_assoc()) {
                            ?>
                            <option value="<?php echo htmlspecialchars($row['id_bulan']); ?>">
                                <?php echo htmlspecialchars($row['nama_bulan']); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tahun</label>
                        <input class="form-control" name="tahun" placeholder="Masukkan tahun" required/>
                    </div>

                    <div class="form-group">
                        <label>Meteran Bulan Lalu</label>
                        <input type="text" name="awal" id="awal" class="form-control" placeholder="Meteran bulan lalu" readonly=""/>
                    </div>

                    <div class="form-group">
                        <label>Meteran Bulan Ini</label>
                        <input type="text" name="akhir" id="akhir" class="form-control" placeholder="Meteran bulan ini" required/>
                    </div>

                    <div class="form-group mb-0">
                        <label>Pemakaian (Bulan Ini - Bulan lalu)</label>
                        <input type="text" name="total" id="total" class="form-control" placeholder="Pemakaian bulan ini" readonly=""/>
                    </div>

                    <div class="form-group mb-0">
                        <?php 
                        $sql_cek = "SELECT l.tarif FROM tb_layanan l INNER JOIN tb_pelanggan p ON l.id_layanan=p.id_layanan LIMIT 1";
                        $data_cek = $koneksi->query($sql_cek)->fetch_assoc();
                        ?>
                        <input type="hidden" class="form-control" name="tarif" id="tarif" value="<?php echo htmlspecialchars($data_cek['tarif'] ?? 0); ?>" readonly=""/>
                    </div>

                    <div class="form-group mb-0">
                        <input type="hidden" name="harga" id="harga" class="form-control" readonly=""/>
                    </div>

                    <div>
                        <input type="submit" name="Simpan" value="Simpan" class="btn btn-success"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['Simpan'])) {
    // Validate and sanitize inputs
    $id_pakai = $_POST['id_pakai'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_bulan = $_POST['id_bulan'];
    $tahun = intval($_POST['tahun']);
    $awal = floatval($_POST['awal']);
    $akhir = floatval($_POST['akhir']);
    $total = floatval($_POST['total']);
    $harga = floatval($_POST['harga']);
    
    if ($akhir <= $awal) {
        echo "<script>
                Swal.fire({title: 'Error', text: 'Meteran bulan ini harus lebih besar dari meteran bulan lalu', icon: 'error', confirmButtonText: 'OK'}
                ).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?halaman=pakai_tambah';
                    }})</script>";
        exit;
    }
    
    // Use prepared statements for security
    $koneksi->begin_transaction();
    
    try {
        $stmt1 = $koneksi->prepare("INSERT INTO tb_pakai (id_pakai, id_pelanggan, bulan, tahun, awal, akhir, pakai) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param("sssiidd", $id_pakai, $id_pelanggan, $id_bulan, $tahun, $awal, $akhir, $total);
        $stmt1->execute();
        
        $stmt2 = $koneksi->prepare("INSERT INTO tb_tagihan (id_pakai, tagihan) VALUES (?, ?)");
        $stmt2->bind_param("sd", $id_pakai, $harga);
        $stmt2->execute();
        
        $koneksi->commit();
        
        echo "<script>
                Swal.fire({title: 'Simpan Berhasil', text: '', icon: 'success', confirmButtonText: 'OK'}
                ).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?halaman=pakai_tampil';
                    }})</script>";
    } catch (Exception $e) {
        $koneksi->rollback();
        echo "<script>
                Swal.fire({title: 'Simpan Gagal', text: '" . addslashes($e->getMessage()) . "', icon: 'error', confirmButtonText: 'OK'}
                ).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?halaman=pakai_tambah';
                    }})</script>";
    }
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#id_pelanggan').change(function(){
            var id_pelanggan = $(this).val();
            $.ajax({
                url:"super/pakai/proses-ajax.php",
                method:"POST",
                data:{id_pelanggan:id_pelanggan},
                success:function(data){
                    $('#awal').val(data);
                }
            });
        });
    });
</script>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#akhir, #awal").keyup(function() {
            var awal = parseFloat($("#awal").val()) || 0;
            var akhir = parseFloat($("#akhir").val()) || 0;
            var total = akhir - awal;
            $("#total").val(total);

            var tarif = parseFloat($("#tarif").val()) || 0;
            var harga = total * tarif;
            $("#harga").val(harga);
        });
    });
</script>
