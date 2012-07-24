<?php
/**
 * UserForm.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    18.07.12
 */

namespace Flame\Forms;

class UserForm extends \Flame\Application\UI\Form
{
	private $editForm = false;

	public function configureAdd()
	{

		$this->addText('email', 'EMAIL:', 60)
			->addRule(self::MAX_LENGTH, null, 100)
			->addRule(self::EMAIL);

		$this->configurePassword();

		$this->addSubmit('create', 'Create new account');
	}

	public function configureAddFull()
	{
		$this->configureFull();
		$this->configurePassword();
		$this->addSubmit('create', 'Create new account');
	}

	public function configureEditFull(array $defaults)
	{
		$this->editForm = true;

		$this->configureFull();
		$this->setDefaults($defaults);
		$this->addSubmit('edit', 'Edit');
	}

	public function configureRoles()
	{
		$this->addSelect('role', 'Role:')
			->setItems(array('user', 'moderator', 'administrator'), false);
	}

	private function configureFull()
	{
		$this->addText('name', 'Name:', 60)
			->addRule(self::MAX_LENGTH, null, 150);

		$this->addTextArea('about', 'About:', 60, 5)
			->addRule(self::MAX_LENGTH, null, 250);

		$this->addDatePicker('birthday', 'Birthday:')
			->setDefaultValue(new \DateTime())
			->addRule(self::VALID, 'Entered date is not valid');

		$this->addText('web', 'Web:', 60)
			->addRule(self::MAX_LENGTH, null, 150);

		$this->addText('facebook', 'Facebook:', 60)
			->addRule(self::MAX_LENGTH, null, 100);

		$this->addText('twitter', 'Twitter:', 60)
			->addRule(self::MAX_LENGTH, null, 100);

		if($this->editForm){
			$this->addText('email', 'EMAIL:', 60)
				->addRule(self::MAX_LENGTH, null, 100)
				->addRule(self::EMAIL)
				->controlPrototype->readonly = 'readonly';
		}else{
			$this->addText('email', 'EMAIL:', 60)
				->addRule(self::MAX_LENGTH, null, 100)
				->addRule(self::EMAIL);
		}
	}

	private function configurePassword()
	{
		$this->addPassword('password', 'Password:', 60)
			->addRule(self::FILLED);

		$this->addPassword('passwordTwo', 'Password (check):', 60)
			->addRule(self::EQUAL, 'Entered passwords is not equal. Try it again.', $this['passwordTwo']);
	}

}
