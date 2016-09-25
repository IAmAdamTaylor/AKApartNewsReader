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
}
