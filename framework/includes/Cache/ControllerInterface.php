<?php

namespace Cache;

interface ControllerInterface
{
	public function get( $key );
	public function store( $key, $value );
	public function invalidate( $key );
}
