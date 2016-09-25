<?php

/**
 * Home template, success state.
 * User has searched, results were found.
 */

get_header( $this );

?>

<main>
	
	<div class="row">
		<?php get_template_part( $this, 'search-form' ); ?>
	</div>

	<div class="grid">
		
		<?php for ($i=0; $i < 5; $i++): ?>
			<article class="grid__item feed-item">

				<h2 class="feed-item__title">This is a title</h2>
				<p class="feed-item__attribution">From BBC News</p>

				<div class="feed-item__thumbnail" data-image-id="<?php echo $i ?>">
					<?php // img to be inserted here dynamically ?>
				</div>
				
				<p class="feed-item__excerpt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis.</p>

				<a class="button feed-item__button" href="http://www.example.com">Read on BBC News</a>

			</article>
		<?php endfor; ?>

	</div>

</main>

<?php get_footer( $this ); ?>
