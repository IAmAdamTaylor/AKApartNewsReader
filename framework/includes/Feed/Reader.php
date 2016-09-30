<?php

namespace Feed;
use Feed\Item as FeedItem;
use Cache\Manager as CacheManager;
use SimplePie_Autoloader;
use SimplePie;

/**
 * Feed\Reader
 * Reads in the RSS feeds and converts the items to Feed\Item objects.
 */
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
	
	/**
	 * Constructor.
	 * Sets up the SimplePie instance ready to read.
	 */
	function __construct()
	{
		$cacheManager = CacheManager::instance();

		// If the cache folder does not exist, create it
		if ( !$cacheManager->doesFolderExist( self::CACHE_LOCATION ) ) {
			$cacheManager->createFolder( untrailingslashit( self::CACHE_LOCATION ) );
		}

		$this->_cacheFolder = trailingslashit( CACHE_BASE_PATH ) . self::CACHE_LOCATION;

		$this->_usePaging = false;
		
		// Require the SimplePie Autoloader
		require_once trailingslashit( INCLUDES_PATH ) . '/SimplePie/autoloader.php';

		// Create SimplePie feed instance
		$this->_feed = new SimplePie();
		$this->_configureFeed();

		$this->_feed->init();

		// Send the necessary HTTP headers for the feed
		$this->_feed->handle_content_type();
	}

	/**
	 * Get a set of items from the feed.
	 * @param  integer $paged The page number to get.
	 * @return array         
	 */
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

	/**
	 * Get a set of unique items from the feed.
	 * An item is considered unique by it's permalink.
	 * @param  integer $paged The page number to get.
	 * @return array
	 */
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

	/**
	 * Enable page view mode.
	 * @param  boolean $flag 
	 */
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
			// Guardian World News
			'https://www.theguardian.com/world/rss',
			// The Independant World
			'http://www.independent.co.uk/news/world/rss',
			// The Times World
			'http://www.thetimes.co.uk/tto/news/world/rss',
			// CNN World News
			'http://rss.cnn.com/rss/edition_world.rss',
		);

		$this->_feed->set_feed_url( $feeds );
	}

	/**
	 * Set the length we want to cache the feed for, in seconds.
	 */
	private function _setCacheDuration()
	{
		// 1 day in seconds
		$duration = 60 * 60 * 24;
		$this->_feed->set_cache_duration( $duration );
	}
}
