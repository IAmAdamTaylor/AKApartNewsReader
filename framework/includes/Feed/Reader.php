<?php

namespace Feed;
use Feed\Item as FeedItem;
use SimplePie_Autoloader;
use SimplePie;

class Reader implements ReaderInterface
{
	/**
	 * The cache folder.
	 * @var string
	 */
	var $_cacheFolder;

	/**
	 * The feed instance.
	 * @var SimplePie
	 */
	var $_feed;

	/**
	 * Whether to return paged results or not.
	 * Paged results are designed to be read in chunks.
	 *
	 * True to return paged results, false to return all results in one go
	 * Default is false
	 * @var boolean
	 */
	var $_usePaging;

	/**
	 * The maximum number of items to be returned in one page call.
	 * @var integer
	 */
	const PAGE_SIZE = 100;

	/**
	 * The maximum amount of items to return from each feed when using multiple feed URLs.
	 * @var integer
	 */
	const MULTIFEED_ITEM_LIMIT = 100;

	/**
	 * The cache location relative to the base cache folder.
	 * @var string
	 */
	const CACHE_LOCATION = 'simplepie/';
	
	function __construct()
	{
		$this->_cacheFolder = CACHE_PATH . self::CACHE_LOCATION;
		$this->_usePaging = false;
		
		// Require the SimplePie Autoloader
		require_once INCLUDES_PATH . '/SimplePie/autoloader.php';

		// Create SimplePie feed instance
		$this->_feed = new SimplePie();
		$this->_configureFeed();

		$this->_feed->init();

		// Send the necessary HTTP headers for the feed
		$this->_feed->handle_content_type();
	}

	public function getItems( $paged = 1 )
	{
		$start = 0;
		$length = 0;

		if ( $this->_usePaging ) {
			$start = ( $paged * self::PAGE_SIZE ) - self::PAGE_SIZE;
			$length = self::PAGE_SIZE;
		}

		$items = $this->_feed->get_items( $start, $length );

		// Parse each item into a separate smaller class, so that we can cache it
		foreach ($items as &$item) {
			$item = new FeedItem( $item );
			unset( $item );
		}

		return $items;
	}

	public function getUniqueItems( $paged = 1 )
	{
		$items = $this->getItems( $paged );

		// Filter to unique items
		$unique_items = array();

		foreach ($items as $item) {
			
			$item_exists = false;

			if ( !empty( $unique_items ) ) {
				
				foreach ($unique_items as $unique_item) {
					if ( $unique_item->isEqual( $item ) ) {
						$item_exists = true;
						break;
					}
				}

			}

			if ( !$item_exists ) {
				$unique_items[] = $item;
			}

		}

		return $unique_items;
	}

	public function enablePaging( $flag )
	{
		// !!, Convert the flag to an equivalent boolean value
		$this->_usePaging = !!$flag;
	}

	/**
	 * Configure the feed instance.
	 */
	private function _configureFeed()
	{
		$this->_feed->enable_cache();
		$this->_feed->enable_order_by_date();
		$this->_setCacheDuration();
		$this->_feed->set_cache_location( $this->_cacheFolder );
		$this->_feed->set_item_limit( self::MULTIFEED_ITEM_LIMIT );

		// Strip any HTML tags found in the feed
		$this->_feed->strip_htmltags();

		// Add the feeds we want to process
		$this->_setFeeds();
	}

	/**
	 * Set the array of feeds that we want to process.
	 */
	private function _setFeeds()
	{
		$feeds = array(
			// BBC Top Stories
			'http://feeds.bbci.co.uk/news/rss.xml',
			// BBC World News
			'http://feeds.bbci.co.uk/news/world/rss.xml',
			// BBC Tech News
			'http://feeds.bbci.co.uk/news/technology/rss.xml',
			// Guardian Most Popular
			'https://www.theguardian.com/uk/rss',
			// Guardian World News
			'https://www.theguardian.com/world/rss',
			// Guardian Tech News
			'https://www.theguardian.com/uk/technology/rss',
		);

		$this->_feed->set_feed_url( $feeds );
	}

	/**
	 * Set the length we want to cache the feed for, in seconds.
	 * @return integer
	 */
	private function _setCacheDuration()
	{
		// 1 day in seconds
		$duration = 60 * 60 * 24;
		$this->_feed->set_cache_duration( $duration );
	}
}
