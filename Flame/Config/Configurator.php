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

class Configurator extends \Nette\Config\Configurator
{

	/**
	 * @param string $containerClass
	 */
	public function __construct($containerClass = 'Flame\DI\Container')
	{
		parent::__construct();

		$this->addParameters(array(
			'container' => array(
				'class' => 'SystemContainer',
				'parent' => $containerClass
			)
		));
	}

	/**
	 * @param $name
	 * @return Configurator
	 */
	public function setEnvironment($name)
	{
		$this->parameters['environment'] = $name;
		$this->parameters['consoleMode'] = $name === 'console' ?: PHP_SAPI === 'cli';
		return $this;
	}
}
