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

	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$this->setupTemplating($this->getConfig($this->helpersDefauls));
	}

	/**
	 * @param array $config
	 */
	private function setupTemplating(array $config)
	{

		$latte = $this->getContainerBuilder()->getDefinition($this->prefix('latte'));

		$this->getContainerBuilder()->removeDefinition($this->prefix('template'));
		$template = $this->getContainerBuilder()->addDefinition($this->prefix('template'))
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
				list($helperClass, $helperMethod) = $this->getClassMethod($helper);
				$template->addSetup('registerHelper', array($helperMethod, array($helperClass, $helperMethod)));
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

	/**
	 * @param $atributes
	 * @return array
	 */
	private function expandAttributes($atributes)
	{
		$prepared = array();
		if(count($atributes)){
			foreach($atributes as $atribute){
				$prepared[] = $this->getContainerBuilder()->expand($atribute);
			}
		}

		return $prepared;
	}

}
