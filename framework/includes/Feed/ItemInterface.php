<?php

namespace Feed;
use SimplePie_Item;

interface ItemInterface
{
	public function mapSimplePie_Item( SimplePie_Item $item );
	public function mapArray( array $item );
	
	public function isEqual( Item $item );
}
