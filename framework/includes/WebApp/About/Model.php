<?php

namespace WebApp\About;
use WebApp\Page\ModelInterface;
use StdClass;
	
class Model implements ModelInterface
{
	/**
	 * The current UI state of the model.
	 * @var string
	 */
	var $_state;

	/**
	 * Contains meta data related to the page.
	 * @var StdClass
	 */
	public $head;

	/**
	 * The SEO meta description for the current page.
	 * @var string
	 */
	public $meta_description;
	
	function __construct()
	{
		$this->_state = self::STATE_BLANK;

		$this->head = new StdClass();
		$this->head->page_title = 'About';
		$this->head->meta_description = 'Serving you the latest news, 10KB at a time.';
	}

	public function setState( $state )
	{
		if ( $this->_state !== $state ) {
			$this->_state = $state;
		}
		return $this;
	}

	public function getState()
	{
		return $this->_state;
	}
}
