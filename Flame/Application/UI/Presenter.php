<?php
/**
 * Presenter
 *
 * @author  Jiří Šifalda
 * @package Flame
 *
 * @date    14.07.12
 */

namespace Flame\Application\UI;

abstract class Presenter extends \Nette\Application\UI\Presenter
{
	public function startup()
	{
		parent::startup();
	}

	public function beforeRender()
	{
		parent::beforeRender();

		$this->template->name = $this->context->OptionFacade->getOptionValue('name');

		if($this->isAjax()){
			$this->invalidateControl('flashMessages');
		}
	}

	public function createTemplate($class = null)
	{
		$template = parent::createTemplate($class);
		$template->registerHelperLoader(callback(
			$this->context->Helpers,
			'loader'
		));
		return $template;
	}
}
