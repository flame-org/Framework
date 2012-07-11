<?php

namespace Flame\Presenters;

/**
 * Base class for all applications presenters.
 */
abstract class BasePresenter extends \Nette\Application\UI\Presenter
{

	public function startup()
	{
		parent::startup();
	}

	public function beforeRender()
	{
        $this->template->name = $this->context->OptionFacade->getOptionValue('name');

		if($this->isAjax()){
			$this->invalidateControl('flashMessages');
		}
	}

//	protected function createTemplate($class = null)
//	{
//		$template = parent::createTemplate($class);
//		$template->registerHelperLoader('\Flame\Utils\Helpers::loader');
//		return $template;
//	}
}
