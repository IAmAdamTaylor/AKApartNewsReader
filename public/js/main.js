/*! EnhanceJS: a progressive enhancement boilerplate. Copyright 2014 @scottjehl, Filament Group, Inc. Licensed MIT */
( function( window, document, undefined ) {

	// loadCSS: load a CSS file asynchronously. Included from https://github.com/filamentgroup/loadCSS/
	function loadCSS( href, before, media ){
		// Arguments explained:
		// `href` is the URL for your CSS file.
		// `before` optionally defines the element we'll use as a reference for injecting our <link>
		// By default, `before` uses the first <script> element in the page.
		// However, since the order in which stylesheets are referenced matters, you might need a more specific location in your document.
		// If so, pass a different reference element to the `before` argument and it'll insert before that instead
		// note: `insertBefore` is used instead of `appendChild`, for safety re: http://www.paulirish.com/2011/surefire-dom-element-insertion/
		var ss = document.createElement( "link" );
		var ref = before || document.getElementsByTagName( "script" )[ 0 ];
		var sheets = document.styleSheets;
		ss.rel = "stylesheet";
		ss.href = href;
		// temporarily, set media to something non-matching to ensure it'll fetch without blocking render
		ss.media = "only x";
		// inject link
		ref.parentNode.insertBefore( ss, ref );
		// This function sets the link's media back to `all` so that the stylesheet applies once it loads
		// It is designed to poll until document.styleSheets includes the new sheet.
		function toggleMedia(){
			var defined;
			for( var i = 0; i < sheets.length; i++ ){
				if( sheets[ i ].href && sheets[ i ].href.indexOf( href ) > -1 ){
					defined = true;
				}
			}
			if( defined ){
				ss.media = media || "all";
			}
			else {
				setTimeout( toggleMedia );
			}
		}

		toggleMedia();
		return ss;
	}

	/* Load custom fonts
		*/
	var fontsKey = "https://fonts.googleapis.com/css?family=PT+Sans:400,700",
			printKey = "public/css/print.min.css";
	
	loadCSS( fontsKey );
	loadCSS( printKey, false, "print" );

	// Use Font Face Observer to add class when loaded
  var font = new FontFaceObserver('PT Sans', {
	  weight: 400
	});

	font.load().then(function () {
  	document.documentElement.classList.add( 'fonts-loaded' );
	});

}( window, document ) );

// Search form events

( function( window, document, undefined ) {
	
	document.addEventListener( 'submit', function(e) {
		if ( !e.target || e.target.id != 'search-form') {
			return;
		}

		var $form = e.target,
				$input = $form.querySelector( '#search' );

		// Stop users submitting blank search if required attr isn't implemented
		// No implementation in IE8, IE9 and Safari (so load everywhere)
		if ( 0 === $input.value.length ) {

			var $error = document.getElementById( 'search-error' );

			if ( null === $error ) {
				$error = document.createElement('p');
				$error.classList.add( 'error', 'small' );
				$error.setAttribute( 'id', 'search-error' );
				$error.setAttribute( 'aria-live', 'polite' );
			} 

			$error.innerHTML = 'You must enter some terms to search for.';

			$form.classList.add( 'shake' );
			$form.parentNode.appendChild( $error );

			// Reset once animation finishes
			setTimeout(function() {
				$form.classList.remove( 'shake' );
			}, 1000);

			// Focus input ready for entry
			$input.focus();

			e.preventDefault();
	    e.stopPropagation();
	    return false;

		// Load the results URL via AJAX - only if the History API is supported
		// Want to make sure we get the correct URL for bookmarking, sharing etc
		} else {

			if ( window.history && window.history.pushState ) {

				var requestURL = $form.getAttribute( 'action' ) + '?' + $input.getAttribute( 'name' ) + '=' + $input.value,
					$skeletonTemplate = document.getElementById( 'skeleton' ),
					skeletons = '',
					xhr = ajax( requestURL + '&expanded=1' );

				// Replace the history state
				history.pushState( {}, $input.value + siteName, requestURL );
				document.querySelector( 'title' ).innerHTML = $input.value + siteName;

				// Create skeleton screens
				for (var i = 0; i < 5; i++) {
					skeletons += $skeletonTemplate.innerHTML.substring( 2, $skeletonTemplate.innerHTML.length - 2 );
				}

				// Only add skeleton screens if the AJAX hasn't returned
				if ( !(4 == xhr.readyState && 200 == xhr.status) ) {
					document.getElementById( 'results-title' ).innerHTML = 'Finding latest news&hellip;';
					document.getElementById( 'feed-wrapper' ).innerHTML = skeletons;
				  document.dispatchEvent( new Event('DOMContentReplaced') );
				}

				e.preventDefault();
		    e.stopPropagation();
		    return false;

			}

		}

	} );

	if ( window.history && window.history.pushState ) {

		document.addEventListener( 'click', function(e) {
			
			if ( !e.target || e.target.parentNode.getAttribute('data-type') != 'search-tag') {
				return;
			}		

			var requestURL = e.target.parentNode.href,
					title = e.target.textContent.replace(/^\s/, '').replace(/\s$/, '');
			
			ajax( requestURL + '&expanded=1' );

			showSkeletons();

			// Replace the history state
			history.pushState( { url: requestURL, title: title + siteName }, title + siteName, requestURL );
			document.querySelector( 'title' ).innerHTML = title + siteName;

			e.preventDefault();
	    e.stopPropagation();
	    return false;

		} );

		window.addEventListener( 'popstate', function( e ) {
			console.log( e );
			var requestURL = '';

			document.querySelector( 'title' ).innerHTML = e.state.title;

			// This was a search page, show the skeletons
			if ( -1 !== e.state.url.indexOf( 'search=' ) ) {
				requestURL = e.state.url + '&expanded=1';
				showSkeletons();
			} else {
				requestURL = e.state.url + '?expanded=1';
			}
			
			ajax( requestURL );

		} );

		// Store the intial state
		history.replaceState( { url: location.href, title: document.title }, document.title, location.href );

	}

}( window, document ) );

// Transfer focus from skip links to their target elements

( function( window, document, undefined ) {
			
	var $skipLink = document.getElementById('skip-to-content');

	$skipLink.addEventListener( 'click', function( e ) {
    var $target = document.getElementById( this.getAttribute( 'href' ).substring( 1 ) );
		
    if ( null !== $target ) {
    	$target.focus();
    }
		
    e.stopPropagation();
	} );

}( window, document ) );
