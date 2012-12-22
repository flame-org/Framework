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

	public $helpersDefauls = array(
		'template' => array(
			'helperLoaders' => '\Nette\Templating\Helpers',
			'helpers' => array(),
		)
	);

	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$container = $this->getContainerBuilder();
		$config = $this->getConfig($this->helpersDefauls);
		$this->compiler->parseServices($container, array());

		$this->setupTemplating($container, $config);
	}

	private function setupTemplating(\Nette\DI\ContainerBuilder $container, array $config)
	{

		$latte = $container->getDefinition($this->prefix('latte'));
		$helperLoaders = $config['template']['helperLoaders'];

		if (strpos($helperLoaders, '::') === false) {
			$helperLoaders .= '::loader';
		}

		$container->removeDefinition($this->prefix('template'));
		$template = $container->addDefinition($this->prefix('template'))
			->setClass('Nette\Templating\ITemplate')
			->setFactory('? ? new ? : new Nette\Templating\FileTemplate', array('%class%', new Nette\PhpGenerator\PhpLiteral('?'), '%class%'))
			->setParameters(array('class' => null))
			->setImplement('Flame\Templating\ITemplateFactory')
			->addSetup('registerFilter', array($latte))
			->addSetup('registerHelperLoader', array($helperLoaders))
			->addSetup('setCacheStorage', array($this->prefix('@templateCacheStorage')))
			->addSetup('$service->presenter = $service->_presenter = ?', array(new Nette\DI\Statement('@application::getPresenter')))
			->addSetup('$service->control = $service->_control = ?', array(new Nette\DI\Statement('@application::getPresenter')))
			->addSetup('$user', array('@user'))
			->addSetup('$netteHttpResponse', array('@httpResponse'))
			->addSetup('$netteCacheStorage', array('@cacheStorage'))
			->addSetup('$service->baseUri = $service->baseUrl = rtrim(?->getBaseUrl(), "/")', array(new Nette\DI\Statement('@httpRequest::getUrl')))
			->addSetup('$service->basePath = preg_replace(?, "", $service->baseUrl)', array('#https?://[^/]+#A'))
			->setAutowired(true);

		if(count($config['template']['helpers'])){
			foreach($config['template']['helpers'] as $helper){
				$attributes = $this->expandAttributes($container, $helper['class']->{'attributes'});
				$helperService = new \ReflectionClass($helper['class']->{'value'});
				$helperService = $helperService->newInstanceArgs($attributes);
				$template->addSetup('registerHelper', array($helper['method'], array($helperService, $helper['method'])));
			}
		}

	}

	/**
	 * @param \Nette\DI\ContainerBuilder $container
	 * @param $atributes
	 * @return array
	 */
	private function expandAttributes(\Nette\DI\ContainerBuilder $container, $atributes)
	{
		$prepared = array();
		if(count($atributes)){
			foreach($atributes as $atribute){
				$prepared[] = $container->expand($atribute);
			}
		}

		return $prepared;
	}

}
