<?php
/**
 * Identity.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    22.07.12
 */

namespace Flame\Security;

class Identity extends \Nette\Security\Identity
{

	private $user;

	public function __construct(\Flame\Models\Users\User $user)
	{
		$this->user = $user;
		$this->user->setPassword(null);

		parent::__construct($this->user->getId(),$this->user->getRole(), $this->getUserData());

		$this->user->setInfoNull();
	}

	public function getUserModel()
	{
		return $this->user;
	}

	private function getUserData()
	{
		$userInfo = $this->user->getInfo() ? $this->user->getInfo()->toArray(): null;
		if(isset($userInfo['id'])) unset($userInfo['id']);
		$data = array('email' => $this->user->getEmail());
		if(is_array($userInfo)) $data = array_merge($data, $userInfo);
		return $data;
	}

}
