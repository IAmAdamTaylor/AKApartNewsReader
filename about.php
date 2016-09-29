<?php 

require_once 'framework/init.php';

// Set up home page
$model = new WebApp\About\Model();
$controller = new WebApp\About\Controller( $model );
$view = new WebApp\About\View( $model );

if ( isset( $_GET['expanded'] ) && 1 == $_GET['expanded'] ) {

	$controller->enableExpandedView();

}

ob_start();

$view->output();

$html = ob_get_clean();
echo minify_html( $html );
