<?php

/**
 * Home template, success state.
 * User has searched, results were found.
 */

get_header( $this );

$results = $this->getProperty( 'results' );
$resultsCount = $this->getProperty( 'resultsCount' );
$rawResultsCount = $this->getProperty( 'rawResultsCount' );

$isExpanded = $this->isExpanded();

?>
	
<?php get_template_part( $this, 'search-form' ); ?>
<p>
	<a class="inline-link" href="index.php">Show trending searches</a>
</p>

<section class="content" id="results">
	
	<h2 class="title title--secondary">
		<?php if ( $rawResultsCount !== $resultsCount ): ?>
			Top 
		<?php endif ?>
		<?php echo sprintf( _n( '%d result', '%d results', $resultsCount ), $resultsCount ) ?> for &ldquo;<?php echo esc_html( $this->getProperty( 'search_terms' ) ); ?>&rdquo;
	</h2>
	
	<div class="grid feed-items">

		<?php foreach ($results as $result): ?>				

			<?php 
				$title = $result->title;
				$permalink = esc_attr( $result->permalink );
			?>
			<article class="grid__item feed-item <?php echo ( ( 1 === $resultsCount ) ? 'one' : '' ) ?>">

				<div class="feed-item__inner <?php echo ( ( !$isExpanded ) ? 'feed-item__inner--no-image' : '' ) ?>">

					<header class="feed-item__header">
						<h3 class="feed-item__title"><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h3>
						<p class="feed-item__attribution small"><a href="<?php echo esc_attr( $result->feedData->baseURL ) ?>"><?php echo $result->feedData->displayBaseURL ?></a></p>
					</header>

					<a class="feed-item__thumbnail <?php echo ( ( !$isExpanded ) ? 'js-lazy-load' : '' ) ?> " href="<?php echo $permalink; ?>" data-image-object="<?php echo esc_attr_json( $result->imageJSON ) ?>">

						<?php if ( $isExpanded ): ?>
							<img src="<?php echo $result->imageData['src'] ?>" alt="<?php echo $result->imageData['alt'] ?>" width="<?php echo $result->imageData['width'] ?>" height="<?php echo $result->imageData['height'] ?>">								
						<?php endif ?>

					</a>

					<p class="feed-item__excerpt small">
						<span><?php echo $result->description; ?></span>
						<a class="inline-link feed-item__link" href="<?php echo $permalink; ?>">Read on <?php echo $result->feedData->displayBaseURL ?></a>
					</p>
						
					<?php if ( $isExpanded ): ?>

						<footer class="feed-item__footer">

							<time class="feed-item__date small" datetime="2016-12-31">31<sup>st</sup> December 2016</time>

							<div class="feed-item__share">
								<a class="social social--with-tooltip" href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode( $permalink ) ?>">
									<svg class="social__icon social__icon--medium social__icon--facebook" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><use xlink:href="#facebook"></use></svg>
									<span class="social__tooltip">Share on Facebook</span>
								</a>
								<a class="social social--with-tooltip" href="https://twitter.com/intent/tweet/?text=<?php echo urlencode( esc_attr( $title ) ) ?>&url=<?php echo urlencode( $permalink ) ?>">
									<svg class="social__icon social__icon--medium social__icon--twitter" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><use xlink:href="#twitter"></use></svg>
									<span class="social__tooltip">Share on Twitter</span>
								</a>
								<a class="social social--with-tooltip" href="<?php echo $result->feedData->subscribeURL ?>">
									<svg class="social__icon social__icon--medium social__icon--rss" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><use xlink:href="#rss"></use></svg>
									<span class="social__tooltip">Subscribe to RSS Feed</span>
								</a>
							</div>
						</footer>

					<?php endif ?>

				</div>

			</article>

		<?php endforeach; ?>

	</div>

</section>

<?php get_footer( $this ); ?>
