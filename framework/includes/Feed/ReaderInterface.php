<?php

namespace Feed;

interface ReaderInterface 
{
	public function getItems( $paged );
	public function getUniqueItems( $paged );
	public function enablePaging( $flag );
}
