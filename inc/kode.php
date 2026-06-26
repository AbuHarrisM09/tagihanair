<?php
/**
 * Auto-increment Code Generator
 * Generates sequential codes for tb_pakai table
 */

/**
 * Generate next auto-increment code for usage records
 * @param mysqli $koneksi Database connection
 * @return string Generated code in format K000000001
 */
function generateKodePakai($koneksi) {
    $sql = "SELECT id_pakai FROM tb_pakai ORDER BY id_pakai DESC LIMIT 1";
    $result = $koneksi->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $kode = $row['id_pakai'];
        $urut = (int)substr($kode, 1);
    } else {
        $urut = 0;
    }
    
    $tambah = $urut + 1;
    $format = "K" . str_pad($tambah, 9, "0", STR_PAD_LEFT);
    
    return $format;
}

// For backward compatibility
$format = generateKodePakai($koneksi);
?>
