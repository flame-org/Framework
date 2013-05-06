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
	 * @param $name
	 * @param $args
	 * @return mixed
	 */
	public static function __callStatic($name, $args)
	{
		return \Nette\Callback::create('Nette\Utils\Arrays', $name)->invokeArgs($args);
	}

	/**
	 * @param     $array
	 * @param     $subkey
	 * @param int $sortType
	 * @return mixed
	 */
	public static function sortBySubkey(&$array, $subkey, $sortType = SORT_ASC)
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

			return false;
		}
	}

	/**
	 * @param $array
	 * @return array
	 */
	public static function getValidValues(&$array)
	{
		$valid = array();
		if (count($array)) {
			foreach ($array as $item) {
				if ($item)
					$valid[] = $item;
			}
		}

		return $valid;
	}

	/**
	 * @param $xmlObject
	 * @return mixed
	 */
	public static function xmlToArray($xmlObject)
	{
		return json_decode(json_encode((array)$xmlObject), 1);
	}
}
