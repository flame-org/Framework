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
