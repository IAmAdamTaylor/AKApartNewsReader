<?php

/**
 * Home template, error state.
 * User has searched, no search results have been found.
 */

use Search\Terms\Trending\Controller as TrendingController;

get_header( $this );

$search_terms = $this->getProperty( 'search_terms' );

?>

<main id="content">
	<div class="container">

		<?php get_template_part( $this, 'search-form' ); ?>
		
		<h2 class="title title--secondary">No results found</h2>
		<?php if ( '' === $search_terms ): ?>
			
			<p class="small container">Enter some search terms and we&rsquo;ll find the latest&nbsp;news&nbsp;for&nbsp;you.</p>

		<?php else: ?>

			<p>We couldn't find any results for &ldquo;<?php echo esc_html( $search_terms ); ?>&rdquo;.</p>
			<p class="u-no-margin">Please check for spelling mistakes, or try searching for different terms.</p>
				
		<?php endif ?>

		<div class="content">

			<?php 
				$trendingController = new TrendingController();
				$terms = $trendingController->getTerms( 12, $this->getProperty( 'search_terms' ) );
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
