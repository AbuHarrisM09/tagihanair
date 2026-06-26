<?php
/**
 * Delete Usage Record Handler
 * Removes usage record and associated billing data
 */

if (isset($_GET['kode'])) {
    // Sanitize input
    $id_pakai = $_GET['kode'];
    
    // Use prepared statement to prevent SQL injection
    $stmt = $koneksi->prepare("DELETE FROM tb_pakai WHERE id_pakai = ?");
    $stmt->bind_param("s", $id_pakai);
    
    if ($stmt->execute()) {
        echo "<script>alert('Hapus Berhasil')</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=pakai_tampil'>";
    } else {
        echo "<script>alert('Hapus Gagal: " . addslashes($stmt->error) . "')</script>";
        echo "<meta http-equiv='refresh' content='0; url=index.php?halaman=pakai_tampil'>";
    }
    
    $stmt->close();
}
?>
