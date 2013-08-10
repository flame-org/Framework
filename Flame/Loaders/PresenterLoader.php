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
use Nette\Caching\Storages\FileStorage;
use Nette\Loaders\RobotLoader;
use Nette\Object;

class PresenterLoader extends Object
{

	/** @var \Nette\Loaders\RobotLoader */
	private $robotLoader;

	/** @var string */
	private $appDir;

	/**
	 * @param RobotLoader $robotLoader
	 * @param FileStorage $fileStorage
	 */
	public function __construct(RobotLoader $robotLoader, FileStorage $fileStorage)
	{
		$this->robotLoader = $robotLoader;
		$this->robotLoader->setCacheStorage($fileStorage);
	}

	/**
	 * @param $appDir
	 * @return PresenterLoader
	 */
	public function setAppDir($appDir)
	{
		$this->appDir = realpath((string)$appDir);

		return $this;
	}

	/**
	 * @param string $subDir
	 * @return PresenterLoader
	 */
	public function load($subDir = '')
	{
		$dir = $this->appDir;
		if (!empty($subDir)) {
			if (Strings::startsWith($subDir, DIRECTORY_SEPARATOR)) {
				$dir .= $subDir;
			} else {
				$dir .= DIRECTORY_SEPARATOR . $subDir;
			}
		}

		$this->robotLoader->addDirectory($dir)->register();

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
	 * @param null $namespace
	 * @return array
	 */
	public function getPresenters($namespace = null)
	{
		$classes = $this->getCLasses();

		if (count($classes)) {
			$classes = array_keys($classes);
			foreach ($classes as $k => $class) {
				if (Strings::contains($class, 'Presenter')) {
					if ($namespace !== null && !Strings::contains($class, $namespace)) {
						unset($classes[$k]);
					}
				}else{
					unset($classes[$k]);
				}
			}

			return $classes;
		}

		return array();
	}

	/**
	 * @param null $namespace
	 * @return array
	 */
	public function getPresentersName($namespace = null)
	{
		$presenters = $this->getPresenters($namespace);

		return array_map(function ($presenter) {
			return str_replace('Presenter', '', Strings::getLastPiece($presenter, '\\'));
		}, $presenters);
	}

}
