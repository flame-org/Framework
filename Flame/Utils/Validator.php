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

class Validator extends Object
{

	/**
	 * @param $input
	 * @param array $required
	 * @return \Nette\ArrayHash
	 * @throws \Nette\InvalidArgumentException
	 */
	public function invalidate($input, array $required = array())
	{
		if (count($required)) {
			foreach ($required as $require) {
				if (!$this->existKey($require, $input))
					throw new InvalidArgumentException('Missing argument "' . $require . '"');
			}
		}

		return $this->getHash($input);
	}

	/**
	 * @param $key
	 * @param $input
	 * @return bool
	 */
	public function existKey($key, $input)
	{
		return array_key_exists($key, $input);
	}

	/**
	 * @param $input
	 * @return \Nette\ArrayHash
	 */
	public function getHash($input)
	{
		return ArrayHash::from($input);
	}

	/**
	 * @param $input
	 * @return null
	 */
	public function getId($input)
	{
		return (isset($input['id'])) ? $input['id'] : null;
	}

}
