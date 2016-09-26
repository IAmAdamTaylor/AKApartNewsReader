<?php

namespace Feed;
use SimplePie_Item;
use StdClass;

/**
 * Structure to hold properties of a feed item.
 */
class Item implements ItemInterface
{
	function __construct( $item )
	{
		if ( is_a( $item , 'SimplePie_Item' ) ) {
			$this->mapSimplePie_Item( $item );
		}

		if ( is_array( $item ) ) {
			$this->mapArray( $item );
		}
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

		$imageData = $this->_getImageData( $item );

		$this->imageData = $imageData;
		$this->imageJSON = json_encode( $imageData );

		// Add the feed information as a generic structure
		$feed = $item->get_feed();

		$feedData = new StdClass();
		$feedData->subscribeURL = $feed->subscribe_url();
		$feedData->baseURL = $feed->get_base();

		$this->feedData = $feedData;

		// echo '<pre style="text-align:left;">'; 
		// var_dump( $this ); 
		// echo '</pre>';

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

		$this->imageData = $item[ 'imageData' ];
		$this->imageJSON = json_encode( $item[ 'imageData' ] );

		// Add the feed information as a generic structure
		$feedData = (object)$item[ 'feedData' ];
		$this->feedData = $feedData;

		return $this;
	}

	private function _getImageData( $item )
	{
		// Get the image data for the item
		$imageData = $item->get_item_tags( SIMPLEPIE_NAMESPACE_MEDIARSS, 'thumbnail' );

		if ( null === $imageData ) {
			$imageData = $this->_getDefaultImageData();
		} else {
			$imageData = $imageData[0]['attribs'][''];
			$imageData['alt'] = $item->get_title() . ' thumbnail';
		}

		// Alias url to src
		$imageData['src'] = $imageData['url'];
		unset( $imageData['url'] );

		return $imageData;
	}

	private function _getDefaultImageData()
	{
		return array(
			'url' => 'public/images/thumbnail-default.jpg',
			'width' => 976,
			'height' => 549,
			'alt' => 'Close up of a newspaper',
		);
	}
}
