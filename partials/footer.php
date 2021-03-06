<?php

/**
 * Template part for showing the footer of the site.
 */

?>

			<?php if ( 
				( 'home/success.php' === $view->getTemplate() && $view->isExpanded() ) ||
				'home/blank.php' === $view->getTemplate() ||
				'home/error.php' === $view->getTemplate()
			): ?>
				
				<div class="footer content">
					<a class="small inline-link" href="about.php">How was this made?</a>

					<div class="footer__social">
						<a class="social" href="https://www.twitter.com/IAmAdamTaylor">
							<svg class="social__icon social__icon--dark social__icon--large" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><use xlink:href="#twitter"></use></svg>
							<span class="sr-only">Follow me on Twitter</span>
						</a>
						<a class="social" href="https://github.com/IAmAdamTaylor/AKApartNewsReader">
							<svg class="social__icon social__icon--dark social__icon--large" fill="#414141" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" aria-hidden="true"><use xlink:href="#github"></use></svg>
							<span class="sr-only">View on GitHub</span>
						</a>
					</div>
				</div>

			<?php endif ?>

			<?php // Close tags opened in header.php ?>
		</div>
	</main>

	<script type="text/javascript">var pageBaseUrl = '<?php echo getScriptPath();  ?>&', siteName = ' | <?php echo SITE_NAME ?>';<?php 
		requireAsset( 'public/js/libs.min.js' );
		
		if ( 'about.php' !== $view->getTemplate() ) {
			requireAsset( 'public/js/feed.min.js' );
		}

		requireAsset( 'public/js/main.min.js' );

		if ( supportsExpandedView( $view ) && !$view->isExpanded() ) {
			requireAsset( 'public/js/expanded.min.js' );
		} 
	?></script>

	<script id="skeleton">/*<article class="grid__item feed-item skeleton js-skeleton-item"><div class="feed-item__inner"><div class="feed-item__thumbnail"></div></div></article>*/</script> 
</body>
</html>
