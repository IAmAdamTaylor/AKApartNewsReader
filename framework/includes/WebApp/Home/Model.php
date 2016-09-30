<?php

namespace WebApp\Home;
use WebApp\Page\ModelInterface;
use StdClass;
	
/**
 * WebApp\Home\Model
 * The model (MVC) for the home page.
 */
class Model implements ModelInterface
{
	/**
	 * The current UI state of the model.
	 * @var string
	 */
	var $_state;

	/**
	 * Whether or not the template should be shown in an expanded state or not.
	 * Some elements will be hidden and dyanmically included on page load.
	 * @var boolean
	 */
	var $_isExpanded;

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
		$this->_isExpanded = false;

		$this->head = new StdClass();
		$this->head->page_title = 'Home';
		$this->head->meta_description = 'Serving you the latest news, 10KB at a time.';
	}

	/**
	 * Set the state of the model.
	 * @param integer $state 
	 * @return $this
	 */
	public function setState( $state )
	{
		if ( $this->_state !== $state ) {
			$this->_state = $state;
		}
		return $this;
	}

	/**
	 * Get the state of the model.
	 * @return integer
	 */
	public function getState()
	{
		return $this->_state;
	}
}
