<?php

/**
 * Base class for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	public function startup()
	{
		parent::startup();

		if(!$this->getUser()->isAllowed($this->name, $this->view)){
			$this->redirect('Message:accessDenied');
		}
	}
}
