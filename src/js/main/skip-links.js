// Transfer focus from skip links to their target elements

( function( window, document, undefined ) {
			
	var $skipLink = document.getElementById('skip-to-content');

	$skipLink.addEventListener('click', transferFocus);

	function transferFocus( e ) {
    var $target = document.getElementById( this.getAttribute( 'href' ).substring( 1 ) );
		
    if ( $target.length ) {
    	$target.focus();
    }
		
    e.stopPropagation();
	}

} )( window, document );
