<?php
/**
 * Class IRouter
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 28.04.13
 */

namespace Flame\Bundles\Router;

interface IRouter
{

	/**
	 * @return array
	 */
	public function getRouteList();
}