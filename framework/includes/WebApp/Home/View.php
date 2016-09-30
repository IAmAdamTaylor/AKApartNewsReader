<?php

namespace WebApp\Home;
use WebApp\Page\ViewInterface;

/**
 * WebApp\Home\View
 * The view (MVC) for the home page.
 */
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

	/**
	 * Output the template to the browser.
	 */
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

	/**
	 * Get the template name
	 * @return string
	 */
	public function getTemplate()
	{
		return $this->_template;
	}

	/**
	 * Get the page title.
	 * @return string
	 */
	public function getPageTitle()
	{
		$model = $this->_model;
		$model_state = $model->getState();

		// Detect which state we are in and return appropriate title

		// Assume blank state
		$title = self::PAGE_TITLE_BLANK;

		if ( $model_state === $model::STATE_SUCCESS ) {

			$title = esc_html( $this->getProperty( 'search_terms' ) );

		} else if ( $model_state === $model::STATE_ERROR ) {

			$title = self::PAGE_TITLE_ERROR;

		}

		return $title;
	}

	/**
	 * Get the SEO meta description.
	 * @return string
	 */
	public function getMetaDescription()
	{
		return $this->_model->head->meta_description;
	}

	/**
	 * Get a class that can be placed on the <body> to give more information about this specific page.
	 * @param  string $class Optional, extra classes to add to the returned class.
	 * @return string        
	 */
	public function getBodyClass( $class = '' )
	{
		// Add page class
		$class .= ' home';

		// Add template class
		$class .= ' ' . preg_replace( '/[^a-z0-9]/', '-', $this->_template );

		return $class;
	}

	/**
	 * Check if the view is currently in it's expanded state or not.
	 * @return boolean
	 */
	public function isExpanded()
	{
		return $this->_model->_isExpanded;
	}

	/**
	 * Get an arbitrary property from the model
	 * @param  string $name The property name.
	 * @return mixed
	 */
	public function getProperty( $name ) {
		if ( isset( $this->_model->{$name} ) ) {
			return $this->_model->{$name};
		} else {
			return '';
		}
	}
}
