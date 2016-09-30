<?php

namespace Search;

/**
 * Search\Parser
 * Parses the search results and decides how relevant they are.
 */
class Parser implements ParserInterface
{
	/**
	 * The search terms used to parse the feed.
	 * @var string
	 */
	var $_terms;

	/**
	 * How relevant a search term is when found in different places in the feed item.
	 * @var integer
	 */
	const TITLE_WEIGHTING = 1.0;
	const DESCRIPTION_WEIGHTING = 0.5;
	const DATE_WEIGHTING = -0.33;
	
	function __construct( $terms )
	{
		$this->setTerms( $terms );
	}

	/**
	 * Get the results (items) sorted by relevance.
	 * The relevance key will not be returned.
	 * @param  array $items An array of Feed\Item objects.
	 * @return array
	 */
	public function getResults( $items )
	{
		$results = $this->getRawResults( $items );

		if ( count( $results ) > 0 ) {
			// Sort by relevance
			usort( $results, array( $this, 'usortByRelevance' ) );
		}

		// Remove relevance key once it has been used to avoid leaking internal data back into other classes
		foreach ($results as &$result) {
			$result = $result['item'];
			unset( $result );
		}

		return $results;
	}

	/**
	 * Get the raw set of unsorted results.
	 * The relevance key will be returned.
	 * @param  array $items An array of Feed\Item objects.
	 * @return array
	 */
	public function getRawResults( $items )
	{
		$results = array();

		foreach ($items as $item) {
			
			$relevance = $this->_calculateRelevance( $item );

			// Filter out non matching items			
			if ( false !== $relevance ) {
				
				$results[] = array(
					'relevance' => $relevance,
					'item' => $item,
				);

			}

		}

		return $results;
	}

	/**
	 * Calculate the relevance of an item.
	 * @param  Feed\Item $item 
	 * @return float       
	 */
	private function _calculateRelevance( $item )
	{
		$title = strtolower( $item->rawTitle );
		$description = strtolower( $item->rawDescription );

		$title_relevance = 0;
		$description_relevance = 0;

		foreach ($this->_terms as $term) {

			// Filter out short terms like 'and', 'the' or single numbers, e.g. 'iPhone 7'
			if ( strlen( $term ) < 3 ) {
				continue;
			}
			
			// Check if term is in title
			if ( false !== strpos( $title, $term ) ) {
				$title_relevance++;
			}

			// Check if term is in description
			if ( false !== strpos( $description, $term ) ) {
				$description_relevance++;
			}

		}

		if ( 0 === ( $title_relevance + $description_relevance ) ) {
			return false;
		}

		// Combine them, with weightings
		$relevance = ( $title_relevance * self::TITLE_WEIGHTING ) + ( $description_relevance * self::DESCRIPTION_WEIGHTING );

		// Decrease the relevance for every day this has been published
		// Should allow newer items to come to the top, as long as they have the same amount of terms
		$relevance += $item->getDaysSincePublished() * self::DATE_WEIGHTING;

		return $relevance;
	}

	/**
	 * usort() callback. Sort the results by relvance highest to lowest.
	 * @param  array $a 
	 * @param  array $b 
	 * @return integer
	 */
	public function usortByRelevance( $a, $b ) 
	{
		$floatVal = $b['relevance'] - $a['relevance'];
		$compare = 0;

		if ( $floatVal > 0 ) {
		 	$compare = 1;
	  } else if ( $floatVal < 0 ) {
	  	$compare = -1;
	  } 

		return $compare;
	}

	/**
	 * Set the search terms to parse.
	 * @param string $terms
	 * @return $this
	 */
	public function setTerms( $terms )
	{
		if ( is_string( $terms ) ) {
			// Convert the terms into an array, check each individually
			// This lets an item which matches all terms return a higher relevance than one which only matches a single term
			$terms = explode( ' ', $terms );
		}

		if ( is_array( $terms ) && $this->_terms !== $terms ) {
			$this->_terms = $terms;
		}

		return $this;
	}

	/**
	 * Get the search terms
	 * @return string
	 */
	public function getTerms()
	{
		return $this->_terms;
	}
}
