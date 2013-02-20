<?php
/**
 * ModuleExtension.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    20.02.13
 */

namespace Flame\Config\Extensions;

use Flame\Utils\Strings;

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
		$config = $this->getConfig();

		foreach($this->getConfigFiles() as $configFile){
			$services = $this->loadFromFile($configFile);
			$this->compiler->parseServices($builder, $services);
			if(isset($services['parameters'])){
				$builder->parameters = \Nette\Config\Helpers::merge($builder->parameters, $services['parameters']);
			}
		}

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

