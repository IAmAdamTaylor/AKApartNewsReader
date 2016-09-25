// Transfer focus from skip links to their target elements

( function( window, document, undefined ) {
			
	var $skipLink = document.getElementById('skip-to-content');

	$skipLink.addEventListener('click', transferFocus);

	function transferFocus( e ) {
		console.log(this, e);
    var target = this.getAttribute( 'href' ),
    		$target = document.getElementById( target.substring( 1 ) );
		
		console.log( target, $target );
    if ( $target.length ) {
    	$target.focus();
    }
		
    e.stopPropagation();
	}

} )( window, document );
