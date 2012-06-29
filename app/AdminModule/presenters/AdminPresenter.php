<?php

namespace AdminModule;

use Nette\Security as NS;

/**
 * Base class for all applications presenters.
 */
abstract class AdminPresenter extends \BasePresenter
{

	public function startup()
	{
		parent::startup();
		
		$user = $this->getUser();

		if(!$user->isLoggedIn()){
			if ($user->logoutReason === NS\User::INACTIVITY) {
                $this->flashMessage('You was logout for the users INACTIVITY. Please login again.');
            }
            $backlink = $this->application->storeRequest();
            $this->redirect('Sign:in', array('backlink' => $backlink));
		}else{
			if(!$user->isAllowed($this->name, $this->view)){
				$this->flashMessage('Access denited');
				$this->redirect('Dashboard:');
			}
		}
	}

	public function beforeRender()
	{
		parent::beforeRender();
	}

	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('Sign:in');
		
	}
}
