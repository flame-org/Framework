<?php
/**
 * ModuleExtension.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    20.02.13
 */

namespace Flame\Config\Extensions;

use Nette\Config\Helpers;

class ModuleExtension extends \Nette\Config\CompilerExtension
{

	/** @var array */
	private $configFiles = array();

	/**
	 * @param array $configFiles
	 */
	public function __construct(array $configFiles = array())
	{
		$this->configFiles = $configFiles;
	}

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$neonParser = new \Nette\Config\Adapters\NeonAdapter;
		foreach($this->getConfigFiles() as $configFile){
			$config = $this->loadFromFile($configFile);
			$this->compiler->parseServices($builder, $config);

			if(isset($config['parameters'])){
				$builder->parameters = Helpers::merge($builder->parameters, $config['parameters']);
			}
		}
	}

	/**
	 * @param $name
	 * @param $class
	 * @param null $method
	 */
	public function registerTemplateHelper($name, $class, $method = null)
	{
		if($method === null)
			$method = $name;

		$builder = $this->getContainerBuilder();
		$template = $builder->getDefinition('nette.template');
		$template->addSetup('registerHelper', array($name, array($class, $method)));
	}

	/**
	 * @param $class
	 * @param string $method
	 */
	public function registerTemplateHelperLoaders($class, $method = 'loader')
	{
		$builder = $this->getContainerBuilder();
		$template = $builder->getDefinition('nette.template');
		$template->addSetup('registerHelperLoader', array($class . '::' . $method));
	}

	/**
	 * @return array
	 */
	protected function getConfigFiles()
	{
		if(count($this->configFiles)){
			return array_map(function ($config) {
				if(is_array($config))
					$config = array_shift($config);
				return $config;
			}, $this->configFiles);
		}else{
			return array();
		}
	}
}

