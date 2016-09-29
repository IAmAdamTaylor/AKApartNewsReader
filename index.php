<?php 

require_once 'framework/init.php';

// Set up home page
$model = new WebApp\Home\Model();
$controller = new WebApp\Home\Controller( $model );
$view = new WebApp\Home\View( $model );

// Check if a search query has been entered
if ( isset( $_GET['search'] ) ) {
	
	// Search query entered, process it
	$controller->handleSearch( $_GET['search'] );

}

if ( isset( $_GET['expanded'] ) && 1 == $_GET['expanded'] ) {

	$controller->enableExpandedView();

}

ob_start();

$view->output();

$html = ob_get_clean();
echo minify_html( $html );
