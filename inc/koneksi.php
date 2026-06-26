<?php
/**
 * Database Connection Handler
 * Provides secure database connection using prepared statements
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_air');

// Create database connection
$koneksi = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($koneksi->connect_error) {
    error_log("Database connection failed: " . $koneksi->connect_error);
    die("Database connection failed. Please contact administrator.");
}

// Set charset to prevent encoding issues
$koneksi->set_charset("utf8mb4");

/**
 * Safe query execution using prepared statements
 * @param string $sql SQL query with placeholders
 * @param string $types Parameter types (i=integer, s=string, d=double, b=blob)
 * @param array $params Parameters to bind
 * @return mysqli_stmt|false Prepared statement or false on failure
 */
function safe_query($sql, $types = '', $params = []) {
    global $koneksi;
    
    if (empty($params)) {
        return $koneksi->query($sql);
    }
    
    $stmt = $koneksi->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $koneksi->error);
        return false;
    }
    
    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }
    
    return $stmt;
}

/**
 * Fetch all results from a prepared statement
 * @param mysqli_stmt $stmt Prepared statement
 * @return array Array of results
 */
function fetch_all_safe($stmt) {
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Fetch single result from a prepared statement
 * @param mysqli_stmt $stmt Prepared statement
 * @return array|null Single result or null
 */
function fetch_one_safe($stmt) {
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>