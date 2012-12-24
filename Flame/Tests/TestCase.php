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

abstract class TestCase extends \PHPUnit_Framework_TestCase
{

	/**
	 * @return \Nette\DI\Container|\SystemContainer
	 */
	protected function getContext()
	{
		return \Nette\Environment::getContext();
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
	 * @param string $class
	 * @param string $name
	 * @return \ReflectionMethod
	 */
	protected function getProtectedClassMethod($class, $name) {
		$class = new \ReflectionClass($class);
		$method = $class->getMethod($name);
		$method->setAccessible(true);
		return $method;
	}


}
