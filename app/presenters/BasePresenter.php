<?php

use Nette\Diagnostics\Debugger;

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
		$user = $this->getUser();
		$user->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('Homepage:');
	}

	public function handleSignIn()
	{
		$facebook = $this->context->facebook;

		if($facebook->getUser()){

			$authenticator = $this->context->facebookAuthenticator;
			$user = $this->getUser();

			try {

				$fb_user_data = $facebook->api('/me');

				$indentity = $authenticator->authenticate($fb_user_data);
				$user->setAuthenticator($authenticator);

				$user->login($indentity);

				$this->flashMessage('You have been signed in.');
				$this->redirect('Homepage:');

			} catch (FacebookApiException $e) {
				
				Debugger::log($e->getMessage());
			}
		}
	}

	public function handleFbSignOut()
	{
		$this->redirectUrl($this->context->facebook->getLogoutUrl(array('next' => $this->link('//signOut!'))));
	}

	public function handleFbSignIn()
	{
		$this->redirectUrl($this->context->facebook->getLoginUrl(array('scope' => 'email', 'redirect_uri' => $this->link('//signIn!'))));
	}
}
