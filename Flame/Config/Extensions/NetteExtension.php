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
			'helperLoaders' => '',
			'helpers' => array(),
		)
	);

	/**
	 * @var \Nette\DI\ContainerBuilder $container
	 */
	private $containerBuilder;

	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$this->containerBuilder = $this->getContainerBuilder();
		$this->setupTemplating($this->getConfig($this->helpersDefauls));
	}

	private function setupTemplating(array $config)
	{

		$latte = $this->containerBuilder->getDefinition($this->prefix('latte'));

		$this->containerBuilder->removeDefinition($this->prefix('template'));
		$template = $this->containerBuilder->addDefinition($this->prefix('template'))
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

		if(count($config['template']['helpers'])){
			foreach($config['template']['helpers'] as $helper){
				$template->addSetup(
					'registerHelper',
					array($helper['method'], array($this->createHelperService($helper), $helper['method']))
				);
			}
		}

		if(!empty($config['template']['helperLoaders'])){
			$helperLoaders = $config['template']['helperLoaders'];

			if (strpos($helperLoaders, '::') === false) {
				$helperLoaders .= '::loader';
				$template->addSetup('registerHelperLoader', array($helperLoaders));
			}
		}

	}

	/**
	 * @param $helper
	 * @return object
	 */
	private function createHelperService($helper)
	{
		$attributes = $this->expandAttributes($this->containerBuilder, $helper['class']->{'attributes'});
		$helperService = new \ReflectionClass($helper['class']->{'value'});
		return $helperService->newInstance($attributes);
	}

	/**
	 * @param $atributes
	 * @return array
	 */
	private function expandAttributes($atributes)
	{
		$prepared = array();
		if(count($atributes)){
			foreach($atributes as $atribute){
				$prepared[] = $this->containerBuilder->expand($atribute);
			}
		}

		return $prepared;
	}

}
