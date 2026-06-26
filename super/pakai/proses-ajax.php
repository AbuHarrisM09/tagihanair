<?php
/**
 * AJAX Handler for Customer Usage Data
 * Returns the last meter reading for a customer
 */

include '../../inc/koneksi.php';

header('Content-Type: text/html; charset=utf-8');

$output = '';

if (isset($_POST["id_pelanggan"])) {
    // Sanitize input
    $id_pelanggan = $_POST["id_pelanggan"];
    
    // Use prepared statement to prevent SQL injection
    $stmt = $koneksi->prepare("SELECT MAX(akhir) as awal FROM tb_pakai WHERE id_pelanggan = ?");
    $stmt->bind_param("s", $id_pelanggan);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $output = $row["awal"] ?? 0;
    }
    
    $stmt->close();
    echo $output;
}

$koneksi->close();
?>
