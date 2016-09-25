<?php

namespace Search;
use Search\Results\Cache\Controller as ResultsCache;
use Search\Terms\Cache\Controller as TermsCache;
use Search\Parser;
use Feed\Reader as FeedReader;
	
class Controller implements ControllerInterface
{
	/**
	 * The terms to search for, URL encoded.
	 * @var string
	 */
	var $_search_terms;

	/**
	 * The maximum amount of results to be returned from the parser.
	 * @var integer
	 */
	const RESULTS_LIMIT = 5;

	function __construct( $search_terms )
	{
		$this->setSearchTerms( $search_terms );
	}

	public function setSearchTerms( $search_terms )
	{
		if ( !is_string( $search_terms ) ) {
			return;
		}
		
		$search_terms = strtolower( $search_terms );
		$this->_search_terms = $search_terms;

		return $this;
	}

	public function getSearchTerms()
	{
		return $this->_search_terms;
	}

	public function getResults()
	{
		// Check cached results
		$resultsCache = new ResultsCache();
		$results = $resultsCache->get( $this->_search_terms );

		// Cache will return false if the results don't exist or are out of date
		if ( $results ) {
			return $results;
		}

		// Get the feed items from the reader
		$reader = new FeedReader();
		$feed_items = $reader->getItems();
		
		$parser = new Parser( $this->_search_terms, self::RESULTS_LIMIT );
		$results = $parser->getResults( $feed_items );
		
		// If we've got something, cache it
		// Also cache the search terms, as a search that returns results
		if ( 0 !== count( $results ) ) {
			$termsCache = new TermsCache();
			$termsCache->store( $this->_search_terms );

			$resultsCache->store( $this->_search_terms, $results );
		}

		// Return the results
		// This may be a blank array if no results were found for the passed terms
		return $results;
	}
}
