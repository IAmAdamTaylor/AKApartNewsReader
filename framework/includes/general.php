<?php

/**
 * Site wide, general use functions.
 */

/**
 * Makes sure that a string has a trailing slash.
 * @param  string $string
 * @return string
 */
function trailingslashit( $string ) {
  $string = rtrim( $string, '/\\' );

  return $string . '/';
}

/**
 * Return the URL path to the site's main directory.
 * @param  string $path A path to append to the directory.
 * @return string
 * @alias get_permalink()
 */
function get_site_url( $path = '' ) {
	return trailingslashit( SITE_URL ) . $path;
}
function get_permalink( $path = '' ) {
	return get_site_url( $path );
}

/**
 * Return the URL path to the site's images directory.
 * @param  string $path A path to append to the directory.
 * @return string
 */
function get_image_url( $path = '' ) {
	return get_site_url( 'images/' . $path );
}

/**
 * Return the URL path to the site's JavaScript (js) directory.
 * @param  string $path A path to append to the directory.
 * @return string
 */
function get_javascript_url( $path = '' ) {
	return get_site_url( 'js/' . $path );
}

/**
 * Return the URL path to the site's css directory.
 * @param  string $path A path to append to the directory.
 * @return string
 */
function get_css_url( $path = '' ) {
	return get_site_url( 'css/' . $path );
}
