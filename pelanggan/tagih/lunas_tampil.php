<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-info">
            <div class="panel-heading">
                <b>Tagihan Lunas</b>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Bulan - Tahun</th>
                                <th>Meter Awal</th>
                                <th>Meter Akhir</th>
                                <th>Pemakaian</th>
                                <th>Tagihan</th>
                                <th>Tgl. Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $id_pelanggan = $koneksi->real_escape_string($data_rek);
                            
                            $sql = "SELECT p.id_pelanggan, t.id_tagihan, t.tagihan, t.status, bl.nama_bulan,
                                    k.tahun, k.awal, k.akhir, k.pakai, b.tgl_bayar
                                    FROM tb_pelanggan p 
                                    INNER JOIN tb_pakai k ON p.id_pelanggan = k.id_pelanggan
                                    INNER JOIN tb_tagihan t ON k.id_pakai = t.id_pakai
                                    INNER JOIN tb_pembayaran b ON t.id_tagihan = b.id_tagihan
                                    INNER JOIN tb_bulan bl ON k.bulan = bl.id_bulan
                                    WHERE t.status = 'Lunas' AND p.id_pelanggan = '$id_pelanggan'
                                    ORDER BY tahun DESC, id_bulan DESC";
                            
                            $result = $koneksi->query($sql);
                            
                            while ($data = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($data['nama_bulan']); ?> - <?php echo htmlspecialchars($data['tahun']); ?></td>
                                <td><?php echo htmlspecialchars($data['awal']); ?> M<sup>3</sup></td>
                                <td><?php echo htmlspecialchars($data['akhir']); ?> M<sup>3</sup></td>
                                <td><?php echo htmlspecialchars($data['pakai']); ?> M<sup>3</sup></td>
                                <td><?php echo rupiah($data['tagihan']); ?></td>
                                <td><?php echo date("d - M - Y", strtotime($data['tgl_bayar'])); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
