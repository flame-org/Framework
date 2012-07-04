<?php

namespace AdminModule;

use Nette\Application\UI\Form;
use Nette\Security as NS;


class UserPresenter extends AdminPresenter
{

	public function actionDefault()
	{
		$this->template->users = $this->context->users->findAll();
	}

	protected function createComponentAddUserForm($name)
	{
		$f = new Form($this, $name);
		$f->addText('username', 'Username:', 60)
			->addRule(FORM::FILLED, 'Username is required.')
			->addRule(FORM::MAX_LENGTH, 'Username must be shorter than 35 chars.', 35);

		$f->addText('password', 'Password:', 60)
			->addRule(FORM::FILLED, 'Password is required.');

		$f->addSelect('role', 'Role:')
			->setItems(array('user', 'moderator', 'administrator'), false);

		$f->addText('name', 'Name:', 60)
			->addRule(FORM::MAX_LENGTH, 'Name must be shorten than 150 chars.', 150);

		$f->addText('email', 'EMAIL:', 60)
			->addRule(FORM::MAX_LENGTH, 'EMAIL must be shorten than 100 chars.', 100)
			->addRule(FORM::FILLED, 'EMAIL is required.');

		$f->addSubmit('add', 'Create');
		$f->onSuccess[] = callback($this, 'addUserFormSubmited');
	}

	public function addUserFormSubmited(Form $form)
	{
		$values = $form->getValues();
		$service = $this->context->users;

		if($service->findOneBy(array('username' => $values['username']))){
			$form->addError('Username exist yet.');
		}elseif($service->findOneBy(array('email' => $values['email']))){
			$form->addError('Email exist yet.');
		}else{
			$service->createOrUpdate(
				array(
					'username' => $values['username'],
					'role' => $values['role'],
					'email' => $values['email'],
					'name' => $values['name'],
					'password' => $this->context->authenticator->calculateHash($values['password']),
				)
			);

			$this->flashMessage('User was added');
			$this->redirect('this');
		}
	}

	protected function createComponentPasswordForm($name)
	{
		$form = new Form($this, $name);
		$form->addPassword('oldPassword', 'Staré heslo:', 30)
			->addRule(Form::FILLED, 'Je nutné zadat staré heslo.');
		$form->addPassword('newPassword', 'Nové heslo:', 30)
			->addRule(Form::MIN_LENGTH, 'Nové heslo musí mít alespoň %d znaků.', 6);
		$form->addPassword('confirmPassword', 'Potvrzení hesla:', 30)
			->addRule(Form::FILLED, 'Nové heslo je nutné zadat ještě jednou pro potvrzení.')
			->addRule(Form::EQUAL, 'Zadná hesla se musejí shodovat.', $form['newPassword']);
		$form->addSubmit('set', 'Change password');
		$form->onSuccess[] = callback($this, 'passwordFormSubmited');
	}


	public function passwordFormSubmited(Form $form)
	{
		$values = $form->getValues();
		$user = $this->getUser();

		try {
			$this->context->authenticator->authenticate(array($user->getIdentity()->username, $values->oldPassword));
			$this->context->authenticator->setPassword($user->getId(), $values->newPassword);
			$this->flashMessage('Password was changed.', 'success');
			$this->redirect('this');
		} catch (NS\AuthenticationException $e) {
			$form->addError('Invalid credentials');
		}
	}

	public function handleDelete($id)
	{	
		if($this->getUser()->getId() == $id){
			$this->flashMessage('You cannot delete yourself');
		}elseif(!$this->getUser()->isAllowed('Admin:User', 'delete')){
			$this->flashMessage('Access denied');
		}else{
			$row = $this->context->users->find($id);

			if(!$row){
				$this->flashMessage('User with required ID does not exist');
			}else{
				$row->delete();
			}
		}

		if(!$this->isAjax()){
			$this->redirect('this');
		}else{
			$this->invalidateControl('users');
		}
	}
}