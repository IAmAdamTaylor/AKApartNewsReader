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

// Include global functions
require_once INCLUDES_PATH . 'functions-general.php';
require_once INCLUDES_PATH . 'functions-templates.php';

fix_server_vars();

// Register the autoloader
require_once 'includes/Autoloader.php';
$loader = new Autoloader();
$loader->register();

// Register the base directories for each namespace prefix

// WebApp: Handles the request response cycle and loads templates.
$loader->addNamespace('WebApp', INCLUDES_PATH . '/WebApp');

// FeedReader: Gets the feed items based on the user query
$loader->addNamespace('FeedReader', INCLUDES_PATH . '/FeedReader');

// SimplePie: External library included to read RSS feeds
// $loader->addNamespace('SimplePie', 'includes/SimplePie');
