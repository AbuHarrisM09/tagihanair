<?php
/**
 * Delete Invoice Handler
 * Removes invoice record from database
 */

if (isset($_GET['kode'])) {
    // Sanitize input
    $id_tagihan = intval($_GET['kode']);
    
    // Use prepared statement to prevent SQL injection
    $stmt = $koneksi->prepare("DELETE FROM tb_tagihan WHERE id_tagihan = ?");
    $stmt->bind_param("i", $id_tagihan);
    
    if ($stmt->execute()) {
        echo "<script>alert('Hapus Berhasil')</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=tagih_tampil'>";
    } else {
        echo "<script>alert('Hapus Gagal: " . addslashes($stmt->error) . "')</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=tagih_tampil'>";
    }
    
    $stmt->close();
}
?>
