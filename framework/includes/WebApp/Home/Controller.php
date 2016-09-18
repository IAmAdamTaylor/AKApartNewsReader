<?php

namespace WebApp\Home;

class Controller
{
	/**
	 * The model for this page.
	 * @var HomeModel
	 */
	var $_model;
	
	function __construct( $model )
	{
		$this->_model = $model;
	}

	function processSearch( $search_terms ) 
	{
		$model = $this->_model;

		// $searchController = new FeedReader\SearchController();
		// $results = $searchController->getResults( $search_terms );

		// Fake it!
		$results = array( '1', '2', '3' );
		// $results = array();

		if ( 0 === count( $results ) ) {
			
			// No results, show error state
			$this->_model->setState( $model::STATE_ERROR );

		} else {
			
			// Got results, show the partial/ideal -> results state
			$this->_model->setState( $model::STATE_SUCCESS );

		}

		$this->_model->results = $results;
	}
}
