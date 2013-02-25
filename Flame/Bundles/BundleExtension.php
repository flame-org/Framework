<?php
/**
 * BundleExtension.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    25.02.13
 */

namespace Flame\Bundles;

use Nette\Config\Helpers;

class BundleExtension extends \Nette\Config\CompilerExtension implements IBundle
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
		if(count($this->configFiles)){
			foreach($this->configFiles as $configFile){
				$config = $this->loadFromFile($configFile);
				$this->compiler->parseServices($builder, $config);

				if(isset($config['parameters'])){
					$builder->parameters = Helpers::merge($builder->parameters, $config['parameters']);
				}
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
	 * @param $class
	 * @param string $method
	 */
	public function registerLatteMacro($class, $method = 'install')
	{
		$builder = $this->getContainerBuilder();
		$latte = $builder->getDefinition('nette.latte');
		$latte->addSetup($class . '::' . $method . '(?->compiler)', array('@self'));
	}
}
