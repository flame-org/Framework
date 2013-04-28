<?php
/**
 * Configurator.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    21.07.12
 */

namespace Flame\Config;

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
	 * @param $class
	 */
	public function registerExtension($name, $class)
	{
		$this->onCompile[] = function ($configurator, $compiler) use ($name, $class) {
			$compiler->addExtension($name, new $class);
		};
	}
}
