<?php
/**
 * Extension.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    25.02.13
 */

namespace Flame\Bundles\Config;

use Nette\InvalidArgumentException;
use Nette\InvalidStateException;

class Extension extends \Nette\Config\CompilerExtension
{

	/**
	 * @var array
	 */
	public $defaults = array();

	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		if(count($config)){
			foreach($config as $name => $extension){
				if(!is_string($name))
					throw new InvalidStateException('Must be defined extension\'s name');

				$this->compiler->addExtension($name, $this->invokeExtension($extension));
			}
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
			$extension = $this->createExtension($class);

		}elseif(is_object($class)){

			$ref = new \ReflectionClass($class->value);
			$args = array();
			if(property_exists($class, 'attributes')){
				$args = $builder->expand($class->attributes);
				$args = array_shift($args);
			}
			$extension = $ref->newInstance($args);

		}elseif(is_string($class)){
			$extension = new $class;

		}else{
			throw new InvalidStateException('Definition of extension must be valid class (string or object). ' . gettype($class) . ' given.');
		}

		if(!$extension instanceof \Flame\Bundles\IBundle)
			throw new InvalidArgumentException('Extension must implment \Flame\Bundles\IBundle' );

		return $extension;
	}

	/**
	 * @param array $configs
	 * @return \Flame\Bundles\BundleExtension
	 */
	protected function createExtension(array $configs = array())
	{
		return new \Flame\Bundles\BundleExtension($configs);
	}

}
