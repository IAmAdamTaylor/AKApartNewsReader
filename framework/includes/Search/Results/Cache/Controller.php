<?php

namespace Search\Results\Cache;
use Search\CacheInterface;

/**
 * Cache handler for the search results.
 * Cache will be an array of SimplePie_Item objects.
 */
class Controller implements CacheInterface
{
	/**
	 * The cache folder.
	 * @var string
	 */
	var $_cacheFolder;

	const CACHE_LOCATION = 'results/';

	public function __construct() {
		$this->_cacheFolder = CACHE_PATH . self::CACHE_LOCATION;
	}

	/**
	 * Get the results from the cache file.
	 * @param  string $key The terms searched for.
	 * @return array       An array of SimplePie_Item objects.
	 */
	public function get( $key ) 
	{
		$cacheFile = $this->_getCacheFilePath( $key );

		// Check the cache file exists
		if ( !is_readable( $cacheFile ) ) {
			return false;
		}

		// Get the contents
		$results = json_decode( file_get_contents( $cacheFile ), true );

		return $results;
	}

	/**
	 * Store a set of results into the cache.
	 * @param  string $key   The terms searched for.
	 * @param  array $value  An array of SimplePie_Item objects.
	 * @return self 				 For chaining
	 */
	public function store( $key, $value ) 
	{
		$cacheFile = $this->_getCacheFilePath( $key );

		// Update the cache file
		file_put_contents( $cacheFile , json_encode( $value ) );

		return $this;
	}

	/**
	 * Remove a specific cache file.
	 * @param  string $key   The terms searched for.
	 * @return self 				 For chaining
	 */
	public function invalidate( $key ) 
	{
		$cacheFile = $this->_getCacheFilePath( $key );

		unlink( $cacheFile );

		return $this;
	}

	/**
	 * Get the full file path from a key.
	 * @param  string $key The name of the file.
	 * @return string      The full file path.
	 */
	private function _getCacheFilePath( $key ) {
		$key = $this->_sanitiseFileName( $key );
		return $this->_cacheFolder . $key . '.json';
	}

	private function _sanitiseFileName( $file_name ) {
		$file_name = trim( $file_name );
		$file_name = strtolower( $file_name );
		$file_name = str_replace( ' ', '_', $file_name );
		$file_name = preg_replace( '/[^0-9a-z-_.]/', '', $file_name );

		return trim( $file_name );
	}
}
