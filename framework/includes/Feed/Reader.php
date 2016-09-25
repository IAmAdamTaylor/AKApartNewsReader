<?php

namespace Feed;
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
	 * The maximum number of items to be returned in one page call.
	 * @var integer
	 */
	const PAGE_SIZE = 50;

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
		$start = ( $paged * self::PAGE_SIZE ) - self::PAGE_SIZE;
		$length = self::PAGE_SIZE;

		return $this->_feed->get_items( $start, $length );
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

		// Add the feeds we want to process
		$this->_setFeeds();
	}

	/**
	 * Set the array of feeds that we want to process.
	 */
	private function _setFeeds()
	{
		$feeds = array(
			'http://feeds.bbci.co.uk/news/world/rss.xml',
		);
		// Fake it with one feed at the moment
		$feeds = 'http://feeds.bbci.co.uk/news/world/rss.xml';

		$this->_feed->set_feed_url( $feeds );
	}

	/**
	 * Set the length we want to cache the feed for, in seconds.
	 * @return integer
	 */
	private function _setCacheDuration()
	{
		// 2 hours in seconds
		$duration = 2 * 60 * 60;
		$this->_feed->set_cache_duration( $duration );
	}
}
