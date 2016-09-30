<?php

namespace Feed;

/**
 * Feed\ReaderInterface
 * The interface to implement in order to read external RSS feeds.
 */
interface ReaderInterface 
{
	/**
	 * Get a set of items from the feed.
	 * @param  integer $paged The page number to get.
	 * @return array         
	 */
	public function getItems( $paged );

	/**
	 * Get a set of unique items from the feed.
	 * An item is considered unique by it's permalink.
	 * @param  integer $paged The page number to get.
	 * @return array
	 */
	public function getUniqueItems( $paged );

	/**
	 * Enable page view mode.
	 * @param  boolean $flag 
	 */
	public function enablePaging( $flag );
}
