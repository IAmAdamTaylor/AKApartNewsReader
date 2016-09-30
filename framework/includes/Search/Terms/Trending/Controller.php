<?php

namespace Search\Terms\Trending;
use Search\Terms\Cache\Controller as TermsCache;

/**
 * Search\Terms\Trending\Controller
 * Handles getting and displaying the trending terms list.
 */
class Controller
{
	/**
	 * Get the trending terms.
	 * Uses the terms cache and adds faux terms if there are not enough, or the cache is empty.
	 * @param  integer $limit         The maximum amount of terms to get.
	 * @param  array   $exclude_terms An array of terms to filter out of the list.
	 * @return array
	 */
	public function getTerms( $limit = 10, $exclude_terms = array() )
	{
		// Convert param to array
		if ( is_string( $exclude_terms ) ) {
			$exclude_terms = array( $exclude_terms );
		}

		// Get the most searched terms from the cache file
		$termsCache = new TermsCache();
		$terms = $termsCache->get();

		// Check if cache returned values
		if ( false === $terms ) {
			$terms = array();
		}

		// Include faux terms, will get sliced out later if there are enough cached terms
		$terms = array_merge( $this->_getFauxTerms(), $terms );

		// Exclude any specific terms passed
		foreach ($exclude_terms as $exclude_term) {
			$exclude_term = strtolower( $exclude_term );

			if ( isset( $terms[ $exclude_term ] ) ) {
				unset( $terms[ $exclude_term ] );
			}
		}

		arsort( $terms );
		return array_slice( $terms, 0, $limit, true );
	}	

	/**
	 * Get a set of preregistered items, to use if the cache is not primed.
	 * @return array
	 */
	private function _getFauxTerms() {
		// All fake searches should always have an invalid count
		// This means if they are sorted, real searches will appear top every time
		$amount = 0;

		// Using decrementer to ensure faux terms display in the same order shown
		return array(
			'donald trump' => $amount--,
			'hillary clinton' => $amount--,
			'syria'  => $amount--,
			'aleppo' => $amount--,
		);
	}
}
