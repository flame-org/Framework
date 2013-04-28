<?php
/**
 * TestCase.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    19.10.12
 */

namespace Flame\Tests;

use Nette\DI\Container;
use Nette\ObjectMixin;
use Nette\Reflection\ClassType;
use Tester;

abstract class TestCase extends Tester\TestCase
{

	/** @var \Nette\DI\Container */
	protected $context;

	/**
	 * @param \Nette\DI\Container $container
	 */
	public function __construct(Container $container = null)
	{
		$this->context = $container;
	}

	/**
	 * @return Container
	 */
	public function getContext()
	{
		return $this->context;
	}

	/**
	 * @param $name
	 * @param null $default
	 * @return null
	 */
	protected function getContextParameter($name, $default = null)
	{
		$params = $this->getContext()->getParameters();
		return (isset($params[$name])) ? $params[$name] : $default;
	}

	/**
	 * @return bool
	 */
	protected function isInternetConnection()
	{
		if ('pong' !== @file_get_contents('http://ping.jsifalda.name/')) {
			return false;
		} else {
			return true;
		}
	}

	/********************* Nette\Object behaviour ****************d*g**/

	/**
	 * @return \Nette\Reflection\ClassType
	 */
	public static function getReflection()
	{
		return new ClassType(get_called_class());
	}

	/**
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function &__get($name)
	{
		return ObjectMixin::get($this, $name);
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value)
	{
		ObjectMixin::set($this, $name, $value);
	}

	/**
	 * @param string $name
	 * @param array $args
	 * @return mixed
	 */
	public function __call($name, $args)
	{
		return ObjectMixin::call($this, $name, $args);
	}

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function __isset($name)
	{
		return ObjectMixin::has($this, $name);
	}

	/**
	 * @param string $name
	 */
	public function __unset($name)
	{
		ObjectMixin::remove($this, $name);
	}

}
