<?php
/**
 * Control
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    14.07.12
 */

namespace Flame\Application\UI;

abstract class Control extends \Nette\Application\UI\Control
{
	/**
	 * @param \Nette\ComponentModel\IContainer $parent
	 * @param null $name
	 */
	public function __construct(\Nette\ComponentModel\IContainer $parent, $name)
	{
		parent::__construct($parent, $name);
	}

	/**
	 * @param null $class
	 * @return \Nette\Templating\ITemplate
	 */
	public function createTemplate($class = null)
	{
		$template = parent::createTemplate($class);
		$template->registerHelperLoader(callback(
			new \Flame\Templates\Helpers($this->getContextParameter('imageStorage')),
			'loader'
		));
		return $template;
	}

	/**
	 * @return \Nette\Http\Session
	 */
	public function getSession()
	{
		return $this->getPresenter()->getSession();
	}

	/**
	 * @return \Nette\DI\Container|\SystemContainer
	 */
	private function getContext()
	{
		return $this->getPresenter()->getContext();
	}

	/**
	 * @param null $name
	 * @return null
	 */
	protected function getContextParameter($name = null)
	{
		$params = $this->getContext()->getParameters();
		return (isset($params[$name])) ? $params[$name] : null;
	}

}
