<?php

namespace WebApp\Home;
use WebApp\Page\ViewInterface;

class View implements ViewInterface
{
	/**
	 * The model for this page.
	 * @var Home\Model
	 */
	var $_model;

	/**
	 * The template file being loaded for the current state.
	 * @var string
	 */
	var $_template;

	const TEMPLATE_BLANK = 'home/blank.php';
	const TEMPLATE_SUCCESS = 'home/success.php';
	const TEMPLATE_ERROR = 'home/error.php';
	
	function __construct( $model )
	{
		$this->_model = $model;
	}

	public function output()
	{
		$model = $this->_model;
		$model_state = $model->getState();

		// Assume blank state
		$template = self::TEMPLATE_BLANK;

		if ( $model_state === $model::STATE_SUCCESS ) {
			$template = self::TEMPLATE_SUCCESS;
		} else if ( $model_state === $model::STATE_ERROR ) {
			$template = self::TEMPLATE_ERROR;
		}

		if ( '' !== $template ) {
			$this->_template = $template;
			$template = 'templates/' . $template;

			include $template;
		}
	}

	public function getTemplate()
	{
		return $this->_template;
	}

	public function getPageTitle()
	{
		return $this->_model->head->page_title;
	}

	public function getMetaDescription()
	{
		return $this->_model->head->meta_description;
	}

	public function getBodyClass( $class = '' )
	{
		// Add page class
		$class .= ' home';

		// Add template class
		$class .= ' ' . preg_replace( '/[^a-z0-9]/', '-', $this->_template );

		return $class;
	}

	function getProperty( $name ) {
		if ( isset( $this->_model->{$name} ) ) {
			return $this->_model->{$name};
		} else {
			return '';
		}
	}

	/**
	 * Get a JSON representation of the thumbnail image.
	 * @param  SimplePie_Item $item The feed item.
	 * @return string               The JSON representation of the image.
	 */
	function getImageJSON( $item ) {
		// Get the image data for the item
		$image_attributes = $item->get_item_tags( SIMPLEPIE_NAMESPACE_MEDIARSS, 'thumbnail' );

		if ( null === $image_attributes ) {
			$image_attributes = array(
				'url' => 'public/images/thumbnail-default.jpg',
				'width' => 976,
				'height' => 549,
				'alt' => 'Close up of a newspaper',
			);
		} else {
			$image_attributes = $image_attributes[0]['attribs'][''];
			$image_attributes['alt'] = $item->get_title() . ' thumbnail';
		}

		// Alias url to src
		$image_attributes['src'] = $image_attributes['url'];
		unset( $image_attributes['url'] );

		return json_encode( $image_attributes );
	}
}
