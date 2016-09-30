<?php

namespace WebApp\About;
use WebApp\Page\ModelInterface;
use StdClass;
	
/**
 * WebApp\About\Model
 * The model (MVC) for the about page.
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
		$this->head->page_title = 'About';
		$this->head->meta_description = 'Read about how this project was made and about the developer who created it.';
	}

	/**
	 * Set the state of the model.
	 * @param integer $state
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
