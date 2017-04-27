<?php

/**
 * Convert Bytes to Human readable format
 *
 * @param     $bytes
 * @param int $precision
 *
 * @return string
 */
function bytesToSize( $bytes, $precision = 2 ) {
	$kilobyte = 1024;
	$megabyte = $kilobyte * 1024;
	$gigabyte = $megabyte * 1024;
	$terabyte = $gigabyte * 1024;

	if ( ( $bytes >= 0 ) && ( $bytes < $kilobyte ) ) {
		return $bytes . ' B';

	} elseif ( ( $bytes >= $kilobyte ) && ( $bytes < $megabyte ) ) {
		return round( $bytes / $kilobyte, $precision ) . ' KB';

	} elseif ( ( $bytes >= $megabyte ) && ( $bytes < $gigabyte ) ) {
		return round( $bytes / $megabyte, $precision ) . ' MB';

	} elseif ( ( $bytes >= $gigabyte ) && ( $bytes < $terabyte ) ) {
		return round( $bytes / $gigabyte, $precision ) . ' GB';

	} elseif ( $bytes >= $terabyte ) {
		return round( $bytes / $terabyte, $precision ) . ' TB';
	} else {
		return $bytes . ' B';
	}
}

/**
 * Get the current memory usage consumed by PHP
 * @return string
 */
function getMemUsage() {
	return bytesToSize( memory_get_usage( true ) );
}

/**
 * Insert line break depending on php environment
 * @return string
 */
function br() {
	return ( PHP_SAPI === 'cli' ? "\n" : "<br />" );
}