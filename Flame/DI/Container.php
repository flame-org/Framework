<?php
/**
 * Container.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    21.07.12
 */

namespace Flame\DI;

class Container extends \Nette\DI\Container
{

	public function getParam($key, $default = null)
	{
		if(isset($this->parameters[$key])){
			return $this->parameters[$key];
		}else{
			return $default;
		}
	}

}
