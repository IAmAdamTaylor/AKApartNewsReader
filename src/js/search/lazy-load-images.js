( function( window, document, undefined ) {
	var $elements = document.querySelectorAll('.js-lazy-load');

	if ( $elements.length ) {
		for (var i = 0, len = $elements.length; i < len; i++) {
			var _this = $elements[i];
			
			insertImage( _this );
			_this.style.paddingBottom = 0;

			_this.parentNode.classList.remove( 'feed-item__inner--no-image' );
		}
	}

	function insertImage( $element ) {
		var $img = document.createElement('img'),
				attributes = JSON.parse( $element.getAttribute('data-image-object') );

		for ( var key in attributes ) {
			if ( attributes.hasOwnProperty( key ) ) {
		    $img.setAttribute( key, attributes[ key ] );
			}
	  }

	  $element.appendChild( $img );
	}
} )( window, document );
