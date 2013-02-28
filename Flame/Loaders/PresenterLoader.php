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

use Flame\Utils\Strings;

class PresenterLoader extends \Nette\Object
{

	/** @var \Nette\Loaders\RobotLoader */
	private $robotLoader;

	/** @var string */
	private $appDir;

	/**
	 * @param \Nette\Loaders\RobotLoader $robotLoader
	 */
	public function __construct(\Nette\Loaders\RobotLoader $robotLoader)
	{
		$this->robotLoader = $robotLoader;
	}

	/**
	 * @param $appDir
	 * @return PresenterLoader
	 */
	public function setAppDir($appDir)
	{
		$this->appDir = realpath((string) $appDir);
		return $this;
	}

	/**
	 * @param string $subDir
	 * @return PresenterLoader
	 */
	public function load($subDir = '')
	{
		$dir = $this->appDir;
		if(!empty($subDir)){
			if(Strings::startsWith($subDir, DIRECTORY_SEPARATOR)){
				$dir .= $subDir;
			}else{
				$dir .= DIRECTORY_SEPARATOR . $subDir;
			}
		}

		$this->robotLoader->addDirectory($dir);
		$this->robotLoader->setCacheStorage(new \Nette\Caching\Storages\FileStorage($this->appDir . '/../temp/cache'));
		$this->robotLoader->register();

		return $this;
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
		$classes = $this->getCLasses();

		if(count($classes)){
			$classes = array_keys($classes);
			$classes = array_map(function ($class){
				if(Strings::contains($class, 'Presenter')){
					return str_replace('Presenter', '', Strings::getLastPiece($class, '\\'));
				}

			}, $classes);

			return \Flame\Utils\Arrays::getValidValues($classes);
		}else{
			return array();
		}
	}

}
