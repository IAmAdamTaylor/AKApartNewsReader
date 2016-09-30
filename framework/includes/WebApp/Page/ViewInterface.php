<?php

namespace WebApp\Page;

/**
 * WebApp\Page\ViewInterface
 * The MVC view interface all pages of the site should implement.
 */
interface ViewInterface
{
		/**
		 * Output the template to the browser.
		 */
		public function output();

		/**
		 * Get the page title.
		 * @return string
		 */
		public function getPageTitle();

		/**
		 * Get the SEO meta description.
		 * @return string
		 */
		public function getMetaDescription();

		/**
		 * Get a class that can be placed on the <body> to give more information about this specific page.
		 * @param  string $class Optional, extra classes to add to the returned class.
		 * @return string        
		 */
		public function getBodyClass( $class = '' );
}
