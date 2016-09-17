<?php

/**
* Page object. Represents a single page on the site.
*/
class Page {

	/**
	 * The page's filename, without the .php
	 * @var string
	 */
	protected $filename;

	/**
	 * The page's title.
	 * @var string
	 */
	public $title;
	const TITLE_META_REGEX = '/Page Title:(.*)/';

	/**
	 * The page's meta description.
	 * @var string
	 */
	public $description;
	const DESCRIPTION_META_REGEX = '/Page Description:(.*)/';

	/**
	 * Create the class and init the meta attributes
	 * @param string $filename
	 */
	function __construct( $filename ) {
		$filename = self::sanitise_filename( $filename );

		if ( file_exists( $filename ) ) {
			$this->filename = $filename;
			$this->_get_page_meta( $filename );
		}
	}

	/**
	 * Find the meta stored in the $filename file
	 * @param  string $filename
	 */
	protected function _get_page_meta( $filename ) {
		$file_contents = file_get_contents( $filename );

		$this->title = $this->_parse_page( self::TITLE_META_REGEX, $file_contents );
		$this->description = $this->_parse_page( self::DESCRIPTION_META_REGEX, $file_contents );
	}

	/**
	 * Parses the contents of a page file and returns the meta date found.
	 * @param  string $regex    A valid regex format, with at least 1 capturing group.
	 * @param  string $contents The page contents.
	 * @return string
	 */
	private function _parse_page( $regex, $contents ) {
		$matches = array();
		preg_match( $regex, $contents, $matches );

		if ( count( $matches ) > 0 ) {
			return trim( $matches[1] );
		} else {
			return '';
		}
	}

	/**
	 * Get the filename this Page represents
	 * @return string
	 */
	public function get_filename() {
		return $this->filename;
	}

	/**
	 * Sanitise a passed filename into the format required.
	 * @param  string $filename
	 * @param  string $extension
	 * @return string
	 */
	public static function sanitise_filename( $filename, $extension = '.php' ) {
		// Add the root path to the start of the filename if not exists.
		if ( false === strpos( $filename, ROOT_PATH ) ) {
			$filename = ROOT_PATH . $filename;
		}

		// Append the extension if not exists
		if ( false === strpos( $filename, $extension ) ) {
			$filename .= $extension;
		}

		return $filename;
	}
}
