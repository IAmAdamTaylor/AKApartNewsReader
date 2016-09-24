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

	public function getTrendingTerms( $limit = 10 )
	{
		$terms = $this->_getCache()->get();

		// Check if cache returned values
		if ( false === $terms ) {
			$terms = array();
		}

		// Include faux terms if below the limit
		if ( $terms < $limit ) {
			$terms = array_merge( $terms, $this->_getFauxTerms() );
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
			'terence crutcher' => $amount--,
			'syria'  => $amount--,
			'aleppo' => $amount--,
			'new york explosion' => $amount--,
			'presidential race' => $amount--,
			'donald trump' => $amount--,
			'jeremy corbyn' => $amount--,
			'icloud hacked' => $amount--,
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
