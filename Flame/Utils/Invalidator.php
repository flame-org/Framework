<?php
/**
 * Class RESTHelper
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 12.05.13
 */
namespace Flame\Utils;

use Nette\StaticClassException;
use Nette\InvalidArgumentException;
use Nette\Object;
use Nette\Reflection\ClassType;

class Invalidator extends Object
{

	/**
	 * @throws StaticClassException
	 */
	final public function __construct()
	{
		throw new StaticClassException;
	}

	/**
	 * @param object $var
	 * @param bool $getPrivate
	 * @return array
	 * @throws \Nette\InvalidArgumentException
	 */
	public static function object($var, $getPrivate = true)
	{
		if(is_object($var)) {
			$valid = array();
			$vars = ClassType::from($var)->getProperties();
			if(count($vars)) {
				/** @var \Nette\Reflection\Property $property */
				foreach($vars as $property) {
					if(!$property->accessible && $getPrivate) {
						$property->setAccessible(true);
					}

					if($property->accessible) {
						$value = $property->getValue($var);
						if($value instanceof \DateTime){
							$valid[$property->getName()] = $value->getTimestamp();
						}elseif(!is_object($value)) {
							$valid[$property->getName()] = $value;
						}
					}
				}
			}

			return $valid;
		}else{
			throw new InvalidArgumentException('Parameter must be object. Given ' . gettype($var));
		}
	}

}