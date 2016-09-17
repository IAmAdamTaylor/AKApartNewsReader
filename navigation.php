<?php
	
/**
 * Template part for the primary navigation.
 * @uses string $page The page name, defined in the top level template file, e.g. index.php, contact.php.
 */

$is_active_class = 'is-active';

?>

<nav class="nav" role="navigation">

	<ul class="menu">

		<li class="menu__item <?php is_page( 'index', $is_active_class ) ?> ">
			<a href="<?php echo get_site_url() ?>" title="Home">Home</a>
		</li>

		<li class="menu__item <?php is_page( 'contact', $is_active_class ) ?> ">
			<a href="<?php echo get_site_url('contact') ?>" title="Contact Us">Contact Us</a>
		</li>

	</ul>

</nav>
