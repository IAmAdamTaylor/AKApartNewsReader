<?php

namespace Cache;

/**
 * Cache\ControllerInterface
 * The interface a class making use of the cache should implement.
 */
interface ControllerInterface
{
	/**
	 * Get a value from the cache.
	 * @param  string $key 
	 * @return mixed
	 */
	public function get( $key );

	/**
	 * Store a value in the cache.
	 * @param  string $key   
	 * @param  mixed $value 
	 */
	public function store( $key, $value );

	/**
	 * Remove a value from the cache.
	 * @param  string $key 
	 */
	public function invalidate( $key );
}
