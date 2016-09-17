<?php
	
/**
 * Navigation module functionality. Helper functions to use when building navigation sections.
 */

/**
 * Return the active class if the $filename is the current viewed page.
 * @param  string  $filename The page's file name, i.e. everything before the .php extension.
 * @param  string  $class    Optional, The class(es) that should be applied if this is the current page.
 */
function is_page( $filename, $class = null ) {
	global $page;

	// Convert $filename into the correct format
	$filename = Page::sanitise_filename( $filename );

	if ( $page && $page->get_filename() === $filename ) {
		if ( isset( $class ) ) {
			echo $class;
		}

		return true;
	} else {
		return false;
	}
}
