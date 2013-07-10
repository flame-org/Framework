<?php
/**
 * Manager.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    15.02.13
 */

namespace Flame\Utils;

use Nette\ArrayHash;
use Nette\InvalidArgumentException;
use Nette\Object;
use Nette\StaticClassException;

class Validator extends Object
{

	/**
	 * @throws StaticClassException
	 */
	final public function __construct()
	{
		throw new StaticClassException;
	}

	/**
	 * @param $input
	 * @param array $required
	 * @return \Nette\ArrayHash
	 * @throws \Nette\InvalidArgumentException
	 */
	public static function invalidate($input, array $required = array())
	{
		if (count($required)) {
			foreach ($required as $require) {
				if (!array_key_exists($require, $input))
					throw new InvalidArgumentException('Missing argument "' . $require . '"');
			}
		}

		return static::getHash($input);
	}

	/**
	 * @param $input
	 * @return \Nette\ArrayHash
	 */
	public static function getHash($input)
	{
		return ArrayHash::from($input);
	}

	/**
	 * @param $input
	 * @return null
	 */
	public static function getId($input)
	{
		return (isset($input['id'])) ? $input['id'] : null;
	}

}
