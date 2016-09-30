<?php

namespace Cache;
		
/**
 * Cache\Manager
 * Handles creating and deleting cache folders.
 */
class Manager implements ManagerInterface
{
	/**
	 * The reference to *Singleton* instance of this class.
	 * @var Singleton 
	 */
	private static $instance;

	/**
   * Returns the *Singleton* instance of this class.
   * @return Singleton The *Singleton* instance.
   */
  public static function instance()
  {
    if ( null === static::$instance ) {
      static::$instance = new static();
    }
    
    return static::$instance;
  }

  /**
   * Protected constructor to prevent creating a new instance of the
   * *Singleton* via the `new` operator from outside of this class.
   */
  protected function __construct() {}

  /**
   * Private clone method to prevent cloning of the instance of the
   * *Singleton* instance.
   * @return void
   */
  private function __clone() {}

  /**
   * Private unserialize method to prevent unserializing of the *Singleton*
   * instance.
   * @return void
   */
  private function __wakeup() {}

  /**
	 * Check if a folder exists within the cache dir.
	 * @param  string $path The path to the folder.
	 * @return boolean
	 */
	public function doesFolderExist( $path )
	{
		$full_path = trailingslashit( CACHE_BASE_PATH ) . $path;

		// Check for read/write permissions to this folder
		return is_dir( $full_path ) && is_readable( $full_path ) && is_writable( $full_path );
	}
	
	/**
	 * Create a folder within the cache dir.
	 * @param  string $folder The folder name to create.
	 * @param  string $path   Optional, The path to create the folder at. Defaults to creating the folder within the base cache directory.
	 * @return boolean        True if folder was created, false on error.
	 */
	public function createFolder( $folder, $path = '' )
	{
		// Check if there are directory separators in the folder name
		if ( false !== strpos( $folder, DIRECTORY_SEPARATOR ) ) {	
			throw new ManagerException( "Folder name [$folder] cannot contain directory separators" );
		}

		$full_path = trailingslashit( CACHE_BASE_PATH ) . ( ( '' !== $path ) ? trailingslashit( $path ) : '' ) . $folder;

		// Check if the folder already exists
		if ( $this->doesFolderExist( $full_path ) ) {
			// true because although we did not create anything, it exists and is usable
			return true;
		}

		return mkdir( $full_path );
	}
	
	/**
	 * Create a set of folders, recursively, within the cache dir.
	 * @param  string $path The directory structure to create.
	 *                      E.g. path/to/cache/folder
	 * @return boolean      True if folders were created, false on error.
	 */
	public function createFolderTree( $path )
	{
		$full_path = trailingslashit( CACHE_BASE_PATH ) . ( ( '' !== $path ) ? trailingslashit( $path ) : '' ) ;

		// Check if the folder tree already exists
		if ( $this->doesFolderExist( $full_path ) ) {
			// true because although we did not create anything, it exists and is usable
			return true;
		}

		// Use recursive parameter
		return mkdir( $full_path, 0777, true );
	}

	/**
	 * Remove a folder from the cache dir.
	 * @param  string $folder The folder name to remove.
	 * @param  string $path   Optional, The path to remove the folder at. Defaults to removing the folder from the base cache directory.
	 * @return boolean      True if folder was removed, false on error.
	 */
	public function removeFolder( $folder, $path = '' )
	{
		// Check if there are directory separators in the folder name
		if ( false !== strpos( $folder, DIRECTORY_SEPARATOR ) ) {	
			throw new ManagerException( "Folder name [$folder] cannot contain directory separators" );
		}

		$full_path = trailingslashit( CACHE_BASE_PATH ) . ( ( '' !== $path ) ? trailingslashit( $path ) : '' ) . $folder;

		// Check if the folder tree already exists
		if ( $this->doesFolderExist( $full_path ) ) {
			// true because although we did not create anything, it exists and is usable
			return true;
		}

		// Use recursive function to make sure all subfolders and files are also removed
		return rrmdir( $full_path );
	}
}
