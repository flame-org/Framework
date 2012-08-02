<?php
/**
 * PresenterFactory.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    02.08.12
 */

namespace Flame\Application;

class PresenterFactory implements \Nette\Application\PresenterFactory
{

	private $container;

	public function __construct($baseDir, \Nette\DI\Container $container)
	{
		parent::__construct($baseDir, $container);
		$this->container = $container;
	}

	public function createPresenter($name)
	{
		$presenter = parent::createPresenter($name);
		foreach (array_reverse(get_class_methods($presenter)) as $method) {
			if (substr($method, 0, 6) === 'inject') {
				$this->container->callMethod(array($presenter, $method));
			}
		}
		return $presenter;
	}

}
