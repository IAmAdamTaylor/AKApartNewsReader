<?php

namespace Search;

/**
 * Search\ControllerInterface
 * The interface for an object to handle a search query,
 */
interface ControllerInterface 
{
	/**
	 * Set the search terms.
	 * @param string $search_terms 
	 * @return $this
	 */
	public function setSearchTerms( $search_terms );
	
	/**
	 * Get the search terms.
	 * @return string
	 */
	public function getSearchTerms();
	
	/**
	 * Get results for the search terms.
	 * @return array 
	 */
	public function getResults();
}
