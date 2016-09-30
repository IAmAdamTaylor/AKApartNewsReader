/*! EnhanceJS: a progressive enhancement boilerplate. Copyright 2014 @scottjehl, Filament Group, Inc. Licensed MIT */
( function( window, document, undefined ) {

	// loadCSS: load a CSS file asynchronously. Included from https://github.com/filamentgroup/loadCSS/
	function loadCSS( href, before, media ){
		// Arguments explained:
		// `href` is the URL for your CSS file.
		// `before` optionally defines the element we'll use as a reference for injecting our <link>
		// By default, `before` uses the first <script> element in the page.
		// However, since the order in which stylesheets are referenced matters, you might need a more specific location in your document.
		// If so, pass a different reference element to the `before` argument and it'll insert before that instead
		// note: `insertBefore` is used instead of `appendChild`, for safety re: http://www.paulirish.com/2011/surefire-dom-element-insertion/
		var ss = document.createElement( "link" );
		var ref = before || document.getElementsByTagName( "script" )[ 0 ];
		var sheets = document.styleSheets;
		ss.rel = "stylesheet";
		ss.href = href;
		// temporarily, set media to something non-matching to ensure it'll fetch without blocking render
		ss.media = "only x";
		// inject link
		ref.parentNode.insertBefore( ss, ref );
		// This function sets the link's media back to `all` so that the stylesheet applies once it loads
		// It is designed to poll until document.styleSheets includes the new sheet.
		function toggleMedia(){
			var defined;
			for( var i = 0; i < sheets.length; i++ ){
				if( sheets[ i ].href && sheets[ i ].href.indexOf( href ) > -1 ){
					defined = true;
				}
			}
			if( defined ){
				ss.media = media || "all";
			}
			else {
				setTimeout( toggleMedia );
			}
		}

		toggleMedia();
		return ss;
	}

	/* Load custom fonts
		*/
	var fontsKey = "https://fonts.googleapis.com/css?family=PT+Sans:400,700",
			printKey = "public/css/print.min.css";
	
	loadCSS( fontsKey );
	loadCSS( printKey, false, "print" );

	// Use Font Face Observer to add class when loaded
  var font = new FontFaceObserver('PT Sans', {
	  weight: 400
	});

	font.load().then(function () {
  	document.documentElement.classList.add( 'fonts-loaded' );
	});

}( window, document ) );
