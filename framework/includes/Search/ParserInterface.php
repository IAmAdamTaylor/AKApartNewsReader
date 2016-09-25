<?php

namespace Search;

interface ParserInterface
{	
	public function getResults( $items );
	public function getRawResults( $items );

	public function setTerms( $terms );
	public function getTerms();
}
