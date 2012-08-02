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

	public function createTemplate($class = null)
	{
		$template = parent::createTemplate($class);
		$template->registerHelperLoader(callback(new \Flame\Utils\Helpers($this->getContextParameter('imageStorage')), 'loader'));
		return $template;
	}

	private function getContext()
	{
		return $this->getPresenter()->getContext();
	}

	protected function getContextParameter($name = null)
	{
		$params = $this->getContext()->getParameters();
		if(isset($params[$name])) return $params[$name]; else return null;
	}

}
