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

namespace Flame\Tests\Config;

require_once __DIR__ . '/../bootstrap.php';

use Nette\Config\Extensions;
use Tester\Assert;

class ConfiguratorTest extends \Flame\Tests\TestCase
{

	/** @var \Flame\Config\Configurator */
	private $configurator;

	public function setUp()
	{
		$this->configurator = new \Flame\Config\Configurator();
		$this->configurator->setTempDirectory(TEMP_DIR);
	}

	public function testProperties()
	{
		//TODO:
	}

	public function testCreateCompiler()
	{
		$compiler = new \Nette\Config\Compiler();
		$compiler->addExtension('php', new Extensions\PhpExtension)
			->addExtension('constants', new Extensions\ConstantsExtension)
			->addExtension('nette', new \Flame\Config\Extensions\NetteExtension)
			->addExtension('extensions', new Extensions\ExtensionsExtension);

		$r = $this->invokeMethod($this->configurator, 'createCompiler');
		$extension = $this->getAttributeValue($r, 'extensions');
		Assert::false(empty($extension));
		Assert::true(count($extension) == 4);
	}

}

run(new ConfiguratorTest());
