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

	/** @var \Nette\DI\Container */
	protected $context;

	/**
	 * @param \Nette\DI\Container $container
	 */
	public function __construct(\Nette\DI\Container $container = null)
	{
		$this->context = $container;
	}

	/**
	 * @param $name
	 * @param null $default
	 * @return null
	 */
	protected function getContextParameter($name, $default = null)
	{
		$params = $this->context->getParameters();
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

}
