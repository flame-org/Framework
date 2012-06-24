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
			$this->redirect('Message:accessDenied');
		}
	}

	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('Homepage:');
		
	}

	public function beforeRender()
	{
		$this->template->userMenus = $this->generateUserMenu();
		$this->template->menus = $this->context->createPosts()->getPages();

		$this->template->name = $this->context->createOptions()->getByName('name');
	}

	private function generateUserMenu()
	{
		$menu = array(
			array('Post', 'default', 'příspěvky'),
			array('Option', 'default', 'nastavení'),
		);

		$menu_allowed = array();

		foreach ($menu as $key => $value) {
			
			if($this->getUser()->isAllowed($value[0], $value[1])){
				$menu_allowed[] = array($this->link($value[0] . ':' . $value[1]), $value[2]);
			}
		}

		if($this->getUser()->isLoggedIn()){
			$menu_allowed[] = array($this->link('signOut!'), 'odhlásit se');
		}else{
			$menu_allowed[] = array($this->link('Sign:in'), 'přihlásit se');
		}

		return $menu_allowed;
	}
}
