<?php
/**
 * Extension.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    25.02.13
 */

namespace Flame\Bundles\Config;

use Flame\Bundles\Loaders\BundlesLoader;
use Nette\Configurator;
use Nette\Object;

class BundlesRegister extends Object
{

	/** @var \Flame\Bundles\Loaders\BundlesLoader */
	private $bundlesLoader;

	/**
	 * @param BundlesLoader $loader
	 */
	public function __construct(BundlesLoader $loader)
	{
		$this->bundlesLoader = $loader;
	}

	/**
	 * @param Configurator $configurator
	 */
	public function processConfigs(Configurator $configurator)
	{
		$classes = $this->getBundlesClasses();
		if (count($classes)) {
			foreach ($classes as $class) {
				$configs = $class->getConfigFiles();
				if (count($configs)) {
					foreach ($configs as $config) {
						$configurator->addConfig($config);
					}
				}
			}
		}
	}

	/**
	 * @return array
	 */
	public function getBundlesClasses()
	{
		return $this->bundlesLoader->getBundlesClasses();
	}

}
