<?php
	
/**
 * Define functions that help to load templates or template parts.
 */

/**
 * Get and include any partial file.
 * @param PageViewInterface $view A view object.
 * @param string $path The path to the file, with or without .php extension
 * @param boolean [$require] Optional, true to require a file, false to include. Defaults to false.
 */
function get_template_part( $view, $path, $require = false ) {
	// Append the extension if not exists
	if ( false === strpos( $path, '.php' ) ) {
		$path .= '.php';
	}

	if ( $require ) {
		require ROOT_PATH . 'partials/' . $path;
	} else {
		include ROOT_PATH . 'partials/' . $path;
	}
}

/**
 * Get and include the header of the site.
 * @param PageViewInterface $view A view object.
 */
function get_header( $view ) {
	get_template_part( $view, 'header', true );
}

/**
 * Get and include the footer of the site.
 * @param PageViewInterface $view A view object.
 */
function get_footer( $view ) {
	get_template_part( $view, 'footer', true );
}
