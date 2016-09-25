<?php

namespace Feed;

interface ReaderInterface 
{
	public function getItems( $paged );
}
