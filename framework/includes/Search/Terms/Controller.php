<?php

namespace Search\Terms;
use Search\Terms\Cache\Controller as TermsCache;

class Controller
{
	/**
	 * An instance of the search terms cache controller.
	 * @var Search\Terms\Cache\Controller
	 */
	var $_cache;

	public function getTrendingTerms( $limit = 10, $exclude_terms = array() )
	{
		// Convert param to array
		if ( is_string( $exclude_terms ) ) {
			$exclude_terms = array( $exclude_terms );
		}

		$terms = $this->_getCache()->get();

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
	 * Get a set of pregenerated items, to use if the cache is not primed.
	 * @return array
	 */
	private function _getFauxTerms() {
		// All fake searches should always have an invalid count
		// This means if they are sorted, real searches will appear top every time
		$amount = 0;

		return array(
			'nahid hattar killed' => $amount--,
			'terence crutcher' => $amount--,
			'syria'  => $amount--,
			'aleppo' => $amount--,
			'new york explosion' => $amount--,
			'strike action' => $amount--,
			'presidential race' => $amount--,
			'donald trump' => $amount--,
			'jeremy corbyn' => $amount--,
			'royal family' => $amount--,
			'brangelina' => $amount--,
			'manhunt' => $amount--,
		);
	}

	private function _getCache()
	{
		if ( !isset( $this->_cache ) ) {
			$this->_cache = new TermsCache();
		}

		return $this->_cache;
	}
}
