<?php

use Nette\Application\UI,
    Nette\Security as NS, 
    Nette\Application\UI\Form,
    Nette\Diagnostics\Debugger;


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
			$authenticator = $this->context->authenticator;

			$user = $this->getUser();
			$user->setAuthenticator($authenticator);
			
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

			$authenticator = $this->context->facebookAuthenticator;
			$user = $this->getUser();

			try {

				$fb_user_data = $facebook->api('/me');

				$indentity = $authenticator->authenticate($fb_user_data);
				$user->setAuthenticator($authenticator);

				$user->login($indentity);
				$this->flashMessage('Přihlášení bylo úspěšné.', 'success');
				$this->redirect('Post:');

			} catch (FacebookApiException $e) {
				
				Debugger::log($e->getMessage());
			}
		}else{
			$login_url = $facebook->getLoginUrl(array('scope' => 'email', 'redirect_url' => $this->link('//fblogin')));

			$this->redirect($this->link($login_url));
		}
	}

}
