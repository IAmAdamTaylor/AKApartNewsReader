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

		}

	} );

}( window, document ) );
