<?php

/**
 * Base class for all application presenters.
 *
 * @author     John Doe
 * @package    MyApplication
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	public function beforeRender()
	{
		
	}

	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('Sign:in');
	}
}
