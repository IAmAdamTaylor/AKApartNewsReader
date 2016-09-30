<?php

namespace WebApp\Home;
use Search\Controller as SearchController;

/**
 * WebApp\Home\Controller
 * The controller (MVC) for the home page.
 */
class Controller
{
	/**
	 * The model for this page.
	 * @var Home\Model
	 */
	var $_model;

	/**
	 * The amount of results to show.
	 * @var integer
	 */
	var $_resultsLimit;

	/**
	 * The maximum amount of results to be shown in a non expanded view.
	 * @var integer
	 */
	const DEFAULT_RESULTS_LIMIT = 5;
	const INCREASED_RESULTS_LIMIT = 10;
	
	function __construct( $model )
	{
		$this->_model = $model;
		$this->_resultsLimit = self::DEFAULT_RESULTS_LIMIT;
	}

	/**
	 * Handle the user making a search.
	 * Gets the results and sets them on the model.
	 * @param  string $search_terms 
	 */
	function handleSearch( $search_terms ) 
	{
		$model = $this->_model;

		// Check for blank search
		if ( '' === $search_terms ) {
			$this->_model->setState( $model::STATE_ERROR );
			$this->_model->results = array();
			return;
		}

		// Add the search terms as a property on the model
		$this->_model->search_terms = esc_html( $search_terms );

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

		// Slice the results up to the limit
		$slicedResults = array_slice( $results, 0, $this->_resultsLimit, true );

		// Pass the raw results and the sliced ones to the model
		$this->_model->rawResults = $results;
		$this->_model->results = $slicedResults;

		$this->_model->rawResultsCount = count( $results );
		$this->_model->resultsCount = count( $slicedResults );
	}

	/**
	 * Enable the expanded view.
	 * Increases file size so use sparingly and only over AJAX.
	 * @param  boolean $onOff Optional, whether to enable or disable the expanded view.
	 */
	public function enableExpandedView( $onOff = true )
	{
		$this->_model->_isExpanded = !!$onOff;

		if ( true === !!$onOff ) {
			$this->_resultsLimit = self::INCREASED_RESULTS_LIMIT;
		}
	}
}
