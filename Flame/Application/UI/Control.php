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
	
	public function render()
	{
		$this->template->render();
	}

	/**
	 * @param null $class
	 * @return \Nette\Templating\ITemplate
	 */
	public function createTemplate($class = null)
	{
		$template = parent::createTemplate($class);
		$template->registerHelperLoader(callback(new \Flame\Templates\Helpers, 'loader'));
		return $template;
	}
}
