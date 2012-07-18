<?php
/**
 * ChangePasswordForm.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    18.07.12
 */

namespace Flame\Forms;

class ChangePasswordForm extends \Flame\Application\UI\Form
{

	public function configure()
	{
		$this->addPassword('oldPassword', 'Current password:', 30)
			->addRule(self::FILLED);
		$this->addPassword('newPassword', 'New password:', 30)
			->addRule(self::MIN_LENGTH, null, 6);
		$this->addPassword('confirmPassword', 'New password (verify):', 30)
			->addRule(self::FILLED)
			->addRule(self::EQUAL, 'Entered passwords is not equal. Try it again.', $this['newPassword']);
		$this->addSubmit('set', 'Change password');
	}
}
