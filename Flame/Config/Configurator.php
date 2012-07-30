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

		$this->addParameters(array('container' => array('class' => 'SystemContainer', 'parent' => $containerClass)));
	}

	public function setOptionalParameters()
	{
		//$baseUrl = rtrim($this->container->httpRequest->getUrl()->getBaseUrl(), '/');

		$this->addParameters(array(
//			'baseUrl' => $baseUrl,
//			'basePath' => preg_replace('#https?://[^/]+#A', '', $baseUrl),
			'flameDir' => realpath(FLAME_DIR),
		));
	}

}
