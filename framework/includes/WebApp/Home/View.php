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

	const PAGE_TITLE_BLANK = 'Home';
	const PAGE_TITLE_ERROR = 'No Results Found';
	
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
		$model = $this->_model;
		$model_state = $model->getState();

		// Detect which state we are in and return appropriate title

		// Assume blank state
		$title = self::PAGE_TITLE_BLANK;

		if ( $model_state === $model::STATE_SUCCESS ) {

			$title = $this->getProperty( 'search_terms' );
			$title = ucwords( $title );

		} else if ( $model_state === $model::STATE_ERROR ) {

			$title = self::PAGE_TITLE_ERROR;

		}

		return $title;
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

	public function getProperty( $name ) {
		if ( isset( $this->_model->{$name} ) ) {
			return $this->_model->{$name};
		} else {
			return '';
		}
	}

	public function isExpanded()
	{
		return $this->_model->_isExpanded;
	}
}
