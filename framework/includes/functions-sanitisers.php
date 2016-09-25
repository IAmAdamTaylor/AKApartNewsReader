<?php

/**
 * Functions to sanitise the output, for XSS
 */

/**
 * Check invalid UTF-8 string
 */
function check_invalid_utf_8( $string, $strip = false ){
	$string = (string) $string;

	if ( 0 === strlen( $string ) ) {
		return '';
	}

	// Store the site charset as a static to avoid multiple calls to get_option()
	static $is_utf8;
	if ( !isset( $is_utf8 ) ) {
		$is_utf8 = in_array( 'UTF-8', array( 'utf8', 'utf-8', 'UTF8', 'UTF-8' ) );
	}
	if ( !$is_utf8 ) {
		return $string;
	}

	// Check for support for utf8 in the installed PCRE library once and store the result in a static
	static $utf8_pcre;
	if ( !isset( $utf8_pcre ) ) {
		$utf8_pcre = @preg_match( '/^./u', 'a' );
	}
	// We can't demand utf8 in the PCRE installation, so just return the string in those cases
	if ( !$utf8_pcre ) {
		return $string;
	}

	// preg_match fails when it encounters invalid UTF8 in $string
	if ( 1 === @preg_match( '/^./us', $string ) ) {
		return $string;
	}

	// Attempt to strip the bad chars if requested (not recommended)
	if ( $strip && function_exists( 'iconv' ) ) {
		return iconv( 'utf-8', 'utf-8', $string );
	}

	return '';
}

function _esc_specialchars( $string, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false ) {
	$string = (string) $string;

	if ( 0 === strlen( $string ) )
		return '';

	// Don't bother if there are no specialchars - saves some processing
	if ( ! preg_match( '/[&<>"\']/', $string ) )
		return $string;

	// Account for the previous behaviour of the function when the $quote_style is not an accepted value
	if ( empty( $quote_style ) )
		$quote_style = ENT_NOQUOTES;
	elseif ( ! in_array( $quote_style, array( 0, 2, 3, 'single', 'double' ), true ) )
		$quote_style = ENT_QUOTES;

	// Store the site charset as a static to avoid multiple calls to wp_load_alloptions()
	if ( ! $charset ) {
		static $_charset;
		$charset = 'UTF-8';
	}

	if ( in_array( $charset, array( 'utf8', 'utf-8', 'UTF8' ) ) )
		$charset = 'UTF-8';

	$_quote_style = $quote_style;

	if ( $quote_style === 'double' ) {
		$quote_style = ENT_COMPAT;
		$_quote_style = ENT_COMPAT;
	} elseif ( $quote_style === 'single' ) {
		$quote_style = ENT_NOQUOTES;
	}

	// Handle double encoding ourselves
	$string = @htmlspecialchars( $string, $quote_style, $charset );
	
	// Backwards compatibility
	if ( 'single' === $_quote_style )
		$string = str_replace( "'", '&#039;', $string );

	return $string;
}

/**
 * Sanitise HTML special characters.
 * @param string $text
 * @return string
 */
function esc_string( $string ) {
	$string = check_invalid_utf_8( $string );
	$string = _esc_specialchars( $string );

	return $string;
}

/**
 * Sanitise textarea.
 * @param string $text
 * @return string
 */
function esc_textarea( $text ) {
	return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' );
}

/**
 * Sanitise HTML attributes.
 * @param string $text
 * @return string
 */
function esc_attr( $text ) {
	return esc_string( $text );
}	

/**
 * Sanitise HTML output.
 * @param string $text
 * @return string
 */
function esc_html( $text ) {
	return esc_string( $text );
}	
