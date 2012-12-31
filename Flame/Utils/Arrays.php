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
	 * @param string $type
	 * @return mixed
	 * @throws \Nette\InvalidArgumentException
	 */
	public static function sortBySubkey(&$array, $subkey, $sortType = SORT_ASC, $type = 'array') {
		if($type == 'array'){
			foreach ($array as $subarray) {
				$keys[] = $subarray[$subkey];
			}
		}elseif($type == 'object'){
			foreach ($array as $subarray) {
				$keys[] = $subarray->$subkey;
			}
		}else{
			throw new \Nette\InvalidArgumentException('Wrong parameter $type. Is allowed only "array" or "object"');
		}


		array_multisort($keys, $sortType, $array);
		return $array;
	}
}
