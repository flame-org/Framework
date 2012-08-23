<?php
/**
 * CompilerExtension.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    23.08.12
 */

namespace Flame\Config;

class CompilerExtension extends \Nette\Config\CompilerExtension
{

	const MODULE = 'module';

	protected function compileModule($class, $name)
	{
		$this->getContainerBuilder()
			->addDefinition($name)
			->setClass($class)
			->addTag(self::MODULE);
	}
}
