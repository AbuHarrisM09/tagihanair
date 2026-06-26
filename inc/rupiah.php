<?php
/**
 * Currency Formatting Helper
 * Formats numbers to Indonesian Rupiah format
 */

/**
 * Format number to Indonesian Rupiah
 * @param float|int $angka Number to format
 * @return string Formatted currency string
 */
function rupiah($angka) {
    return "Rp. " . number_format($angka, 2, ',', '.');
}
?>