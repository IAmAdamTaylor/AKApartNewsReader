<?php

/**
 * Initialise the framework and run any actions required.
 *
 * Custom Framework
 * @author Adam Taylor <sayhi@iamadamtaylor.com>
 * @version 1.0.0 
 */

// Load config
require_once '_config.php';

// Check debug state
if ( defined( 'DEBUG' ) && DEBUG ) {
	// Enable debug mode
	@ini_set('display_errors', 1);
	error_reporting(E_ALL);
}

// Define the base path of the site
define( 'FRAMEWORK_PATH', dirname( __FILE__ ) . '/' );
define( 'ROOT_PATH', dirname( FRAMEWORK_PATH ) . '/' );

define( 'INCLUDES_PATH', FRAMEWORK_PATH . 'includes/' );

// Include the loader
require_once FRAMEWORK_PATH . 'loader.php';

// Create a global $page reference to the current page.
global $page;
$page = new Page( PAGE_PATH );

echo '<pre style="text-align:left;">'; 
var_dump( FRAMEWORK_PATH, ROOT_PATH, PAGE_PATH, $page ); 
echo '</pre>';
