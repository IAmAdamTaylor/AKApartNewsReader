<?php

namespace WebApp\Home;
use WebApp\Page\ViewInterface;

class View implements ViewInterface
{
	/**
	 * The model for this page.
	 * @var HomeModel
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
}
