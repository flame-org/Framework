<?php
/**
 * NetteExtension.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    21.12.12
 */

namespace Flame\Config\Extensions;

class NetteExtension extends \Nette\Config\Extensions\NetteExtension
{

	public $helpersDefauls = array(
		'template' => array(
			'helperLoaders' => '\Nette\Templating\Helpers',
		)
	);

	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$container = $this->getContainerBuilder();
		$config = $this->getConfig($this->helpersDefauls);

		$this->setupTemplating($container, $config);
	}

	private function setupTemplating(\Nette\DI\ContainerBuilder $container, array $config)
	{
		/** @var $latte \Nette\Latte\Engine */
		$latte = $container->getDefinition($this->prefix('latte'));


		//Prepared for configuration of helpers
//		if(isset($config['template']['helpers']) and count($config['template']['helpers'])){
//			foreach($config['template']['helpers'] as $helper){
//				$latte->addSetup($helper . '(?->compiler)', array('@self'));
//			}
//		}

		$helperLoaders = $config['template']['helperLoaders'];

		if (strpos($helperLoaders, '::') === false) {
			$helperLoaders .= '::loader';
		}

		$container->removeDefinition($this->prefix('template'));
		$container->addDefinition($this->prefix('template'))
			->setClass('Nette\Templating\FileTemplate')
			->addSetup('registerFilter', array($latte))
			->addSetup('registerHelperLoader', array($helperLoaders))
			->setShared(false);

	}

}
