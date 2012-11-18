<?php
/**
 * exceptions.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    18.11.12
 */

namespace Flame;

/**
 * The exception that is thrown when an I/O error occurs.
 */
class IOException extends \RuntimeException
{

}



/**
 * The exception that is thrown when accessing a file that does not exist on disk.
 */
class FileNotFoundException extends IOException
{

	/**
	 * @param string $file
	 *
	 * @return FileNotWritableException
	 */
	public static function fromFile($file)
	{
		return new static("Unable to read file '$file'. Please, make this file readable.");
	}

}



/**
 * The exception that is thrown when writing to a file that is not writable.
 */
class FileNotWritableException extends IOException
{

	/**
	 * @param string $file
	 * @return FileNotWritableException
	 */
	public static function fromFile($file)
	{
		return new static("Unable to write to file '$file'. Please, make this file writable.");
	}

}



/**
 * The exception that is thrown when part of a file or directory cannot be found.
 */
class DirectoryNotFoundException extends IOException
{

	/**
	 * @param string $directory
	 * @return DirectoryNotFoundException
	 */
	public static function fromDir($directory)
	{
		return new static("Unable to read directory '$directory'. Please, make this directory readable.");
	}

}



/**
 * The exception that is thrown when writing to a directory that is not writable.
 */
class DirectoryNotWritableException extends IOException
{

	/**
	 * @param string $directory
	 * @return DirectoryNotWritableException
	 */
	public static function fromDir($directory)
	{
		return new static("Unable to write to directory '$directory'. Please, make this directory writable.");
	}

}



/**
 * The exception that is thrown when static class is instantiated.
 */
class StaticClassException extends \LogicException
{

}