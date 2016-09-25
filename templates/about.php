<?php

/**
 * About template, blank state.
 */

get_header( $this );

?>

<main id="content">
	<div class="container">

		<article class="article">
	
			<h2 class="title title--secondary">About this project</h2>

			<p>This project was created as a contest entry for the <a href="https://a-k-apart.com/">A K Apart contest</a>. Every page on the project loads 10KB (or under) of data and is fully usable without JavaScript. Lazy loaded media, like the images in the search results, were specifically excluded from the contest rules and don't count towards the 10KB limit.</p>
			<p>This project should be usable in any browser on any device. It's compatible with Internet Explorer 8+, Chrome, Firefox, Opera and Microsoft Edge. It's also fully responsive down to 270px, which means it <a href="http://www.macrumors.com/2014/11/18/apple-watch-resolutions/">should even fit on the Apple Watch</a>!</p>

			<div class="article__content">
				
				<section>
					
					<h3 class="title title--tertiary">The Idea</h3>

					<p>Wanted to aim for something that contained to be useful even after the content finished.</p>
					<p>RSS feed reader, that shows articles based on user search.</p>
					<p>Allows me to use both my front and back end skills; back end to parse and manipulate the data and then output to the front end via templates.</p>

				</section>

				<section>
					
					<h3 class="title title--tertiary">Implementation</h3>

					<p>Started with a quick sketch of the design I wanted to achieve. I knew it had to be quite simple to fit within the limit, so I went with a very minimalist layout, focusing specifically on the content.</p> 
					<p>Limit the amount of data shown to keep it under the 10KB limit. Chose to show the top 5 news items based on how relevant they were. Items that match more search terms are shown above others. The location the term is found in is also taken into account; terms found in the title are ranked as more important than those in the description.</p>
					<p>All code included in this project, apart from the included libraries, was custom written through the duration of the contest. None of it is copy and pasted from elsewhere.</p>
					<p>Uses the <a href="http://simplepie.org/">SimplePie PHP Library</a> to read the RSS feeds, and a combination of <a href="https://github.com/filamentgroup/enhance/blob/master/enhance.js">Filament Group's enhance.js</a> and <a href="https://github.com/bramstein/fontfaceobserver">Bram Stein's FontFaceObserver</a> to load the <a href="https://fonts.google.com/specimen/PT+Sans">PT Sans font from Google Fonts</a></p>
					<p>All SVG icons used in this project are downloaded from <a href="https://icomoon.io/app/#/select/library">IcoMoon App</a> and then optimised with <a href="https://jakearchibald.github.io/svgomg/">SVGOMG</a></p>
					<p>Throughout the project, I tried to follow best practices regarding both my front and back end code. The back end uses PHP 5.3's namespacing features and follows a MVC architecture pattern, with each class holding a single responsibility. The front end showcases semantic HTML, a mobile-first approach (where it made sense - some styles use less code if applied with "max-width") and follows accessibility guidelines.</p>

				</section>

				<section>
					
					<h3 class="title title--tertiary">Adding the Polish</h3>

					<p>Brought in <a href="http://gulpjs.com/">Gulp task runner</a> to optimise the assets as much as possible.</p>
					<p>Skeleton states and neat transitions between the 3 states available.</p>
					<p>Check with 1, 2, 3, 4 &amp; 5 results.</p>
					<p>Check as many browsers, devices as possible including JAWS screen reader.</p>
					<p>Caching of as many assets as possible allows for a fast, performant experience for everyone.</p>

				</section>

				<section>
					
					<h3 class="title title--tertiary">About Me</h3>

					<p>Developer, 3 years agency experience. Currently building my own portfolio website. Started back end, then learnt front end and bridged the gap. Both parts really interest me and how they work together. Interest in UX and pushing the boundaries of the web. Whether it's creating an interesting animation or parsing an XML API, I'm right at home!</p>
					<p class="social-section small">
						<a class="social social--badge social--twitter" href="https://www.twitter.com/IAmAdamTaylor">
							<svg class="social__icon social__icon--medium" fill="#414141" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><use xlink:href="#twitter"></use></svg>
							<span class="social__title">Follow me on Twitter</span>
						</a>
						<br class="social-section__clearer">
						<a class="social social--badge social--github" href="https://www.github.com/ThisProjectFilePath">
							<svg class="social__icon social__icon--medium" fill="#ffffff" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><use xlink:href="#github"></use></svg>
							<span class="social__title">View this project on GitHub</span>
						</a>
					</p>

				</section>

				<section class="article__demo">
					
					<h3 class="title title--secondary">Try it out!</h3>
					<p>Enter your search terms and we&rsquo;ll find the latest&nbsp;news&nbsp;for&nbsp;you.</p>

					<?php get_template_part( $this, 'search-form' ); ?>
					<p>
						<a href="index.php">View trending searches</a>
					</p>

				</section>

			</div>

		</article>

	</div>
</main>

<?php get_footer( $this ); ?>
