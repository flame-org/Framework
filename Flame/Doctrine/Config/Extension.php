<?php
/**
 * Extension.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date    24.02.13
 */

namespace Flame\Doctrine\Config;

class Extension extends \Nette\Config\CompilerExtension
{

	/** @var array */
	public $defaults = array(
		'debugger' => null,
		'tablePrefix' => true,
		'connection' => array(
			'prefix' => '',
			'driver' => 'pdo_mysql',
			'charset' => 'utf8',
			'port' => '3306',
			'collation' => false,
			'autowired' => false,
		),
		'entityDirs' => array('%appDir%'),
		'proxyDir' => '%rootDir%/temp/proxy',
		'repositoryClass' => 'Flame\Doctrine\Model\Repository',
	);

	public function loadConfiguration()
	{
		$this->verifyDoctrineVersion();

		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		if ($config['debugger'] === null)
			$config['debugger'] = $builder->parameters['debugMode'];

		$this->compiler->parseServices($builder, $config, $this->name);

		$mappingStrategy = $builder->addDefinition($this->prefix('mappingStrategy'))
			->setClass('\Doctrine\ORM\Mapping\UnderscoreNamingStrategy');

		$eventManager = $builder->addDefinition($this->prefix('eventManager'))
			->setClass('\Doctrine\Common\EventManager');

		if($config['tablePrefix']){

			$tablePrefix = $builder->addDefinition($this->prefix('tablePrefix'))
				->setClass('\Flame\Doctrine\TablePrefix', array($config['connection']['prefix']));

			$eventManager->addSetup('addEventListener', array('loadClassMetadata', $tablePrefix));
		}

		$cache = $builder->addDefinition($this->prefix('cache'))
			->setClass('Flame\Doctrine\Cache', array('@cacheStorage'));

		$configuration = $builder->addDefinition($this->prefix('configuration'))
			->setClass('\Doctrine\ORM\Configuration')
			->addSetup('setProxyDir', array($config['proxyDir']))
			->addSetup('setNamingStrategy', array($mappingStrategy))
			->addSetup('setDefaultRepositoryClassName', array($config['repositoryClass']))
			->addSetup('setMetadataCacheImpl', array($cache))
			->addSetup('setQueryCacheImpl', array($cache))
			->addSetup('setResultCacheImpl', array($cache));

		if($config['debugger']){
			$sqlLogger = $builder->addDefinition($this->prefix('sqlLogger'))
				->setClass('Flame\Doctrine\Diagnostics\ConnectionPanel')
				->setFactory('Flame\Doctrine\Diagnostics\ConnectionPanel::register');
			$configuration->addSetup('setSQLLogger', array($sqlLogger));
		}

		$entityManager = $builder->addDefinition($this->prefix('entityManager'))
			->setClass('Doctrine\ORM\EntityManager')
			->setFactory('Doctrine\ORM\EntityManager::create', array($config['connection'], $configuration, $eventManager));

	}

	public function beforeCompile()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();
		$cache = $builder->getDefinition($this->prefix('cache'));
		$configuration = $builder->getDefinition($this->prefix('configuration'));
		$configuration->setFactory('Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration',
				array($config['entityDirs'], $builder->parameters['debugMode'], $config['proxyDir'], $cache));
	}

	/**
	 * @throws \Nette\InvalidStateException
	 */
	protected function verifyDoctrineVersion()
	{
		if (!class_exists('Doctrine\ORM\Version')) {
			throw new \Nette\InvalidStateException('Doctrine ORM does not exists');
		} elseif (\Doctrine\ORM\Version::compare('2.3.0-RC3') > 0) {
			throw new \Nette\InvalidStateException(
				'Doctrine version ' . \Doctrine\ORM\Version::VERSION . ' not supported (support only for 2.3+)'
			);
		}
	}

}
