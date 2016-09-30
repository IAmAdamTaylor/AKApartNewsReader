// Small container query implementation

( function( window, document, undefined ) {

	var minWidth = 400,
			$allItems = document.querySelectorAll( '.js-feed-item' ),
			$monitor,

			/**
			 * Check the element being monitored and update classes if needed.
			 */
			checkMonitor = function() {
				if ( null !== $monitor ) {

					if ( $monitor.offsetWidth > minWidth ) {
						$monitor.classList.add( 'one' );
					} else {
						$monitor.classList.remove( 'one' );
					}

				}
			},

			/**
			 * Update the $monitor variable when the DOM content changes.
			 */
			updateMonitor = function() {
				$allItems = document.querySelectorAll( '.js-feed-item' );

				// Don't monitor items unless there are at least 5
				if ( $allItems.length < 5 ) {
					$monitor = null;
					return;
				}

				// Only check the last child
				$monitor = $allItems[ $allItems.length - 1 ];

				// Check the item now to make sure it's initial state is good
				checkMonitor();
			};

	if ( $allItems.length ) {

		// Initial check
		updateMonitor();

		// Listen out for AJAX reloading the page
		document.addEventListener( 'DOMContentReplaced', updateMonitor );

		// If we have elements to monitor, then attach the resize event
		window.addEventListener( 'resize', throttle( checkMonitor, 150 ) );

	}
	
}( window, document ) );
