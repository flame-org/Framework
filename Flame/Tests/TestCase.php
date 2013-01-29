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

abstract class TestCase extends Reflection
{

	/**
	 * @return \Nette\DI\Container|\SystemContainer
	 */
	protected function getContext()
	{
		return \Nette\Environment::getContext();
	}

	/**
	 * @return bool
	 */
	protected function isInternetConnection()
	{
		if ('pong' !== @file_get_contents('http://ping.jsifalda.name/')) {
			return false;
		}else{
			return true;
		}
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

	protected function tearDown()
	{
		if(class_exists('\Mockery')){
			\Mockery::close();
		}
	}

}
