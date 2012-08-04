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

	public function __construct($containerClass = 'Flame\DI\Container')
	{
		parent::__construct();

		$this->addParameters(array(
			'container' => array(
				'class' => 'SystemContainer',
				'parent' => $containerClass
			)
		));

		$this->addParameters($this->getOptionalParameters());
	}

	protected function getOptionalParameters()
	{
		 return array(
			'flameDir' => realpath(FLAME_DIR)
		);
	}
}
