<?php
/**
 * FileSystem.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    18.11.12
 */

namespace Flame\Tools\Files;

use Flame;

/**
 * @author Filip Procházka <filip@prochazka.su>
 */
class FileSystem extends \Nette\Object
{

	/**
	 * Static class - cannot be instantiated.
	 *
	 * @throws \Flame\StaticClassException
	 */
	final public function __construct()
	{
		throw new \Flame\StaticClassException;
	}


	/**
	 * @param $file
	 * @param bool $need
	 * @return bool
	 * @throws \Flame\FileNotWritableException
	 */
	public static function rm($file, $need = true)
	{
		if (is_dir((string)$file)) {
			return static::rmDir($file, false, $need);
		}

		if (false === ($result = @unlink((string)$file)) && $need) {
			throw new Flame\FileNotWritableException("Unable to delete file '$file'");
		}

		return $result;
	}


	/**
	 * @param $dir
	 * @param bool $recursive
	 * @param bool $need
	 * @return bool
	 * @throws \Flame\DirectoryNotWritableException
	 */
	public static function rmDir($dir, $recursive = true, $need = true)
	{
		$recursive && self::cleanDir($dir = (string)$dir, $need);
		if (is_dir($dir) && false === ($result = @rmdir($dir)) && $need) {
			throw new Flame\DirectoryNotWritableException("Unable to delete directory '$dir'.");
		}

		return isset($result) ? $result : true;
	}



	/**
	 * @param string $dir
	 * @param bool $need
	 *
	 * @return bool
	 */
	public static function cleanDir($dir, $need = true)
	{
		if (!file_exists($dir)) {
			return true;
		}

		foreach (\Nette\Utils\Finder::find('*')->from($dir)->childFirst() as $file) {
			if (false === static::rm($file, $need)) {
				return false;
			}
		}

		return true;
	}


	/**
	 * @param $dir
	 * @param bool $recursive
	 * @param int $chmod
	 * @param bool $need
	 * @return bool
	 * @throws \Flame\IOException
	 */
	public static function mkDir($dir, $recursive = true, $chmod = 0777, $need = true)
	{
		$parentDir = $dir;
		while (!is_dir($parentDir)) {
			$parentDir = dirname($parentDir);
		}

		@umask(0000);
		if (!is_dir($dir) && false === ($result = @mkdir($dir, $chmod, $recursive)) && $need) {
			throw new Flame\IOException('Unable to create directory ' . $dir);
		}

		if ($dir !== $parentDir) {
			do {
				@umask(0000);
				@chmod($dir, $chmod);
				$dir = dirname($dir);
			} while ($dir !== $parentDir);
		}

		return isset($result) ? $result : true;
	}


	/**
	 * @param $file
	 * @param $contents
	 * @param bool $createDirectory
	 * @param int $chmod
	 * @param bool $need
	 * @return int
	 * @throws \Flame\FileNotWritableException
	 */
	public static function write($file, $contents, $createDirectory = true, $chmod = 0777, $need = true)
	{
		$createDirectory && static::mkDir(dirname($file), true, $chmod);

		if (false === ($result = @file_put_contents($file, $contents)) && $need) {
			throw Flame\FileNotWritableException::fromFile($file);
		}
		@chmod($file, $chmod);

		return $result;
	}


	/**
	 * @param $file
	 * @param bool $need
	 * @return string
	 * @throws \Flame\FileNotFoundException
	 */
	public static function read($file, $need = true)
	{
		if (false === ($contents = @file_get_contents($file)) && $need) {
			throw new Flame\FileNotFoundException('File "' . $file . '" is not readable.');
		}

		return $contents;
	}

	/**
	 * @param $source
	 * @param $dest
	 * @param bool $need
	 * @return bool
	 */
	public static function cp($source, $dest, $need = true)
	{
		$destFolder = str_replace(DIRECTORY_SEPARATOR . static::getFileName($dest), '', $dest);

		if(!file_exists($destFolder)){
			static::mkDir($destFolder, true, 0777, $need);
		}

		return copy($source, $dest);
	}

	/**
	 * @param $path
	 * @return mixed
	 */
	public static function getFileName($path)
	{
		if(strpos($path, DIRECTORY_SEPARATOR) === false){
			return $path;
		}else{
			return str_replace(DIRECTORY_SEPARATOR, '', strrchr($path, DIRECTORY_SEPARATOR));
		}
	}

}
