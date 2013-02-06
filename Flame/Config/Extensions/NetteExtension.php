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

use Nette;

class NetteExtension extends \Nette\Config\Extensions\NetteExtension
{

	/**
	 * @var array
	 */
	public $helpersDefauls = array(
		'template' => array(
			'helperLoaders' => array(),
			'helpers' => array(),
		)
	);

	public function loadConfiguration()
	{
		parent::loadConfiguration();
		$this->setupTemplating($this->getContainerBuilder(), $this->getConfig($this->helpersDefauls));
	}

	/**
	 * @param \Nette\DI\ContainerBuilder $container
	 * @param array $config
	 */
	private function setupTemplating(\Nette\DI\ContainerBuilder $container, array $config)
	{

		$latte = $container->getDefinition($this->prefix('latte'));

		$container->removeDefinition($this->prefix('template'));
		$template = $container->addDefinition($this->prefix('template'))
			->setClass('Nette\Templating\ITemplate')
			->setFactory('? ? new ? : new Nette\Templating\FileTemplate', array('%class%', new Nette\PhpGenerator\PhpLiteral('?'), '%class%'))
			->setParameters(array('class' => null))
			->setImplement('Flame\Templating\ITemplateFactory')
			->addSetup('registerFilter', array($latte))
			->addSetup('registerHelperLoader', array('\Nette\Templating\Helpers::loader'))
			->addSetup('setCacheStorage', array($this->prefix('@templateCacheStorage')))
			->addSetup('$service->presenter = $service->_presenter = ?', array(new Nette\DI\Statement('@application::getPresenter')))
			->addSetup('$service->control = $service->_control = ?', array(new Nette\DI\Statement('@application::getPresenter')))
			->addSetup('$user', array('@user'))
			->addSetup('$netteHttpResponse', array('@httpResponse'))
			->addSetup('$netteCacheStorage', array('@cacheStorage'))
			->addSetup('$service->baseUri = $service->baseUrl = rtrim(?->getBaseUrl(), "/")', array(new Nette\DI\Statement('@httpRequest::getUrl')))
			->addSetup('$service->basePath = preg_replace(?, "", $service->baseUrl)', array('#https?://[^/]+#A'))
			->setAutowired(true);

		$helpers = $config['template']['helpers'];
		if(!is_array($helpers))
			throw new \Nette\InvalidStateException('Configuration of "template: helpers" must be array. ' . gettype($helpers) . ' given.');

		if(count($helpers)){
			foreach($helpers as $helperName => $helper){
				list($helperClass, $helperMethod) = $this->getClassMethod($helper);
				$template->addSetup('registerHelper', array($helperName, array($helperClass, $helperMethod)));
			}
		}

		$helperLoaders = $config['template']['helperLoaders'];
		if(!is_array($helperLoaders))
			throw new \Nette\InvalidStateException('Configuration of "template: helperLoaders" must be array. ' . gettype($helperLoaders) . ' given.');

		if(count($helperLoaders)){
			foreach($config['template']['helperLoaders'] as $loader){
				if (strpos($loader, '::') === false) {
					$loader .= '::loader';
					$template->addSetup('registerHelperLoader', array($loader));
				}
			}
		}

	}

	/**
	 * @param $helperClass
	 * @return array
	 */
	private function getClassMethod($helperClass)
	{
		if (strpos($helperClass, '::') !== false) {
			return explode('::', $helperClass);
		}

		return array($helperClass, 'run');
	}
}
