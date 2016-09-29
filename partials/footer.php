<?php

/**
 * Template part for showing the footer of the site.
 */

?>

			<?php if ( 'home/success.php' === $view->getTemplate() && $view->isExpanded() ): ?>
				
				<div class="footer content">
					<a class="small inline-link" href="about.php">How was this made?</a>

					<div class="footer__social">
						<a class="social" href="https://www.twitter.com/IAmAdamTaylor">
							<svg class="social__icon social__icon--dark social__icon--large" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><use xlink:href="#twitter"></use></svg>
							<span class="sr-only">Follow me on Twitter</span>
						</a>
						<a class="social" href="https://www.github.com/ThisProjectFilePath">
							<svg class="social__icon social__icon--dark social__icon--large" fill="#414141" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" aria-hidden="true"><use xlink:href="#github"></use></svg>
							<span class="sr-only">View on GitHub</span>
						</a>
					</div>
				</div>

			<?php endif ?>

			<?php // Close tags opened in header.php ?>
		</div>
	</main>

	<script type="text/javascript">var pageBaseUrl = '<?php echo getScriptPath();  ?>&';<?php 
		requireAsset( 'public/js/libs.min.js' );
		
		if ( 'about.php' !== $view->getTemplate() ) {
			requireAsset( 'public/js/feed.min.js' );
		}

		requireAsset( 'public/js/main.min.js' );

		if ( supportsExpandedView( $view ) && !$view->isExpanded() ) {
			requireAsset( 'public/js/expanded.min.js' );
		} 
	?></script>
	
</body>
</html>
