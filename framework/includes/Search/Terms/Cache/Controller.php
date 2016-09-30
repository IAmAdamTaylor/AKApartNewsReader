<?php

namespace Search\Terms\Cache;
use Cache\ControllerInterface as CacheInterface;

/**
 * Search\Terms\Cache\Controller
 * Cache handler for the search terms.
 * The cache will be an array containing each term and the amount of times that term has been searched for, like:
 * array(
 * 		'searched+for+this' => 2,
 * 		'another+search' => 10,
 * 		'test+search' => 20,
 * );
 */
class Controller implements CacheInterface
{
	/**
	 * The file that this cache controller writes to.
	 * @var string
	 */
	var $_cacheFile;

	const CACHE_LOCATION = 'terms.json';
	const CACHE_LIMIT = 30;

	public function __construct() {
		$this->_cacheFile = CACHE_BASE_PATH . self::CACHE_LOCATION;
	}

	/**
	 * Get a value from the cache.
	 * @param  string $key Optional, leave blank to get all terms.
	 * @return array       An array of terms.
	 */
	public function get( $key = '' ) 
	{
		// Check the cache file exists
		if ( !is_readable( $this->_cacheFile ) ) {
			return false;
		}

		// Get the contents
		$terms = json_decode( file_get_contents( $this->_cacheFile ), true );

		// If we are looking for a specific key, return only it's count
		if ( '' !== $key ) {
			
			if ( isset( $terms[ $key ] ) ) {
				$terms = $terms[ $key ];
			} else {
				$terms = false;
			}

		}

		return $terms;
	}

	/**
	 * Store a value in the cache.
	 * @param  string $key   
	 * @param  integer $value Optional, if passed it sets the amount exactly, if not the current value is incremented.
	 * @return $this
	 */
	public function store( $key, $value = null ) 
	{
		// Get the existing cache
		$terms = $this->get();

		// If a value is passed, set the key to that specific value 
		if ( isset( $value ) ) {
			
			$terms[ $key ] = $value;

		} else {
			
			// Add the key if new, increment it's value if existing key
			if ( isset( $terms[ $key ] ) && $terms[ $key ] > 0 ) {
				$terms[ $key ]++;
			} else {
				$terms[ $key ] = 1;
			}
			
		}

		// Limit the number of terms being stored
		// Only keep the top terms
		arsort( $terms );
		$terms = array_slice( $terms, 0, self::CACHE_LIMIT, true );

		// Update the cache file
		file_put_contents( $this->_cacheFile , json_encode( $terms ) );

		return $this;
	}

	/**
	 * Remove a value from the cache.
	 * @param  string $key
	 * @return $this 
	 */
	public function invalidate( $key ) 
	{
		// Get the existing cache
		$terms = $this->get();

		// Unset the key, if it exists
		if ( isset( $terms[ $key ] ) ) {
			unset( $terms[ $key ] );
		}

		// Update the cache file
		file_put_contents( $this->_cacheFile , json_encode( $terms ) );

		return $this;
	}
}
