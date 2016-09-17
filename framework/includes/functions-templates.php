<?php
	
/**
 * Define functions that help to load templates or template parts.
 */

/**
 * Get and include the header of the site.
 */
function get_header() {
	global $page;
	include_once ROOT_PATH . 'header.php';
}

/**
 * Get and include the footer of the site.
 */
function get_footer() {
	global $page;
	include_once ROOT_PATH . 'footer.php';
}
