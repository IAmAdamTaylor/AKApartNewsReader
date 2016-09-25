<?php

/**
 * Template part for showing the footer of the site.
 */

?>

	<?php if ( 'home/success.php' === $view->getTemplate() ): ?>
		
		<div class="footer u-text-center">
			<a class="small inline-link" href="about.php">How was this made?</a>

			<div class="footer__social">
				<a class="social" href="https://www.twitter.com/IAmAdamTaylor">
					<svg class="social__icon social__icon--dark social__icon--large" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><use xlink:href="#twitter"></use></svg>
					<span class="sr-only">Follow me on Twitter</span>
				</a>
				<a class="social" href="https://www.github.com/ThisProjectFilePath">
					<svg class="social__icon social__icon--dark social__icon--large" fill="#414141" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><use xlink:href="#github"></use></svg>
					<span class="sr-only">View on GitHub</span>
				</a>
			</div>
		</div>

	<?php endif ?>

	<script type="text/javascript"><?php 
		include 'public/js/libs.min.js'; 
		
		if ( 'about.php' !== $view->getTemplate() ) {
			include 'public/js/search.min.js'; 
		}

		include 'public/js/main.min.js'; 
	?></script>
	
</body>
</html>
