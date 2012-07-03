<?php

use Nette\Environment;

class SeleniumTestCase extends PHPUnit_Extensions_Selenium2TestCase
{

	public function setUp()
	{
		$params = $this->getContainer()->getParameters();
		$seleniumConfiguration = $params['selenium'];
		$this->setHost($seleniumConfiguration['host']);
		$this->setBrowser($seleniumConfiguration['browser']);
		$this->setBrowserUrl($seleniumConfiguration['browserUrl']);
		if ($seleniumConfiguration['port']) {
			$this->setPort((int) $seleniumConfiguration['port']);
		}
	}

	public function getContainer()
	{
		return Environment::getService('container');
	}

}