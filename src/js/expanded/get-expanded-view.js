( function( window, document, undefined ) {

	var $main = document.querySelector( 'main' ),
			hasExpanded = null !== document.querySelector( '.has-expanded-view' );

	if ( hasExpanded && null !== $main ) {

		// This page has an expanded view
		var xhr = new XMLHttpRequest();
		xhr.open( 'GET', pageBaseUrl + 'expanded=1' );
		xhr.onreadystatechange = function() {
	    if ( 4 == xhr.readyState && 200 == xhr.status ) {
	    	
	    	// Good response, parse for main content and return
	    	var $wrapper = document.createElement( 'div' );
	    	$wrapper.innerHTML = xhr.responseText;

	    	var $mainResponse = $wrapper.querySelector( 'main' );
	    	console.log( xhr.readyState, xhr.status, $mainResponse );

	    	if ( null !== $mainResponse ) {
	    		$main.innerHTML = $mainResponse.innerHTML;
	    	}

	    }
		};
		xhr.send();

	}
	
}( window, document ) );
