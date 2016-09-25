<?php 

require_once 'framework/init.php';

// Set up home page
$model = new WebApp\About\Model();
$controller = new WebApp\About\Controller( $model );
$view = new WebApp\About\View( $model );

$view->output();
