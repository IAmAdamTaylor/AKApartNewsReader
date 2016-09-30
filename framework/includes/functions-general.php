<?php

/**
 * Site wide, general use functions.
 */

/**
 * Recursive rmdir() function.
 * Removes the folder and any subfolders or files contained.
 * @param  string $src The folder path to remove.
 */
function rrmdir($src) {
  $dir = opendir($src);
  while(false !== ( $file = readdir($dir)) ) {
    if (( $file != '.' ) && ( $file != '..' )) {
      $full = $src . '/' . $file;
      if ( is_dir($full) ) {
        rrmdir($full);
      }
      else {
        unlink($full);
      }
    }
  }
  closedir($dir);
  rmdir($src);
}

/**
 * Send the HTTP headers to redirect a page to another, and then end the current process.
 * @param  string $url The absolute URL to redirect to. Must be an absolute path.
 */
function redirect( $url, $permanent = false ) {
	if ( $permanent ) {
		header('HTTP/1.1 301 Moved Permanently');
	} else {
		header('HTTP/1.1 302 Found');
	}

  header('Location: ' . $url);
  die();
}

/**
 * Fix `$_SERVER` variables for various setups.
 * @author WordPress wp-includes/load.php
 */
function fix_server_vars() {
	global $PHP_SELF;

	$default_server_values = array(
		'SERVER_SOFTWARE' => '',
		'REQUEST_URI' => '',
	);

	$_SERVER = array_merge( $default_server_values, $_SERVER );

	// Fix for IIS when running with PHP ISAPI
	if ( empty( $_SERVER['REQUEST_URI'] ) || ( PHP_SAPI != 'cgi-fcgi' && preg_match( '/^Microsoft-IIS\//', $_SERVER['SERVER_SOFTWARE'] ) ) ) {

		// IIS Mod-Rewrite
		if ( isset( $_SERVER['HTTP_X_ORIGINAL_URL'] ) ) {
			$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
		}
		// IIS Isapi_Rewrite
		elseif ( isset( $_SERVER['HTTP_X_REWRITE_URL'] ) ) {
			$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
		} else {
			// Use ORIG_PATH_INFO if there is no PATH_INFO
			if ( !isset( $_SERVER['PATH_INFO'] ) && isset( $_SERVER['ORIG_PATH_INFO'] ) )
				$_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];

			// Some IIS + PHP configurations puts the script-name in the path-info (No need to append it twice)
			if ( isset( $_SERVER['PATH_INFO'] ) ) {
				if ( $_SERVER['PATH_INFO'] == $_SERVER['SCRIPT_NAME'] )
					$_SERVER['REQUEST_URI'] = $_SERVER['PATH_INFO'];
				else
					$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];
			}

			// Append the query string if it exists and isn't null
			if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
				$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
			}
		}
	}

	// Fix for PHP as CGI hosts that set SCRIPT_FILENAME to something ending in php.cgi for all requests
	if ( isset( $_SERVER['SCRIPT_FILENAME'] ) && ( strpos( $_SERVER['SCRIPT_FILENAME'], 'php.cgi' ) == strlen( $_SERVER['SCRIPT_FILENAME'] ) - 7 ) )
		$_SERVER['SCRIPT_FILENAME'] = $_SERVER['PATH_TRANSLATED'];

	// Fix for Dreamhost and other PHP as CGI hosts
	if ( strpos( $_SERVER['SCRIPT_NAME'], 'php.cgi' ) !== false )
		unset( $_SERVER['PATH_INFO'] );

	// Fix empty PHP_SELF
	$PHP_SELF = $_SERVER['PHP_SELF'];
	if ( empty( $PHP_SELF ) )
		$_SERVER['PHP_SELF'] = $PHP_SELF = preg_replace( '/(\?.*)?$/', '', $_SERVER["REQUEST_URI"] );
}

/**
 * Remove any trailing slashes from a string.
 * @param  string $string
 * @return string
 */
function untrailingslashit( $string ) {
  return rtrim( $string, '/\\' );
}

/**
 * Makes sure that a string has a trailing slash.
 * @param  string $string
 * @return string
 */
function trailingslashit( $string ) {
  return untrailingslashit( $string ) . '/';
}

/**
 * Get the singular or plural form based on the value.
 * @param  string $singular 
 * @param  string $plural   
 * @param  integer $value    
 * @return string           
 */
function _n( $singular, $plural, $value ) {
	if ( 1 == $value ) {
		return $singular;
	}

	return $plural;
}

/**
 * Uppercase all words, except for certain ones.
 * @param  string $value The string with words to uppercase.
 * @return string        
 */
function maybeUcwords( $value ) {
	// Uppercase the words of the value passed if it doesn't meet the conditions
	$specific_case_words = array(
		'iphone' => 'iPhone',
		'ipad' => 'iPad',
		'iwatch' => 'iWatch',
		'isense' => 'iSense',
		'curl' => 'cURL',
	);

	// Get each word from value
	$value_parts = explode( ' ', $value );
	foreach ($value_parts as $key => &$value_part) {

		// Check if the exact word is in the array
		if ( isset( $specific_case_words[ $value_part ] ) ) {

			$value_part = $specific_case_words[ $value_part ];

		// Else, uppercase the first letter
		} else {
			
			$value_part = ucfirst( $value_part );

		}
		
		// Unset by ref var
		unset( $value_part );

	}

	// Combine the words back together
	return implode( ' ', $value_parts );
}

/**
 * Checks that an asset exists and if it does, requires it.
 * @param  string $path The path to the asset.
 */
function requireAsset( $path ) {
	if ( file_exists( $path ) && is_readable( $path ) ) {
		require_once $path;
	}
}

/**
 * Get the current URL path for JavaScript to call AJAX requests against.
 * @return string
 */
function getScriptPath() {
	$url_parts = parse_url( $_SERVER['REQUEST_URI'] );

	$path = basename( $url_parts['path'] ) . '?';
	if ( isset( $url_parts['query'] ) && '' !== $url_parts['query'] ) {
		$path .= $url_parts['query'];
	}

	return $path;
}

/**
 * Check if a page has an expanded view.
 * @param  WebApp\Page\ViewInterface $view The view for the page.
 * @return boolean
 */
function supportsExpandedView( $view ) {
	return
		'home/success.php' === $view->getTemplate() ||
		'about.php' === $view->getTemplate()
	;
}
