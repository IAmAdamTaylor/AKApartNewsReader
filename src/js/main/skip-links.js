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
