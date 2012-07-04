<?php

use Nette\Environment;

abstract class IntegrationTestCase extends PHPUnit_Framework_TestCase
{
	/**
	 * @return \Nette\DI\Container
	 */
	public function getContainer()
	{
		return Environment::getService('container');
	}

}