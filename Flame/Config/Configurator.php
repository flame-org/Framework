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
		$baseUrl = '';

		$this->addParameters(array(
			'baseUrl' => $baseUrl,
			'basePath' => preg_replace('#https?://[^/]+#A', '', $baseUrl),
			'flameDir' => realpath(FLAME_DIR),
		));
	}

	public function setDatabaseParametersFromEnv()
	{
		if(isset($_SERVER['DB1_HOST'], $_SERVER['DB1_NAME'], $_SERVER['DB1_USER'], $_SERVER['DB1_PASS'])){
			$this->addParameters(array(
				'parameters' => array(
					'database' => array(
						'host' => $_SERVER['DB1_HOST'],
						'dbname' => $_SERVER['DB1_NAME'],
						'user' => $_SERVER['DB1_USER'],
						'password' => $_SERVER['DB1_PASS'],
					),
				),
			));
		}
	}

}
