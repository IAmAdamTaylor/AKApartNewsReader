<?php

namespace Feed;
use SimplePie_Item;

/**
 * Feed\ItemInterface
 * The item for implementing a Feed\Item
 */
interface ItemInterface
{
	/**
	 * Map a SimplePie_Item to properties on this object.
	 * @param  SimplePie_Item $item
	 * @return $this
	 */
	public function mapSimplePie_Item( SimplePie_Item $item );

	/**
	 * Map an array to properties on this object.
	 * @param  array $item
	 * @return $this
	 */
	public function mapArray( array $item );
	
	/**
	 * Check if 2 feed items are equal to each other.
	 * @param  Feed\Item $item The feed item to compare with this one.
	 * @return boolean
	 */
	public function isEqual( Item $item );

	/**
	 * Get a machine readable version of the date.
	 * Useful for bots and spiders to read.
	 * @return string 
	 */
	public function getMachineReadableDate();
	
	/**
	 * Get the date relative to now.
	 * @return string
	 */
	public function getRelativeDate();
	
	/**
	 * Get the number of days since the news item was published.
	 * @return integer
	 */
	public function getDaysSincePublished();
}
