<?php

/**
 * Home template, success state.
 * User has searched, results were found.
 */

get_header( $this );

$results = $this->getProperty( 'results' );
$result_count = count( $results );

?>

<main>
	<div class="container">
	
		<div class="container">
			<?php get_template_part( $this, 'search-form' ); ?>
			<p>
				<a class="inline-link" href="index.php">Show trending searches</a>
			</p>
			<h2 class="title title--secondary"><?php echo sprintf( _n( '%d result', '%d results', $result_count ), $result_count ) ?> for &ldquo;<?php echo esc_html( $this->getProperty( 'search_terms' ) ); ?>&rdquo;</h2>
		</div>

		<div class="grid feed-items">

			<?php
				// $result = reset( $results );
			?>
			
			<?php foreach ($results as $result): ?>				
			<?php //for ($i=0; $i < 5; $i++): ?>

				<?php 
					$title = $result->title;
					$permalink = esc_attr( $result->permalink );
				?>
				<article class="grid__item feed-item">

					<div class="feed-item__inner feed-item__inner--no-image">

						<h3 class="feed-item__title"><a href="<?php echo $permalink; ?>"><?php echo esc_html( $title ); ?></a></h3>
						<p class="feed-item__attribution small"><a href="<?php echo esc_attr( $result->feedData->baseURL ) ?>"><?php echo $result->feedData->displayBaseURL ?></a></p>

						<a class="feed-item__thumbnail js-lazy-load" href="<?php echo $permalink; ?>" data-image-object="<?php echo esc_attr_json( $result->imageJSON ) ?>">
							<?php // img to be inserted here dynamically ?>
						</a>

						<p class="feed-item__excerpt small"><?php echo esc_html( $result->description ); ?></p>
						<a class="inline-link feed-item__link small" href="<?php echo $permalink; ?>">Read on <?php echo $result->feedData->displayBaseURL ?></a>

						<footer class="feed-item__footer">

							<div class="feed-item__share">
								<a class="social social--with-tooltip" href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode( $permalink ) ?>">
									<svg class="social__icon social__icon--medium social__icon--facebook" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><use xlink:href="#facebook"></use></svg>
									<span class="social__tooltip">Share on Facebook</span>
								</a>
								<a class="social social--with-tooltip" href="https://twitter.com/intent/tweet/?text=<?php echo urlencode( esc_attr( $title ) ) ?>&url=<?php echo urlencode( $permalink ) ?>">
									<svg class="social__icon social__icon--medium social__icon--twitter" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><use xlink:href="#twitter"></use></svg>
									<span class="social__tooltip">Share on Twitter</span>
								</a>
								<a class="social social--with-tooltip" href="<?php echo $result->feedData->subscribeURL ?>">
									<svg class="social__icon social__icon--medium social__icon--rss" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><use xlink:href="#rss"></use></svg>
									<span class="social__tooltip">Subscribe to RSS Feed</span>
								</a>
							</div>
						</footer>

					</div>

				</article>
			<?php //endfor; ?>
			<?php endforeach; ?>

		</div>

	</div>
</main>

<?php get_footer( $this ); ?>
