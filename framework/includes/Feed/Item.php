<?php

namespace Feed;
use RelativeDate\DateTime as RelativeDateTime;
use SimplePie_Item;
use StdClass;
use DateTimeZone;
use DateTime;

/**
 * Feed\Item
 * Structure to hold properties of a feed item.
 */
class Item implements ItemInterface
{
	/**
	 * Constructor.
	 * Maps any items passed, if their type is understood and standardises the data.
	 * @param mixed $item 
	 */
	function __construct( $item )
	{
		if ( is_a( $item , 'SimplePie_Item' ) ) {
			$this->mapSimplePie_Item( $item );
		}

		if ( is_array( $item ) ) {
			$this->mapArray( $item );
		}
		
		// Clone the properties and clean them for output
		$this->rawDescription = $this->description;
		$this->rawTitle = $this->title;

		// Strip any HTML tags found in the feed
		$this->title = strip_tags( $this->title );
		$this->title = str_replace( '&amp;apos;', '\'', $this->title );
		$this->title = str_replace( '&amp;', '&', esc_html( $this->title ) );

		// Replace line breaks with spaces before stripping description
		$this->description = str_replace( array( '</p><p>' ) , '. ', $this->description );
		$this->description = str_replace( array( '<br>', '<br/>', '<br />', '</p><p>' ) , ' ', $this->description );
		$this->description = strip_tags( $this->description );

		// Remove any read more, continue reading tags specific to each feed.
		$this->description = $this->_removeReadMore( $this->description );
		
		// Trim the description to a usable length
		$this->description = $this->_trimLength( $this->description );

		$this->description = str_replace( '&amp;', '&', esc_html( $this->description ) );
	}

	/**
	 * Map a SimplePie_Item to properties on this object.
	 * @param  SimplePie_Item $item
	 * @return $this
	 */
	public function mapSimplePie_Item( SimplePie_Item $item )
	{
		// Get the values we need from the SimplePie_Item and set them as properties
		$this->title = $item->get_title();
		$this->description = $item->get_description();
		$this->permalink = $item->get_permalink();
		$this->timestamp = $item->get_date('Y-m-d H:i:s');

		$imageData = $this->_getImageData( $item );

		$this->imageData = $imageData;
		$this->imageJSON = json_encode( $imageData );

		// Add the feed information as a generic structure
		$feed = $item->get_feed();

		$feedData = new StdClass();
		$feedData->name = $feed->get_title();
		$feedData->subscribeURL = $feed->subscribe_url();
		$feedData->baseURL = $feed->get_base();
		$feedData->displayBaseURL = $this->_formatBaseUrlForDisplay( $feedData->baseURL );

		$this->feedData = $feedData;

		return $this;
	}

	/**
	 * Map an array to properties on this object.
	 * @param  array $item
	 * @return $this
	 */
	public function mapArray( array $item )
	{
		$this->title = $item[ 'title' ];
		$this->description = $item[ 'description' ];
		$this->permalink = $item[ 'permalink' ];
		$this->timestamp = $item[ 'timestamp' ];

		$this->imageData = $item[ 'imageData' ];
		$this->imageJSON = json_encode( $item[ 'imageData' ] );

		// Add the feed information as a generic structure
		$feedData = (object)$item[ 'feedData' ];
		$this->feedData = $feedData;

		return $this;
	}

	/**
	 * Check if 2 feed items are equal to each other.
	 * @param  Feed\Item $item The feed item to compare with this one.
	 * @return boolean
	 */
	public function isEqual( Item $item )
	{
		// Check that the permalinks of each item are equal
		return $this->permalink === $item->permalink;
	}

	/**
	 * Get a machine readable version of the date.
	 * Useful for bots and spiders to read.
	 * @return string 
	 */
	public function getMachineReadableDate()
	{
		$dateTimezone = new DateTimeZone( 'Europe/London' );
		$date = new DateTime( $this->timestamp, $dateTimezone );

		return $date->format( 'Y-m-d' );
	}

	/**
	 * Get the date relative to now.
	 * @return string
	 */
	public function getRelativeDate()
	{
		$dateTimezone = new DateTimeZone( 'Europe/London' );
		$date = new RelativeDateTime( $this->timestamp, $dateTimezone );
		$now = new DateTime( 'now', $dateTimezone );

		$relativeInterval = $date->diff( $now );
		$relativeLimit = $relativeInterval::WEEK_IN_SECONDS * 2;

		if ( $relativeInterval->getTotalSeconds() >= $relativeLimit ) {
			$date = $date->format( 'j<sup>S</sup> F Y' );
		} else {
			$date = $relativeInterval->format();
		}

		return $date;
	}

	/**
	 * Get the number of days since the news item was published.
	 * @return integer
	 */
	public function getDaysSincePublished()
	{
		$dateTimezone = new DateTimeZone( 'Europe/London' );
		$date = new RelativeDateTime( $this->timestamp, $dateTimezone );
		$now = new DateTime( 'now', $dateTimezone );

		$relativeInterval = $date->diff( $now );
		$days = $relativeInterval->getTotalSeconds() / $relativeInterval::DAY_IN_SECONDS;

		return $days;
	}

	/**
	 * Get a standardised set of attributes that can be placed on an img tag from the media available.
	 * Favours the largest image for high res feeds.
	 * @param  SimplePie_Item $item 
	 * @return array       
	 */
	private function _getImageData( $item )
	{
		// Get the image data for the item
		$imageData = $item->get_item_tags( SIMPLEPIE_NAMESPACE_MEDIARSS, 'group' );

		if ( null !== $imageData ) {
			$imageData = $imageData[0][ 'child' ][ SIMPLEPIE_NAMESPACE_MEDIARSS ][ 'content' ];
		}

		// Try another tag combination
		if ( null === $imageData ) {
			$imageData = $item->get_item_tags( SIMPLEPIE_NAMESPACE_MEDIARSS, 'content' );
		}

		// If no data found try getting from the meda::thumbnail tag
		if ( null === $imageData ) {
			$imageData = $item->get_item_tags( SIMPLEPIE_NAMESPACE_MEDIARSS, 'thumbnail' );
		}

		if ( null === $imageData ) {
			// If still nothing use the default image
			$imageData = $this->_getDefaultImageData();
		} else {

			// If there is only one image, use it
			if ( 1 === count( $imageData ) ) {
				$imageData = $imageData[0]['attribs'][''];
			} else {

				// Else, check for the largest image and use that
				$largestImageWidthKey = false;
				$largestImageWidth = 0;
				foreach ($imageData as $key => $imageDataPart) {
					$imageDataPart = $imageDataPart['attribs'][''];
					if ( $imageDataPart['width'] > $largestImageWidth ) {
						$largestImageWidth = $imageDataPart['width'];
						$largestImageWidthKey = $key;
					}
				}

				// If we found the largest image use that, else use first
				if ( $largestImageWidthKey ) {
					$imageData = $imageData[ $largestImageWidthKey ]['attribs'][''];
				} else {
					$imageData = $imageData[0]['attribs'][''];
				}

			}

			// Add alt text
			$imageData['alt'] = $item->get_title() . ' thumbnail';

		}

		// Alias url to src
		$imageData['src'] = $imageData['url'];
		unset( $imageData['url'] );

		// Check all properties are set
		$properties = array( 
			'src' => '',
			'width' => 0,
			'height' => 0,
			'alt' => '',
		);
		foreach ($properties as $property_key => $property) {
			if ( !isset( $imageData[ $property_key ] ) ) {
				$imageData[ $property_key ] = $property;
			}
		}

		return $imageData;
	}

	/**
	 * Get a set of default image data if the function above cannot find an image to use.
	 * @return array
	 */
	private function _getDefaultImageData()
	{
		return array(
			'url' => 'public/images/thumbnail-default.jpg',
			'width' => 976,
			'height' => 549,
			'alt' => 'Close up of a newspaper',
		);
	}

	/**
	 * Format the feed base URL for display. Should show as example.com.
	 * @param  string $baseURL 
	 * @return string
	 */
	private function _formatBaseUrlForDisplay( $baseURL )
	{
		$url_parts = parse_url( $baseURL );
		$baseURL = sprintf( '%s', $url_parts[ 'host' ] );

		// If the URL contains the www subdomain, remove it
		$subdomain = 'www.';
		if ( 0 === strpos( $baseURL, $subdomain ) ) {
			$baseURL = substr( $baseURL, strlen( $subdomain ) );
		}

		return $baseURL;
	}

	/**
	 * Remove the read more text from the end of a string.
	 * @param  string $string 
	 * @return string         
	 */
	private function _removeReadMore( $string )
	{
		$read_mores = array(
			'Continue reading...',
			'Continue reading',
			'Read more...',
			'Read more',
		);

		foreach ($read_mores as $read_more) {
			
			// Check the read more text actually appears in the string
			if ( false !== ( $position = strrpos( strtolower( $string ), strtolower( $read_more ) ) ) ) {
				// Check if it was found at the end
				if ( $position === ( strlen( $string ) - strlen( $read_more ) ) ) {
					$string = substr( $string, 0, strlen( $string ) - strlen( $read_more ) );
				}
			}

		}

		return trim( $string );
	}

	/**
	 * Trim a string to a specific number of words.
	 * @param  string  $string    
	 * @param  integer $num_words 
	 * @return string             
	 */
	private function _trimLength( $string, $num_words = 25 )
	{
		$string_words = explode( ' ', $string );
		$string = '';

		for ( $i = 0; $i < min( $num_words, count( $string_words ) ); $i++ ) { 
			$string .= $string_words[ $i ] . ' ';
		}

		$string = trim( $string );

		if ( $num_words < count( $string_words ) ) {
			$string .= '&hellip;';
		}

		return trim( $string );
	}
}
