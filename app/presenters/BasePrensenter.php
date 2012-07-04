<?php

/**
 * Base class for all applications presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	public function startup()
	{
		parent::startup();
	}

	public function beforeRender()
	{
		$this->template->name = $this->context->options->getOptionValue('name');

		if($this->isAjax()){
			$this->invalidateControl('flashMessages');
		}
	}
}
