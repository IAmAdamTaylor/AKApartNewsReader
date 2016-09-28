<?php

namespace Cache;

/**
 * Cache\ManagerInterface
 * Represents a cache manager that can check cache folders exist, create them (recursively) and remove them (recursively).
 * Singleton: There can be only one.
 */
interface ManagerInterface
{
	/**
   * Returns the *Singleton* instance of this class.
   * @return Singleton The *Singleton* instance.
   */
	public static function instance();

	/**
	 * Check if a folder exists within the cache dir.
	 * @param  string $path The path to the folder.
	 * @return boolean
	 */
	public function doesFolderExist( $path );
	
	/**
	 * Create a folder within the cache dir.
	 * @param  string $folder The folder name to create.
	 * @param  string $path   Optional, The path to create the folder at. Defaults to creating the folder within the base cache directory.
	 * @return boolean        True if folder was created, false on error.
	 */
	public function createFolder( $folder, $path = '' );
	/**
	 * Create a set of folders, recursively, within the cache dir.
	 * @param  string $path The directory structure to create.
	 *                      E.g. path/to/cache/folder/
	 * @return boolean      True if folders were created, false on error.
	 */
	public function createFolderTree( $path );

	/**
	 * Remove a folder from the cache dir.
	 * @param  string $folder The folder name to remove.
	 * @param  string $path   Optional, The path to remove the folder at. Defaults to removing the folder from the base cache directory.
	 * @return boolean      True if folder was removed, false on error.
	 */
	public function removeFolder( $folder, $path = '' );
}
