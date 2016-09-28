<?php

/**
 * Home template, blank state.
 * Initial page load, no interaction yet.
 */

use Search\Terms\Trending\Controller as TrendingController;

get_header( $this );

?>

<main id="content">
	<div class="container">
	
		<?php get_template_part( $this, 'search-form' ); ?>
		<p class="small container">Enter some search terms and we&rsquo;ll find the latest&nbsp;news&nbsp;for&nbsp;you.</p>

		<div class="content">

			<?php 
				$trendingController = new TrendingController();
				$terms = $trendingController->getTerms( 12 );
			?>
			<?php if ( count( $terms ) > 0 ): ?>
				
				<h2 class="title title--secondary">Trending searches</h2>

				<div class="tags">

					<div class="grid">
						
						<?php foreach ($terms as $term => $term_amount): ?>
							<?php $term = maybeUcwords( $term ); ?>

							<a class="grid__item tag" href="index.php?search=<?php echo esc_attr( urlencode( $term ) ) ?>">
								<svg class="tag__icon" width="32" height="32" xmlns="http://www.w3.org/2000/svg"><use xlink:href="#plus"></use></svg>
								<?php echo esc_html( $term ) ?>
							</a>
						<?php endforeach ?>
					
					</div>

				</div>

			<?php endif ?>

		</div>

	</div>
</main>

<?php get_footer( $this ); ?>
