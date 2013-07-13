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

use Nette;

class Configurator extends Nette\Configurator
{

	public function __construct()
	{
		parent::__construct();

		$this->addParameters(array(
			'rootDir' => '%appDir%/..',
			'wwwDir' => '%appDir%/../www'
		));
	}

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
}
