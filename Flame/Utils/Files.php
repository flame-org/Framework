<?php
/**
 * Assets.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    09.12.12
 */

namespace Flame\Utils;

use Nette\StaticClassException;
use Nette\Object;

class Files extends Object
{

	/**
	 * Static class - cannot be instantiated.
	 *
	 * @throws \Nette\StaticClassException
	 */
	final public function __construct()
	{
		throw new StaticClassException;
	}

	/**
	 * @param $path
	 * @return mixed
	 */
	public static function getFileName($path)
	{
		$path = preg_replace("#\\/#", DIRECTORY_SEPARATOR, $path);
		if (strpos($path, DIRECTORY_SEPARATOR) === false) {
			return $path;
		} else {
			return str_replace(DIRECTORY_SEPARATOR, '', strrchr($path, DIRECTORY_SEPARATOR));
		}
	}

	/**
	 * @param $path
	 * @return mixed
	 */
	public static function getFileExtension($path)
	{
		return pathinfo($path, PATHINFO_EXTENSION);
	}

	/**
	 * @param        $name
	 * @param string $oldType
	 * @param string $newType
	 * @return mixed
	 */
	public static function modifyType($name, $oldType = 'less', $newType = 'css')
	{
		return str_replace('.' . $oldType, '.' . $newType, $name);
	}

}
