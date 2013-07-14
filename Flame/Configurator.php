<?php
/**
 * Configurator.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    21.07.12
 */

namespace Flame;

use Flame\Bundles\Loaders\BundlesLoader;
use Nette;

class Configurator extends Nette\Configurator
{

	/**
	 * @param $name
	 * @param $default
	 * @return mixed
	 */
	public function getParameter($name, $default = null)
	{
		return (isset($this->parameters[$name])) ? $this->parameters[$name] : $default;
	}

	/**
	 * @param $name
	 * @param $class
	 */
	public function registerExtension($name, $class)
	{
		$this->onCompile[] = function (Nette\Configurator $configurator, Nette\DI\Compiler $compiler) use ($name, $class) {
			$compiler->addExtension($name, new $class);
		};
	}

	/**
	 * @param $name
	 * @param $class
	 */
	public function registerExtensionOnce($name, $class)
	{
		$this->onCompile[] = function (Nette\Configurator $configurator, Nette\DI\Compiler $compiler) use ($name, $class) {
			$extensions = $compiler->getExtensions();
			if(!isset($extensions[$name])) {
				$compiler->addExtension($name, new $class);
			}
		};
	}

	/**
	 * @param Nette\Loaders\RobotLoader $loader
	 * @return BundlesLoader
	 */
	public function createBundlesLoader(Nette\Loaders\RobotLoader $loader = null)
	{
		return new BundlesLoader($this, $loader);
	}
}
