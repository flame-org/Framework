<?php
/**
 * CompilerExtension.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    23.08.12
 */

namespace Flame\Module;

use Nette\Utils\Finder;

class LoadModule extends \Nette\Object
{
	
	/**
	 * @param $name
	 * @param $class
	 * @return array
	 * @throws ModuleReflectionException
	 */
	public function load($name, $class)
	{

		$module = array();
		$module['name'] = $name;
		$module['class'] = $class;
		$module['path'] = $this->getModulePath($name);
		$module['namespace'] = $this->getModuleNamespace($class);

		foreach (Finder::findFiles("*.php")->from($module['path']) as $file) {

			$relative = $file->getRealpath();
			$relative = strtr($relative, array($module['path'] => '', '/' => '\\'));
			$class = $module['namespace'] . '\\' . ltrim(substr($relative, 0, -4), '\\');
			$class = str_replace("presenters\\", "", $class);

			try{

				$refl = \Nette\Reflection\ClassType::from($class);
				$module['classes'][] = $class;

			}catch (\ReflectionException $ex){
				throw new ModuleReflectionException($ex->getMessage());
			}
		}

		foreach (Finder::findFiles("*.neon")->from($module['path']) as $file) {
			$module['configs'] = $file->getRealpath();
		}

		return $module;
	}

	private function getModulePath($name)
	{
		return realpath(APP_DIR . '/modules/' . $name);
	}

	private function getModuleNamespace($class)
	{
		$parts = explode('\\', $class);
		if(isset($parts[count($parts) - 1])) unset($parts[count($parts) - 1]);
		return implode('\\', $parts);
	}

	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();
		$config = $this->getConfig();



		/* services */
		foreach ($this->classes[self::MODULE] as $class => $name) {
			$this->compileModule($class, $this->prefix($name));
		}
	}

}
