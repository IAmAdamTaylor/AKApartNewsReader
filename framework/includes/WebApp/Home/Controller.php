<?php

namespace WebApp\Home;
use Search\Controller as SearchController;

class Controller
{
	/**
	 * The model for this page.
	 * @var Home\Model
	 */
	var $_model;
	
	function __construct( $model )
	{
		$this->_model = $model;
	}

	function processSearch( $search_terms ) 
	{
		$model = $this->_model;

		// Add the search terms as a property on the model
		$this->_model->search_terms = $search_terms;

		// Try to get results for these search terms
		$searchController = new SearchController( $search_terms );
		$results = $searchController->getResults();

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
