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

	public function configureAdd()
	{
		$this->configure();

		$this->addSubmit('add', 'Create');
	}

	private function configure()
	{
		$this->addText('username', 'Username:', 60)
			->addRule(self::FILLED)
			->addRule(self::MAX_LENGTH, null, 35);

		$this->addPassword('password', 'Password:', 60)
			->addRule(self::FILLED);

		$this->addSelect('role', 'Role:')
			->setItems(array('user', 'moderator', 'administrator'), false);

		$this->addText('name', 'Name:', 60)
			->addRule(self::MAX_LENGTH, null, 150);

		$this->addText('email', 'EMAIL:', 60)
			->addRule(self::MAX_LENGTH, null, 100)
			->addRule(self::EMAIL)
			->addRule(self::FILLED);
	}

}
