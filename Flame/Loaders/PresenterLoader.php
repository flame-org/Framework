<?php
/**
 * PresenterLoader.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    11.12.12
 */

namespace Flame\Loaders;

class PresenterLoader extends \Nette\Object
{

	/**
	 * @var \Nette\Loaders\RobotLoader
	 */
	private $robotLoader;

	/**
	 * @var string
	 */
	private $appDir;

	/**
	 * @param \Nette\Loaders\RobotLoader $robotLoader
	 * @param string $appDir
	 */
	public function __construct(\Nette\Loaders\RobotLoader $robotLoader, $appDir = '')
	{
		$this->robotLoader = $robotLoader;
		$this->appDir = realpath((string) $appDir);
	}

	/**
	 * @param $appDir
	 */
	public function setAppDirectory($appDir)
	{
		$this->appDir = realpath((string) $appDir);
	}

	/**
	 * @param $namespace
	 * @throws \Nette\FileNotFoundException
	 */
	public function load($namespace)
	{
		$modulePath = $this->appDir . DIRECTORY_SEPARATOR . $namespace . DIRECTORY_SEPARATOR . 'presenters';

		if(!file_exists($modulePath))
			throw new \Nette\FileNotFoundException('Module path ' . $modulePath . ' not found!');

		$this->robotLoader->addDirectory($modulePath);
		$this->robotLoader->setCacheStorage(new \Nette\Caching\Storages\FileStorage($this->appDir . '/../temp/cache'));
		$this->robotLoader->register();
	}

	/**
	 * @return array
	 */
	public function getCLasses()
	{
		return $this->robotLoader->getIndexedClasses();
	}

	/**
	 * @return array
	 */
	public function getPresenters()
	{
		$classes = $this->robotLoader->getIndexedClasses();

		if(count($classes)){
			$classes = array_keys($classes);
			$classes = array_map(function ($class){
				$parts = explode('\\', $class);
				$class = (isset($parts[count($parts) - 1])) ? $parts[count($parts) - 1] : $class;
				return str_replace('Presenter', '', $class);
			}, $classes);
		}

		return $classes;
	}

}
