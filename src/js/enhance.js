/*! EnhanceJS: a progressive enhancement boilerplate. Copyright 2014 @scottjehl, Filament Group, Inc. Licensed MIT */
(function( window, undefined ) {

	// Enable JS strict mode
	"use strict";

  var setTimeout = window.setTimeout;

	// Define some variables to be used throughout this file
	var doc = window.document,
		docElem = doc.documentElement,
		head = doc.head || doc.getElementsByTagName( "head" )[ 0 ],
		// this references a meta tag's name whose content attribute should define the path to the custom fonts file for the site (delivered to qualified browsers)
		fontsKey = "https://fonts.googleapis.com/css?family=PT+Sans:400,700";

	/* Some commonly used functions - delete anything you don't need! */

	// loadCSS: load a CSS file asynchronously. Included from https://github.com/filamentgroup/loadCSS/
	function loadCSS( href, before, media ){
		// Arguments explained:
		// `href` is the URL for your CSS file.
		// `before` optionally defines the element we'll use as a reference for injecting our <link>
		// By default, `before` uses the first <script> element in the page.
		// However, since the order in which stylesheets are referenced matters, you might need a more specific location in your document.
		// If so, pass a different reference element to the `before` argument and it'll insert before that instead
		// note: `insertBefore` is used instead of `appendChild`, for safety re: http://www.paulirish.com/2011/surefire-dom-element-insertion/
		var ss = window.document.createElement( "link" );
		var ref = before || window.document.getElementsByTagName( "script" )[ 0 ];
		var sheets = window.document.styleSheets;
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
		We prefer to load fonts asynchronously so that they do not block page rendering.
		To do this, a meta tag with a name matching the fontsWoffKey should have a content attribute referencing the path to this fonts file.
		NOTE: You may want to have logic here to choose between one of many font formats before loading it.
			For example, we often load WOFF, Truetype, or SVG. If so, just define meta tags for each
		*/
	if( fontsKey ){
		loadCSS( fontsKey );
	}

	// Font Face Observer
  var font = new FontFaceObserver('PT Sans', {
	  weight: 400
	});

	font.load().then(function () {
	  if ( "undefined" !== typeof docElem.classList ) {
    	docElem.classList.add( 'fonts-loaded' );
  	}
	});

}( this ));
