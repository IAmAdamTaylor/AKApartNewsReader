<?php

namespace Search;

interface CacheInterface
{
	public function get( $key );
	public function store( $key, $value );
	public function invalidate( $key );
}
