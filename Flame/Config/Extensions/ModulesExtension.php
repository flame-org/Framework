<?php
/**
 * ModuleExtension.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    19.02.13
 */

namespace Flame\Config\Extensions;

class ModulesExtension extends \Nette\Config\CompilerExtension
{

	public function loadConfiguration()
	{
		$config = $this->getConfig();

		if(is_array($config)){
			if(count($config)){
				foreach($config as $name => $extension){
					if(!is_string($name))
						$name = $this->getExtensionName($extension);
					$this->compiler->addExtension($name, $this->invokeExtension($extension));
				}
			}
		}else{
			throw new \Nette\InvalidStateException('Modules configuration must be array.' . gettype($config) . ' given');
		}
	}

	/**
	 * @param $class
	 * @return string
	 */
	protected function getExtensionName($class)
	{
		$ref = \Nette\Reflection\ClassType::from($class);
		return $ref->getShortName();
	}

	/**
	 * @param $class
	 * @return mixed
	 * @throws \Nette\InvalidStateException
	 */
	protected function invokeExtension($class)
	{
		$builder = $this->getContainerBuilder();
		if(is_object($class)){
			$ref = new \ReflectionClass($class->value);
			return $ref->newInstance(property_exists($class, 'attributes') ? $builder->expand($class->attributes) : array());
		}elseif(is_string($class)){
			return new $class;
		}else{
			throw new \Nette\InvalidStateException('Definition of extension must be valid class (string or object). ' . gettype($class) . ' given.');
		}
	}

}
