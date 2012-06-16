<?php

use Nette\Application\UI,
    Nette\Security as NS;
use Nette\Application\UI\Form;


/**
 * Presenter, který se stará o přihlašování uživatelů.
 */
class SignPresenter extends BasePresenter
{

	public function startup()
	{
		parent::startup();

		if ($this->getUser()->isLoggedIn()) {
			$this->redirect('Post:');
		}
	}

	/**
	 * Vytvoří přihlašovací formulář.
	 * @return Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new Form();
		$form->addText('username', 'Uživatelské jméno:', 30, 20);
		$form->addPassword('password', 'Heslo:', 30);
		$form->addCheckbox('persistent', 'Pamatovat si mě na tomto počítači');
		$form->addSubmit('login', 'Přihlásit se');
		$form->onSuccess[] = callback($this, 'signInFormSubmitted');
		return $form;
	}



	/**
	 * Zpracuje přihlašovací formulář a přihlásí uživatele.
	 * @param Form $form
	 */
	public function signInFormSubmitted(Form $form)
	{
		try {
			$user = $this->getUser();
			$values = $form->getValues();
			if ($values->persistent) {
				$user->setExpiration('+30 days', FALSE);
			}
			$user->login($values->username, $values->password);
			$this->flashMessage('Přihlášení bylo úspěšné.', 'success');
			$this->redirect('Post:');
		} catch (NS\AuthenticationException $e) {
			$form->addError('Neplatné uživatelské jméno nebo heslo.');
		}
	}

	public function handleLoginFBUser()
	{
		$facebook = $this->context->createFacebook();
		$fb_user = $facebook->getUser();

		if($fb_user){			

			try {

				$fb_user_data = $facebook->api('/me');
				$indentity = $this->context->facebookAuthenticator->authenticate($fb_user_data);

				$this->getUser()->login($indentity);
				$this->flashMessage('Přihlášení bylo úspěšné.', 'success');
				$this->redirect('Post:');

			} catch (FacebookApiException $e) {
				
				Debugger::log($e->getMessage());
			}
		}else{
			$this->redirect($facebook->getLoginUrl(array('scope' => 'email', 'redirect_url' => $this->link('//fblogin'))));
		}
	}

}
