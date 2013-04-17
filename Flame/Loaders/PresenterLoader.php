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
	 * @param \Nette\Caching\Storages\FileStorage $fileStorage
	 */
	public function __construct(
		\Nette\Loaders\RobotLoader $robotLoader,
		\Nette\Caching\Storages\FileStorage $fileStorage
	)
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
			$classes = array_map(function ($class) use ($namespace) {
				if (Strings::contains($class, 'Presenter')) {
					if ($namespace === null) {
						return $class;
					} else {
						if (Strings::contains($class, $namespace))
							return $class;
					}
				}

			}, $classes);

			return \Flame\Utils\Arrays::getValidValues($classes);
		} else {
			return array();
		}
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
