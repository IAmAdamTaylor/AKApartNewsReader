<?php

namespace Search;

interface ParserInterface
{	
	/**
	 * Get the results (items) sorted by relevance.
	 * The relevance key will not be returned.
	 * @param  array $items An array of Feed\Item objects.
	 * @return array
	 */
	public function getResults( $items );

	/**
	 * Get the raw set of unsorted results.
	 * The relevance key will be returned.
	 * @param  array $items An array of Feed\Item objects.
	 * @return array
	 */
	public function getRawResults( $items );

	/**
	 * Set the search terms to parse.
	 * @param string $terms
	 * @return $this
	 */
	public function setTerms( $terms );

	/**
	 * Get the search terms
	 * @return string
	 */
	public function getTerms();
}
