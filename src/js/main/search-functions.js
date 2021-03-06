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
