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

class ThemeManager extends \Nette\Object
{
	/**
	 * @var array
	 */
	protected $parameters;

	/**
	 * @param array $parameters
	 */
	public function __construct(array $parameters)
	{
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
	 * @param $path
	 * @return bool
	 */
	protected function existTheme($path)
	{
		return file_exists($path);
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

}
