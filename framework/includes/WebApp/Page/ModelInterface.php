<?php

namespace WebApp\Page;

/**
 * WebApp\Page\ModelInterface
 * The MVC model interface all pages of the site should implement.
 */
interface ModelInterface
{
		/**
		 * UI state constants.
		 * @var integer
		 */
		const STATE_BLANK = '0';
		const STATE_SUCCESS = '1';
		const STATE_ERROR = '2';

		/**
		 * Set the state of the model.
		 * @param integer $state 
		 * @return $this
		 */
		public function setState( $state );

		/**
		 * Get the state of the model.
		 * @return integer
		 */
		public function getState();
}
