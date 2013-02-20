<?php
/**
 * ModuleExtension.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    19.02.13
 */

namespace Flame\Config\Extensions;

use Nette\InvalidArgumentException;
use Nette\InvalidStateException;

class ModulesExtension extends \Nette\Config\CompilerExtension
{

	public function loadConfiguration()
	{
		$config = $this->getConfig();

		if(is_array($config)){
			if(count($config)){
				foreach($config as $name => $extension){
					if(!is_string($name))
						throw new InvalidStateException('Must be defined extension name');

					$this->compiler->addExtension($name, $this->invokeExtension($extension));
				}
			}
		}else{
			throw new InvalidStateException('Modules configuration must be array.' . gettype($config) . ' given');
		}
	}

	/**
	 * @param $class
	 * @return ModuleExtension|object
	 * @throws \Nette\InvalidStateException
	 * @throws \Nette\InvalidArgumentException
	 */
	protected function invokeExtension($class)
	{
		$builder = $this->getContainerBuilder();
		if(is_array($class)){
			return $this->createExtension($class);
		}elseif(is_object($class)){
			$ref = new \ReflectionClass($class->value);
			return $ref->newInstance(property_exists($class, 'attributes') ? $builder->expand($class->attributes) : array());
		}elseif(is_string($class)){
			$extension = new $class;
			if(!$extension instanceof ModuleExtension)
				throw new InvalidArgumentException('Extension must be instance of \Flame\Config\Extensions\ModuleExtension' );
			return $extension;
		}else{
			throw new InvalidStateException('Definition of extension must be valid class (string or object). ' . gettype($class) . ' given.');
		}
	}

	/**
	 * @param array $configs
	 * @return ModuleExtension
	 */
	protected function createExtension(array $configs = array())
	{
		return new ModuleExtension($configs);
	}

}
