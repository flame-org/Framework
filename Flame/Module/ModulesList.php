<?php
/**
 * ModulesList.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    23.08.12
 */

namespace Flame\Module;

class ModulesList extends \Flame\Config\CompilerExtension
{

	private $moduleLoader;

	public function __construct(LoadModule $loadModule)
	{
		$this->moduleLoader = $loadModule;
	}

	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();
		$config = $this->getConfig();

		foreach ($config as $name => $class) {
			$this->compileModule($class, $name);
		}
	}

}
