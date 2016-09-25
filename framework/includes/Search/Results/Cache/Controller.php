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

	/**
	 * The cache location relative to the base cache folder.
	 * @var string
	 */
	const CACHE_LOCATION = 'results/';

	public function __construct() 
	{
		$this->_cacheFolder = CACHE_PATH . self::CACHE_LOCATION;
	}

	/**
	 * Get the results from the cache file.
	 * @param  string $key The terms searched for.
	 * @return array       An array of SimplePie_Item objects.
	 */
	public function get( $key ) 
	{
		date_default_timezone_set('Europe/London');
		$cacheFile = $this->_getCacheFilePath( $key );

		// Check the cache file exists
		if ( !is_readable( $cacheFile ) ) {
			return false;
		}

		// Get the contents
		$results = json_decode( file_get_contents( $cacheFile ), true );

		if ( date('U') >= $results['expires'] ) {
			$this->invalidate( $key );
			return false;
		}

		return $results['value'];
	}

	/**
	 * Store a set of results into the cache.
	 * @param  string $key   The terms searched for.
	 * @param  array $value  An array of SimplePie_Item objects.
	 * @return self 				 For chaining
	 */
	public function store( $key, $value ) 
	{
		date_default_timezone_set('Europe/London');
		$cacheFile = $this->_getCacheFilePath( $key );

		// Add an expires timestamp to the cache
		$value = array( 
			'expires' => date('U') + $this->_getExpiryPeriod(),
			'value' => $value,
		);

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

		// Check the cache file exists
		if ( !is_readable( $cacheFile ) ) {
			return false;
		}

		unlink( $cacheFile );

		return $this;
	}

	private function _getExpiryPeriod()
	{
		// 2 hours in seconds
		return 2 * 60 * 60;
	}

	/**
	 * Get the full file path from a key.
	 * @param  string $key The name of the file.
	 * @return string      The full file path.
	 */
	private function _getCacheFilePath( $key ) 
	{
		$key = $this->_sanitiseFileName( $key );
		return $this->_cacheFolder . $key . '.json';
	}

	private function _sanitiseFileName( $file_name ) 
	{
		$file_name = trim( $file_name );
		$file_name = strtolower( $file_name );
		$file_name = str_replace( ' ', '_', $file_name );
		$file_name = preg_replace( '/[^0-9a-z-_.]/', '', $file_name );

		return trim( $file_name );
	}
}
