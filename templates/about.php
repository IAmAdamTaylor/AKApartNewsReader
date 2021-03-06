<?php

/**
 * About template, blank state.
 */

get_header( $this );

$isExpanded = $this->isExpanded();

?>

<article class="content article">

	<h2 class="sr-only">How was this made?</h2>

	<section class="article__main">

		<h3 class="title title--secondary">About this project</h3>

		<p>This project was created as a contest entry for the <a href="https://a-k-apart.com/">A K Apart contest</a>. Every page on the project loads 10KB (or under) of data and is fully usable without JavaScript. Lazy loaded media, like the images in the search results, were specifically excluded from the contest rules and don't count towards the 10KB limit.</p>
		<p>This project was made to be usable in any browser on any device. It's compatible with all modern browsers and Internet Explorer 9+. It's fully responsive down to 270px, which means it <a href="http://www.macrumors.com/2014/11/18/apple-watch-resolutions/">should fit on even the Apple Watch</a>!</p>

		<section>
			
			<h4 class="title title--tertiary">The Idea</h4>

			<p>I knew that I wanted to aim for something that continued to be useful after the contest had finished. I wanted to create something that would showcase my full range of skills, both front and back end.</p>
			<p>Since I wanted an interactive element, rather than a static page, my first thought was a search form. Once I decided that I wanted to display large, colourful images, it evolved into the idea to let users search for news articles and show them the most relevant results.</p>

		</section>

		<section>
			
			<h4 class="title title--tertiary">Implementation</h4>

			<p>Since the size limit was so small, I knew the design would have to be simple &amp; efficient. I went with a very minimalist layout, focusing specifically on the content. I made the decision to only show the top 5 results by default, which helps to keep the initial page load under 10KB.</p>

			<p>The results are ranked by how many search terms appear within them, with the more relevant items being sorted to the top. The location each term is found in is taken into account; terms found in the title are ranked as more important than those in the description. Finally, I implemented an absolute/relative date parser and reduced the relevance of older items.</p>

			<p>There are 3 levels of caching included to make sure the results return as quickly as possible every time. Firstly, any terms, that find results, are cached and included in the <a href="index.php">Trending Searches</a>. Secondly, the results found (and their relevancy) are cached to speed up similar searches. Finally, the PHP library I used to read the RSS feed caches the response from each feed.</p>
			
			<?php if ( $isExpanded ): ?>
				
				<p>Throughout the project, I tried to follow best practices regarding both my front and back end code. The back end uses PHP 5.3's namespacing features and follows a MVC architecture pattern, with each class holding a single responsibility. The front end showcases semantic HTML, a mobile-first approach (where it made sense - some styles use less code if applied with "max-width") and follows accessibility guidelines.</p>

				<p>I used the <a href="http://simplepie.org/">SimplePie PHP Library</a> to read the RSS feeds, and a combination of <a href="https://github.com/filamentgroup/enhance/blob/master/enhance.js">Filament Group's enhance.js</a> and <a href="https://github.com/bramstein/fontfaceobserver">Bram Stein's FontFaceObserver</a> to lazy load the <a href="https://fonts.google.com/specimen/PT+Sans">PT Sans font from Google Fonts</a>.</p>
				<p>All SVG icons used in this project are downloaded from <a href="https://icomoon.io/app/#/select/library">IcoMoon App</a> and then optimised with <a href="https://jakearchibald.github.io/svgomg/">SVGOMG</a>.</p>

			<?php endif ?>

		</section>

		<section>
			
			<h4 class="title title--tertiary">Adding the Polish</h4>

			<p>Once the core functionality had been created, I tested everything and fixed any pressure points. To help keep under the limit, I added the <a href="http://gulpjs.com/">Gulp task runner</a> to optimise the assets as much as possible, and <a href="https://gist.github.com/tovic/d7b310dea3b33e4732c0">a PHP function</a> to minify the HTML before output.</p>

			<p>The grid of results adapts it's layout to accomodate any number of results from 1 to 101. Behind the scenes, it uses Flexbox with a flex-basis to prevent the items from getting too small and a simple container queries implementation to switch the layout as needed. I added microdata to allow spiders and bots to better process the results.</p>

			<p>Results already loaded very quickly, but to help speed up the perceived performance I added skeleton screens that would load as the search was made and then fill with content as it was receieved.</p>

			<p>To squeeze certain pages in under the limit, I limited the initial content of the page and used a small AJAX snippet to request an expanded view.</p>

			<p>After all of this, I tested it in every browser I could find to make sure it was as compatible as possible.</p>

			<?php if ( $isExpanded ): ?>
				<p>Oh, and have you tried printing it yet? :)</p>
			<?php endif ?>

		</section>

	</section>

	<?php if ( $isExpanded ): ?>
		
		<section>
			
			<h3 class="title title--secondary">About Me</h3>

			<p>I'm a Web Developer with 3 years agency experience. I started my career quite late, when I was 22, as a back end developer. The first language I worked with was PHP and my first real development job introduced me to WordPress. I became really interested in the front end and how we, as developers, can improve the user experience. Whether it's creating an interesting animation or parsing an XML API, I'm right at home!</p>
			<p class="social-section small">
				<a class="social social--badge social--twitter" href="https://www.twitter.com/IAmAdamTaylor">
					<svg class="social__icon social__icon--medium" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><use xlink:href="#twitter"></use></svg>
					<span class="social__title">Follow me on Twitter</span>
				</a>
				<br class="social-section__clearer">
				<a class="social social--badge social--github" href="https://github.com/IAmAdamTaylor/AKApartNewsReader">
					<svg class="social__icon social__icon--medium" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" aria-hidden="true"><use xlink:href="#github"></use></svg>
					<span class="social__title">View this project on GitHub</span>
				</a>
			</p>

		</section>

		<section class="article__demo">
			
			<h3 class="title title--secondary">Try it out!</h3>
			<p>Enter your search terms and we&rsquo;ll find the latest&nbsp;news&nbsp;for&nbsp;you.</p>

			<?php get_template_part( $this, 'search-form' ); ?>
			<p>
				<a href="index.php">Show trending searches</a>
			</p>

		</section>
		
	<?php endif ?>

</article>

<?php get_footer( $this ); ?>
