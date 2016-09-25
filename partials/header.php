<?php

/**
 * Template part for displaying the header of the site.
 */

?><!DOCTYPE html>
<!--[if IE 9]>
<html class="ie ie9 no-js" lang="en">
<![endif]-->
<!--[if !(IE 9) ]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
	<title><?php echo $view->getPageTitle() ?> | <?php echo SITE_NAME ?></title>
	<meta charset="UTF-8" /> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $view->getMetaDescription() ?>">

	<style type="text/css"><?php include 'public/css/style.min.css'; ?></style>
</head>

<body class="<?php echo $view->getBodyClass(); ?>">

	<a class="skip-link button sr-only" id="skip-to-content" href="#content">Skip to content</a>

	<svg style="display:none;">
		<symbol id="plus" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2q0.414 0 0.707 0.293t0.293 0.707v8h8q0.414 0 0.707 0.293t0.293 0.707-0.293 0.707-0.707 0.293h-8v8q0 0.414-0.293 0.707t-0.707 0.293-0.707-0.293-0.293-0.707v-8h-8q-0.414 0-0.707-0.293t-0.293-0.707 0.293-0.707 0.707-0.293h8v-8q0-0.414 0.293-0.707t0.707-0.293z"/></symbol>
		<symbol id="facebook" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M29 0h-26c-1.65 0-3 1.35-3 3v26c0 1.65 1.35 3 3 3h13v-14h-4v-4h4v-2c0-3.306 2.694-6 6-6h4v4h-4c-1.1 0-2 0.9-2 2v2h6l-1 4h-5v14h9c1.65 0 3-1.35 3-3v-26c0-1.65-1.35-3-3-3z"/></symbol>
		<symbol	id="twitter" viewBox="0 0 32 32"><path d="M32 7.075c-1.175.525-2.444.875-3.77 1.03 1.357-.812 2.395-2.1 2.888-3.63-1.27.75-2.675 1.3-4.17 1.594C25.75 4.79 24.044 4 22.156 4c-3.625 0-6.563 2.938-6.563 6.563 0 .512.056 1.012.17 1.494-5.46-.275-10.297-2.887-13.533-6.862-.563.97-.887 2.1-.887 3.3 0 2.275 1.156 4.287 2.92 5.463-1.076-.03-2.088-.33-2.976-.82v.082c0 3.18 2.263 5.838 5.27 6.437-.55.15-1.132.23-1.732.23-.425 0-.83-.043-1.237-.118.838 2.6 3.263 4.5 6.13 4.56-2.25 1.76-5.074 2.81-8.155 2.81-.53 0-1.05-.03-1.57-.094C2.908 28.92 6.357 30 10.063 30c12.076 0 18.68-10.005 18.68-18.68 0-.287-.004-.57-.017-.85 1.28-.92 2.394-2.075 3.275-3.394z"/></symbol>
		<symbol	id="github" viewBox="0 0 32 32"><path d="M16 .395c-8.836 0-16 7.163-16 16 0 7.07 4.585 13.067 10.942 15.182.8.148 1.094-.347 1.094-.77 0-.38-.015-1.642-.022-2.98-4.452.97-5.39-1.887-5.39-1.887-.73-1.85-1.777-2.34-1.777-2.34-1.452-.994.11-.974.11-.974 1.606.113 2.452 1.65 2.452 1.65 1.42 2.445 3.74 1.738 4.65 1.33.14-1.035.56-1.74 1.01-2.14-3.555-.405-7.29-1.778-7.29-7.908 0-1.747.624-3.174 1.65-4.295-.168-.403-.716-2.03.153-4.234 0 0 1.344-.43 4.4 1.64 1.28-.36 2.65-.54 4.01-.54 1.36 0 2.73.18 4.01.54C23.06 6.6 24.4 7.03 24.4 7.03c.87 2.2.324 3.83.158 4.23 1.03 1.12 1.65 2.55 1.65 4.292 0 6.145-3.743 7.498-7.306 7.895.574.5 1.085 1.47 1.085 2.964 0 2.14-.02 3.87-.02 4.39 0 .43.29.93 1.1.77C27.42 29.46 32 23.46 32 16.4c0-8.837-7.164-16-16-16z"/></symbol>
	</svg>

	<header class="header">
		<a href="index.php">
			<h1 class="site-name">Byte-Sized News</h1>
		</a>

		<div class="header__right">
			<a class="header__how small" href="about.php">How was this made?</a>
			<a class="social" href="https://www.twitter.com/IAmAdamTaylor">
				<svg class="social__icon" fill="#ffffff" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><use xlink:href="#twitter"></use></svg>
				<span class="sr-only">Follow me on Twitter</span>
			</a>
			<a class="social" href="https://www.github.com/ThisProjectFilePath">
				<svg class="social__icon" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><use xlink:href="#github"></use></svg>
				<span class="sr-only">View on GitHub</span>
			</a>
		</div>
	</header>
