<?php

/**
 * Load the files needed for the framework to run.
 */

// GENERAL USE FUNCTIONS
require_once INCLUDES_PATH . 'general.php';
require_once INCLUDES_PATH . 'functions-templates.php';

// CLASSES
require_once INCLUDES_PATH . 'class-page.php';

// SPECIFIC USE FUNCTIONS
require_once INCLUDES_PATH . 'functions-navigation.php';

// LOAD PLUGINS
#TODO: Write a class that loads all plugins that are dropped into the /plugins/ dir
// require_once INCLUDES_PATH . 'class-load-plugins.php';
