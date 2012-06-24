<?php

/**
 * Base class for all applications presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	public function startup()
	{
		parent::startup();

		if(!$this->getUser()->isAllowed($this->name, $this->view)){
			$this->redirect(':Front:Message:accessDenied');
		}
	}

	public function beforeRender()
	{
		$this->template->name = $this->context->createOptions()->getByName('name');
	}
}
