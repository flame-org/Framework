<?php
/**
 * Class RouterFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 28.04.13
 */
namespace Flame\Bundles\Router;

use Nette\Application\Routers\RouteList;
use Nette\Object;

class RouterFactory extends Object
{

	/** @var \Nette\Application\Routers\RouteList */
	private $routeList;

	public function __construct()
	{
		$this->routeList = new RouteList;
	}

	/**
	 * @param IRouter $router
	 */
	public function register(IRouter $router)
	{
		$this->routeList[] = $router->getRouteList();
	}

	/**
	 * @return \Nette\Application\IRouter
	 */
	public function createRouter()
	{
		return $this->routeList;
	}

}