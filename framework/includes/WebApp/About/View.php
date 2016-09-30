<?php

namespace WebApp\About;
use WebApp\Page\ViewInterface;

/**
 * WebApp\About\View
 * The view (MVC) for the about page.
 */
class View implements ViewInterface
{
	/**
	 * The model for this page.
	 * @var About\Model
	 */
	var $_model;

	/**
	 * The template file being loaded for the current state.
	 * @var string
	 */
	var $_template;

	/**
	 * Template to use for the blank state.
	 * @var string
	 */
	const TEMPLATE_BLANK = 'about.php';
	
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
		return $this->_model->head->page_title;
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
		$class .= ' about';

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
