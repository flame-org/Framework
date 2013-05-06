<?php
/**
 * Class BundlesLoader
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 28.04.13
 */
namespace Flame\Bundles\Loaders;

use Nette\Loaders\RobotLoader;
use Nette\Object;
use Nette\Reflection\ClassType;

class BundlesLoader extends Object
{

	const BUNDLE_NAMESPACE = '\Flame\Bundles\IBundle';

	/** @var \Nette\Loaders\RobotLoader */
	private $robotLoader;

	/** @var array */
	private $bundles = array();

	/**
	 * @param RobotLoader $robotLoader
	 */
	public function __construct(RobotLoader $robotLoader)
	{
		$this->robotLoader = $robotLoader;
	}

	/**
	 * @return array
	 */
	public function getIndexedClasses()
	{
		return $this->robotLoader->getIndexedClasses();
	}

	/**
	 * @return array
	 */
	public function getBundlesClasses()
	{
		if (!count($this->bundles)) {
			$classes = $this->getIndexedClasses();
			if (count($classes)) {
				foreach ($classes as $class => $path) {
					$classReflection = ClassType::from($class);
					if ($classReflection->is(self::BUNDLE_NAMESPACE)) {
						$this->bundles[] = $classReflection->newInstance();
					}
				}
			}
		}

		return $this->bundles;
	}

}