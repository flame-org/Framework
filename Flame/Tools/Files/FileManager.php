<?php
/**
 * FileManager.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    13.12.12
 */

namespace Flame\Tools\Files;

use Flame\Utils\Strings;

class FileManager extends \Nette\Object
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
	 * Save upladed file and return absolute path
	 * @param \Nette\Http\FileUpload $file
	 * @param string $dir
	 * @return string
	 * @throws \Nette\InvalidArgumentException
	 */
	public static function saveFile(\Nette\Http\FileUpload $file, $dir = 'images')
	{

		if(!$file->isOk())
			throw new \Nette\InvalidArgumentException('File ' . $file->name . ' is not valid.');

		FileSystem::mkDir($dir, true, 0777, false);
		$name = Strings::webalize(static::removeFileType($file->name)) . '.' . static::getFileType($file->name);
		$filePath = $dir . DIRECTORY_SEPARATOR . $name;

		if(!file_exists($filePath)){
			$file->move($filePath);
		}else{
			$new_name = Strings::random(5) . '_' . $name;
			$file->move(str_replace($name, $new_name, $filePath));
			$name = $new_name;
		}

		return $dir . DIRECTORY_SEPARATOR . $name;
	}

	/**
	 * @param $url
	 * @param string $dir
	 * @return bool|int
	 */
	public static function downloadFile($url, $dir = 'images')
	{
		$fileDir = $dir . DIRECTORY_SEPARATOR . static::getFileName($url);

		if($file = FileSystem::read($url, false))
			return FileSystem::write($fileDir, $file, true, 0777, false);

		return false;
	}

	/**
	 * Return ending of filename
	 * @param $name
	 * @return null
	 */
	public static function getFileType($name)
	{
		$neeadles = explode('.', $name);
		$last = count($neeadles) - 1;
		return (isset($neeadles[$last])) ? $neeadles[$last] : null;
	}

	/**
	 * Return name of file without ending
	 * @param $name
	 * @return mixed
	 */
	public static function removeFileType($name)
	{
		return str_replace('.' . static::getFileType($name), '', $name);
	}

	/**
	 * Return name of file from URL or absolute path
	 * @param $path
	 * @return null
	 */
	public static function getFileName($path)
	{
		$parts = explode(DIRECTORY_SEPARATOR, $path);
		$index = count($parts) - 1;
		return isset($parts[$index]) ? $parts[$index] : null;
	}

}
