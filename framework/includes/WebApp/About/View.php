<?php

namespace WebApp\About;
use WebApp\Page\ViewInterface;

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

	const TEMPLATE_BLANK = 'about.php';
	
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
		$class .= ' about';

		return $class;
	}

	function getProperty( $name ) {
		if ( isset( $this->_model->{$name} ) ) {
			return $this->_model->{$name};
		} else {
			return '';
		}
	}
}
