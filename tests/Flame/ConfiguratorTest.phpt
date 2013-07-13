<?php
/**
 * ConfiguratorTest.php
 *
 * @testCase
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    24.12.12
 */

namespace Flame\Tests;

$configurator = require_once __DIR__ . '/bootstrap.php';

use Tester\Assert;

class ConfiguratorTest extends \Flame\Tester\TestCase
{

	/** @var \Flame\Configurator */
	private $configurator;

	public function setUp()
	{
		$this->configurator = new \Flame\Configurator();
	}

	public function testRegisterExtension()
	{
		Assert::null($this->configurator->onCompile);
		$this->configurator->registerExtension('ext', 'ext');
		Assert::same(1, count($this->configurator->onCompile));
	}

}

id(new ConfiguratorTest($configurator))->run();
