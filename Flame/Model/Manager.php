<?php
/**
 * Manager.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    15.02.13
 */

namespace Flame\Model;

use Nette\InvalidArgumentException;

abstract class Manager extends \Nette\Object
{

	/**
	 * @param $input
	 * @param array $required
	 * @return \Nette\ArrayHash
	 * @throws \Nette\InvalidArgumentException
	 */
	protected function validateInput($input, array $required = array())
	{

		if(count($required)){
			foreach($required as $require){
				if(!$this->keyExist($require, $input))
					throw new InvalidArgumentException('Missing argument "' . $require . '"');
			}
		}

		return $this->getHash($input);
	}

	/**
	 * @param $key
	 * @param array $input
	 * @return bool
	 */
	protected function keyExist($key, $input)
	{
		return array_key_exists($key, $input);
	}

	/**
	 * @param $input
	 * @return \Nette\ArrayHash
	 */
	protected function getHash($input)
	{
		return \Nette\ArrayHash::from($input);
	}

	/**
	 * @param $input
	 * @return null
	 */
	protected function getId($input)
	{
		return (isset($input['id'])) ? $input['id'] : null;
	}

}
