<?php

/**
 * Home template, success state.
 * User has searched, results were found.
 */

get_header( $this );

$results = $this->getProperty( 'results' );

?>

<main>
	<div class="container">
	
		<div class="container">
			<?php get_template_part( $this, 'search-form' ); ?>
			<h2 class="title title--secondary"><?php echo count( $results ) ?> Results for &ldquo;<?php echo esc_html( $this->getProperty( 'search_terms' ) ); ?>&rdquo;</h2>
		</div>

		<div class="grid feed-items">

			<?php
				$item = reset( $results );
				$item = $item['item'];
			?>
			
			<?php for ($i=0; $i < 5; $i++): ?>

				<?php $permalink = esc_attr( $item->get_permalink() ) ?>
				<article class="grid__item feed-item">

					<div class="feed-item__inner">

						<h3 class="feed-item__title"><a href="<?php echo $permalink; ?>"><?php echo esc_html( $item->get_title() ); ?></a></h3>
						<p class="feed-item__attribution small"><a href="http://www.bbc.co.uk">bbc.co.uk</a></p>

						<a class="feed-item__thumbnail js-lazy-load" href="<?php echo $permalink; ?>" data-image-object='<?php echo $this->getImageJSON( $item ) ?>'>
							<?php // img to be inserted here dynamically ?>
						</a>

						<p class="feed-item__excerpt small"><?php echo esc_html( $item->get_description() ); ?></p>
						<a class="inline-link feed-item__link small" href="<?php echo $permalink; ?>">Read on bbc.co.uk</a>

						<footer class="feed-item__footer">

							<div class="feed-item__share">
								<a class="social social--with-tooltip" href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode( $permalink ) ?>">
									<svg class="social__icon social__icon--medium social__icon--facebook" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><use xlink:href="#facebook"></use></svg>
									<span class="social__tooltip">Share on Facebook</span>
								</a>
								<a class="social social--with-tooltip" href="https://twitter.com/intent/tweet/?text=<?php echo urlencode( esc_attr( $item->get_title() ) ) ?>&url=<?php echo urlencode( $permalink ) ?>">
									<svg class="social__icon social__icon--medium social__icon--twitter" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><use xlink:href="#twitter"></use></svg>
									<span class="social__tooltip">Share on Twitter</span>
								</a>
							</div>
						</footer>

					</div>

				</article>
			<?php endfor; ?>

		</div>

	</div>
</main>

<?php get_footer( $this ); ?>
