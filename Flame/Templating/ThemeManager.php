<?php
/**
 * ThemeManager.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    06.08.12
 */

namespace Flame\Templating;

abstract class ThemeManager extends \Nette\Object
{

	/**
	 * @var array
	 */
	protected $parameters;

	/**
	 * @param array $parameters
	 * @throws \Nette\InvalidStateException
	 */
	public function __construct(array $parameters)
	{
		if (!isset($parameters['baseDir']))
			throw new \Nette\InvalidStateException(__METHOD__ . ' require set baseDir parametr.');

		$this->parameters = $parameters;
	}

	/**
	 * @return string
	 */
	public function getTheme()
	{
		return $this->getDefaultThemeFolder() . DIRECTORY_SEPARATOR . $this->getDefaultTheme();

	}

	/**
	 * @param $themeName
	 * @return bool
	 */
	protected function existTheme($themeName)
	{
		return file_exists(
			$this->getBaseDir() . DIRECTORY_SEPARATOR . $this->getDefaultThemeFolder() . DIRECTORY_SEPARATOR . $themeName);
	}

	/**
	 * @return string
	 */
	protected function getDefaultTheme()
	{
		return (isset($this->parameters['default'])) ? $this->parameters['default'] : 'default';
	}

	/**
	 * @return string
	 */
	protected function getDefaultThemeFolder()
	{
		return (isset($this->parameters['baseFolder'])) ? $this->parameters['baseFolder'] : 'themes';
	}

	/**
	 * @return mixed
	 */
	protected function getBaseDir()
	{
		return $this->parameters['baseDir'];
	}

}
