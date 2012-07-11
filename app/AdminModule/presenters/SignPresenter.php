<?php

namespace AdminModule;

use Nette\Application\UI,
    Nette\Security as NS, 
    Nette\Application\UI\Form;


class SignPresenter extends \Flame\Presenters\BasePresenter
{

    public function startup()
    {
        parent::startup();
        if($this->getUser()->isLoggedIn()){
            $this->redirect('Dashboard:');
        }
    }

	protected function createComponentSignInForm()
	{
		$form = new Form();
		$form->addText('username', 'Username:', 30, 20);
		$form->addPassword('password', 'Password:', 30);
		$form->addCheckbox('persistent', 'Remember me?');
		$form->addSubmit('login', 'Login');
		$form->onSuccess[] = callback($this, 'signInFormSubmitted');
		return $form;
	}

	public function signInFormSubmitted(Form $form)
	{
		
		try {

			$user = $this->getUser();
			$values = $form->getValues();

			//var_export($this->context->authenticator->calculateHash($values['password']));exit();
			if ($values->persistent) {
				$user->setExpiration('+30 days', FALSE);
			}

			$user->login($values->username, $values->password);
			$this->flashMessage('Login was successful', 'success');
			$this->redirect('Dashboard:');

		} catch (NS\AuthenticationException $e) {
			$form->addError('Invalid username or password');
		}
	}

}