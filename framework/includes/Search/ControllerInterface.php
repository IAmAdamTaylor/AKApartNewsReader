<?php

namespace Search;

interface ControllerInterface 
{
	public function setSearchTerms( $search_terms );
	public function getSearchTerms();
	
	public function getResults();
}
