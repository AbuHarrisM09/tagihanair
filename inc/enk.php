<?php
/**
 * Encryption/Hashing Helper
 * Provides SHA1 hashing for page identifiers (legacy support)
 * Note: Consider using more secure authentication methods in production
 */

// Define hashed page identifiers for customer portal
define('HASH_HOME_PE', sha1('home_pe'));
define('HASH_P_TAGIH_TAMPIL', sha1('p_tagih_tampil'));
define('HASH_P_LUNAS_TAMPIL', sha1('p_lunas_tampil'));
define('HASH_APK', sha1('apk'));

/**
 * Get hashed identifier for a page name
 * @param string $page Page identifier
 * @return string SHA1 hash of the page identifier
 */
function hashPage($page) {
    return sha1($page);
}
?>
