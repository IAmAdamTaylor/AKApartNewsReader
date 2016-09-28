<?php

/**
 * Template for the search form.
 */

$search_terms = $view->getProperty( 'search_terms' );

?>

<form class="search-form" action="index.php" method="GET">
	<label for="search">
		<svg class="search-form__icon" fill="#4a4a4a" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M31.008 27.23l-7.58-6.446c-.784-.705-1.622-1.03-2.3-.998C22.92 17.69 24 14.97 24 12c0-6.63-5.373-12-12-12S0 5.37 0 12s5.374 12 12 12c2.973 0 5.692-1.082 7.788-2.87-.03.676.293 1.514.998 2.298l6.447 7.58c1.105 1.226 2.908 1.33 4.008.23s.998-2.903-.23-4.007zM12 20c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z"/></svg>
		<span class="sr-only">Search for:</span>
	</label>
	<input class="search-form__input" id="search" name="search" type="search" value="<?php echo esc_attr( $search_terms ); ?>" placeholder="Search&hellip;">
	<button class="search-form__button" type="submit">Search</button>
</form>
