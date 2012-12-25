<?php
/**
 * Arrays.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    25.12.12
 */

namespace Flame\Utils;

final class Arrays extends \Nette\Object
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
	 * Mirror of Nette\Utils\Arrays
	 *
	 * @param string $name
	 * @param array $args
	 * @return mixed
	 */
	public static function __callStatic($name, $args)
	{
		return \Nette\Callback::create('Nette\Utils\Arrays', $name)->invokeArgs($args);
	}

	/**
	 * @param $array
	 * @param $subkey
	 * @param int $sortType
	 * @return mixed
	 */
	public static function sortBySubkey(&$array, $subkey, $sortType = SORT_ASC) {
		foreach ($array as $subarray) {
			$keys[] = $subarray->$subkey;
		}

		array_multisort($keys, $sortType, $array);
		return $array;
	}
}
