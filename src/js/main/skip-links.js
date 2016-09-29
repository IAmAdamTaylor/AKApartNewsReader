// Transfer focus from skip links to their target elements

( function( window, document, undefined ) {
			
	var $skipLink = document.getElementById('skip-to-content');

	$skipLink.addEventListener('click', transferFocus);

	/**
	 * Transfer focus to an anchor element's targeted href.
	 * @param  Element e 
	 */
	function transferFocus( e ) {
    var $target = document.getElementById( this.getAttribute( 'href' ).substring( 1 ) );
		
    if ( null !== $target ) {
    	$target.focus();
    }
		
    e.stopPropagation();
	}

}( window, document ) );
