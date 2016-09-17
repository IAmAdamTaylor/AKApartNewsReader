<?php

/**
 * Template part for displaying the header of the site.
 */

?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="en">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="en">
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<title><?php echo $page->title ?> | <?php echo SITE_NAME ?></title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $page->description ?>">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_css_url( 'style.min.css' ) ?>">

	<!--[if IE]>
	  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<body>

<header class="header" role="banner">
	<div class="container">

		<a href="index.php" title="Home">
			<h1 class="logo">
				<img class="logo__image" src="<?php echo get_image_url( 'logo.png' ) ?>" alt="">
				<span class="logo__text"><br><?php echo SITE_NAME ?></span>
			</h1>
		</a>

		<?php include 'navigation.php'; ?>

	</div>
</header>
