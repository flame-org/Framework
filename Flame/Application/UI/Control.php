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
	public function __construct(\Nette\ComponentModel\IContainer $parent, $name)
	{
		parent::__construct($parent, $name);
	}

	public function createTemplate($class = null)
	{
		$template = parent::createTemplate($class);
		$template->registerHelperLoader(callback(
			new \Flame\Templates\Helpers($this->getContextParameter('imageStorage')),
			'loader'
		));
		return $template;
	}

	public function getSession()
	{
		return $this->getPresenter()->getSession();
	}

	private function getContext()
	{
		return $this->getPresenter()->getContext();
	}

	protected function getContextParameter($name = null)
	{
		$params = $this->getContext()->getParameters();
		return (isset($params[$name])) ? $params[$name] : null;
	}

}
