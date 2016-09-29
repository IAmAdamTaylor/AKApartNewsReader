<?php

namespace WebApp\About;
use Search\Controller as SearchController;

class Controller
{
	/**
	 * The model for this page.
	 * @var About\Model
	 */
	var $_model;
	
	function __construct( $model )
	{
		$this->_model = $model;
	}

	/**
	 * Enable the expanded view.
	 * Increases file size so use sparingly and only over AJAX.
	 * @param  boolean $onOff Optional, whether to enable or disable the expanded view.
	 */
	public function enableExpandedView( $onOff = true )
	{
		$this->_model->_isExpanded = $onOff;
	}
}
