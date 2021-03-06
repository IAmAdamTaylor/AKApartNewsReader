<?php

/**
 * Initialise the framework and run any actions required.
 *
 * Custom Framework
 * @author Adam Taylor <sayhi@iamadamtaylor.com>
 * @version 1.0.0 
 */

// Load config
require_once 'config.php';

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
define( 'CACHE_BASE_PATH', ROOT_PATH . 'cache/' );

// Include global functions
require_once INCLUDES_PATH . 'functions-general.php';
require_once INCLUDES_PATH . 'functions-templates.php';
require_once INCLUDES_PATH . 'functions-sanitisers.php';
require_once INCLUDES_PATH . 'functions-minifiers.php';

fix_server_vars();

// Register the autoloader
require_once 'includes/Autoloader.php';
$loader = new Autoloader();
$loader->register();

// Register the base directories for each namespace prefix
$namespace_dirs = array(
	// CustomException: Abstract for easily creating custom exception objects.
	'CustomException',
	// RelativeDate: Extensions of the DateTime classes for handling relative dates.
	'RelativeDate',
	// Cache: Handles cache storage and retrieval. Other objects may implement the ControllerInterface
	'Cache',
	// WebApp: Handles the request response cycle and loads templates.
	'WebApp',
	// Search: Handles processing the search terms, caching and getting results
	'Search',
	// Feed: Gets the feed items and parses them based on the user query
	'Feed',
);

foreach ($namespace_dirs as $namespace) {
	$loader->addNamespace( $namespace, INCLUDES_PATH . $namespace );
}

// Check if base cache folder exists, if not create it
$cacheManager = Cache\Manager::instance();
if ( !$cacheManager->doesFolderExist( '' ) ) {
	$cacheManager->createFolder( '' );
}
