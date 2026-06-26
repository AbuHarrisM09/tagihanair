<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-info">
            <div class="panel-heading">
                <b>Tagihan Belum Dibayar</b>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID | Nama Pelanggan</th>
                                <th>Bulan - Tahun</th>
                                <th>Pemakaian</th>
                                <th>Tagihan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = "SELECT p.id_pelanggan, p.nama_pelanggan, t.id_tagihan, t.tagihan, t.status,
                                    k.tahun, k.pakai, b.nama_bulan
                                    FROM tb_pelanggan p 
                                    INNER JOIN tb_pakai k ON p.id_pelanggan = k.id_pelanggan
                                    INNER JOIN tb_tagihan t ON k.id_pakai = t.id_pakai
                                    INNER JOIN tb_bulan b ON k.bulan = b.id_bulan 
                                    WHERE t.status = 'Belum Bayar'
                                    ORDER BY tahun ASC, id_bulan ASC";
                            
                            $result = $koneksi->query($sql);
                            
                            while ($data = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($data['id_pelanggan']); ?> - <?php echo htmlspecialchars($data['nama_pelanggan']); ?></td>
                                <td><?php echo htmlspecialchars($data['nama_bulan']); ?> - <?php echo htmlspecialchars($data['tahun']); ?></td>
                                <td><?php echo htmlspecialchars($data['pakai']); ?> M<sup>3</sup></td>
                                <td><?php echo rupiah($data['tagihan']); ?></td>
                                <td>
                                    <a href="?halaman=tagih_bayar&kode=<?php echo urlencode($data['id_tagihan']); ?>" 
                                       title="Bayar Tagihan Ini" 
                                       class="btn btn-primary">
                                        <i class="glyphicon glyphicon-send"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
