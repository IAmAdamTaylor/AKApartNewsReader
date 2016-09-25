<?php

namespace Search;

class Parser implements ParserInterface
{
	/**
	 * The search terms used to parse the feed.
	 * @var string
	 */
	var $_terms;

	/**
	 * The maximum amount of results to return, when ordered by relevance.
	 * @var integer
	 */
	var $_relevance_limit;

	/**
	 * How relevant a search term is when found in different places in the feed item.
	 * @var integer
	 */
	const TITLE_WEIGHTING = 1.0;
	const DESCRIPTION_WEIGHTING = 0.5;
	
	function __construct( $terms, $limit )
	{
		$this->setTerms( $terms );
		$this->_relevance_limit = $limit;
	}

	public function getResults( $items )
	{
		$results = $this->getRawResults( $items );

		if ( count( $results ) > 0 ) {
			// Sort by relevance
			usort( $results, array( $this, 'usortByRelevance' ) );
		}

		return $results;
	}

	public function getRawResults( $items )
	{
		$results = array();

		foreach ($items as $item) {
			
			$relevance = $this->_calculateRelevance( $item );

			// Filter out non matching items			
			if ( $relevance > 0 ) {
				
				$results[] = array(
					'relevance' => $relevance,
					'item' => $item,
				);

			}

		}

		return $results;
	}

	private function _calculateRelevance( $item )
	{
		$title = strtolower( $item->get_title() );
		$description = strtolower( $item->get_description() );

		$title_relevance = 0;
		$description_relevance = 0;

		foreach ($this->_terms as $term) {
			
			// Check if term is in title
			if ( false !== strpos( $title, $term ) ) {
				$title_relevance++;
			}

			// Check if term is in description
			if ( false !== strpos( $description, $term ) ) {
				$description_relevance++;
			}

		}

		// Combine them, with weightings
		$relevance = ( $title_relevance * self::TITLE_WEIGHTING ) + ( $description_relevance * self::DESCRIPTION_WEIGHTING );

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
		return $b['relevance'] - $a['relevance'];
	}

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

	public function getTerms()
	{
		return $this->_terms;
	}

	public function setRelevanceLimit( $limit )
	{
		if ( $this->_relevance_limit !== $limit ) {
			$this->_relevance_limit = $limit;
		}

		return $this;
	}

	public function getRelevanceLimit()
	{
		return $this->_relevance_limit;
	}	
}