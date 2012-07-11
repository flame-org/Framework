<?php

namespace AdminModule;

use Nette\Application\UI\Form,
    Nette\Security as NS,
    Flame\Models\Users\User;


class UserPresenter extends AdminPresenter
{
    private $userFacade;

    private $authenticator;

    public function __construct(\Flame\Models\Users\UserFacade $userFacade, \Flame\Models\Security\Authenticator $authenticator)
    {
        $this->userFacade = $userFacade;
        $this->authenticator = $authenticator;
    }

	public function actionDefault()
	{
		$this->template->users = $this->userFacade->getLastUsers();
	}

	protected function createComponentAddUserForm()
	{
		$f = new Form;
		$f->addText('username', 'Username:', 60)
			->addRule(FORM::FILLED, 'Username is required.')
			->addRule(FORM::MAX_LENGTH, 'Username must be shorter than %d chars.', 35);

		$f->addPassword('password', 'Password:', 60)
			->addRule(FORM::FILLED, 'Password is required.');

		$f->addSelect('role', 'Role:')
			->setItems(array('user', 'moderator', 'administrator'), false);

		$f->addText('name', 'Name:', 60)
			->addRule(FORM::MAX_LENGTH, 'Name must be shorten than %d chars.', 150);

		$f->addText('email', 'EMAIL:', 60)
			->addRule(FORM::MAX_LENGTH, 'EMAIL must be shorten than %d chars.', 100)
			->addRule(FORM::FILLED, 'EMAIL is required.');

		$f->addSubmit('add', 'Create');
		$f->onSuccess[] = callback($this, 'addUserFormSubmitted');

        return $f;
	}

	public function addUserFormSubmitted(Form $form)
	{
		$values = $form->getValues();

		if($this->userFacade->getByUsername($values['username'])){
			$form->addError('Username exist yet.');
		}elseif($this->userFacade->getByEmail($values['email'])){
			$form->addError('Email exist yet.');
		}else{
			$user = new \Flame\Models\Users\User(
                $values['username'],
                $this->authenticator->calculateHash($values['password']),
                $values['role'],
                $values['name'],
                $values['email']
			);

            $this->userFacade->persist($user);

			$this->flashMessage('User was added');
			$this->redirect('this');
		}
	}

	protected function createComponentPasswordForm()
	{
		$form = new Form;
		$form->addPassword('oldPassword', 'Current password:', 30)
			->addRule(Form::FILLED, 'Current password is required');
		$form->addPassword('newPassword', 'New password:', 30)
			->addRule(Form::MIN_LENGTH, 'New password must be longer than %d chars.', 6);
		$form->addPassword('confirmPassword', 'New password (verify):', 30)
			->addRule(Form::FILLED, 'New password is required for verify.')
			->addRule(Form::EQUAL, 'Entered passwords is not equal. Try it again.', $form['newPassword']);
		$form->addSubmit('set', 'Change password');
		$form->onSuccess[] = callback($this, 'passwordFormSubmitted');

        return $form;
	}


	public function passwordFormSubmitted(Form $form)
	{
		$values = $form->getValues();
		$user = $this->getUser();

		try {
			$this->authenticator->authenticate(array($user->getIdentity()->username, $values->oldPassword));

            $userEntity = $this->userFacade->getOne($user->getId());
            $this->authenticator->setPassword($userEntity, $values['newPassword']);

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
			$user = $this->userFacade->getOne((int) $id);

			if(!$user){
				$this->flashMessage('User with required ID does not exist');
			}else{
				$this->userFacade->delete($user);
			}
		}

		if(!$this->isAjax()){
			$this->redirect('this');
		}else{
			$this->invalidateControl('users');
		}
	}
}