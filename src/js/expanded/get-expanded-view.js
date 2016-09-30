// AJAX wrapper to get the expanded view if a page supports it

( function( window, document, undefined ) {

	var $main = document.querySelector( 'main' ),
			hasExpanded = null !== document.querySelector( '.has-expanded-view' );

	if ( hasExpanded && null !== $main ) {

		// This page has an expanded view
		ajax( pageBaseUrl + 'expanded=1' );

	}
	
}( window, document ) );
