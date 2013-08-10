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

use Nette\Object;
use Nette\StaticClassException;

final class Arrays extends Object
{

	/**
	 * Static class - cannot be instantiated.
	 *
	 * @throws StaticClassException
	 */
	final public function __construct()
	{
		throw new StaticClassException;
	}

	/**
	 * @param     $array
	 * @param     $subkey
	 * @param int $sortType
	 * @return mixed
	 */
	public static function sortBySubKey(&$array, $subkey, $sortType = SORT_ASC)
	{
		if (count($array)) {
			foreach ($array as $subarray) {
				$keys[] = $subarray[$subkey];
			}
			array_multisort($keys, $sortType, $array);
		}

		return $array;
	}

	/**
	 * @param     $array
	 * @param     $subkey
	 * @param int $sortType
	 * @return mixed
	 */
	public static function sortByProperty(&$array, $subkey, $sortType = SORT_ASC)
	{
		if (count($array)) {
			foreach ($array as $subarray) {
				$keys[] = $subarray->$subkey;
			}
			
			array_multisort($keys, $sortType, $array);
		}

		return $array;
	}

	/**
	 * @param $needle
	 * @param $haystack
	 * @return bool|int|string
	 */
	public static function recursiveSearch($needle, &$haystack)
	{
		if (count($haystack)) {
			foreach ($haystack as $key => $value) {
				$current_key = $key;
				if ($needle === $value OR (is_array($value) && static::recursiveSearch($needle, $value) !== false)) {
					return $current_key;
				}
			}
		}

		return false;
	}
}
