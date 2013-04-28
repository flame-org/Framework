<?php

namespace Flame\Security;

use Nette\Object;
use Nette\Security\IAuthenticator;

/**
 * Users authenticator.
 */
abstract class Authenticator extends Object implements IAuthenticator
{

	/**
	 * @param $password
	 * @param $salt
	 * @return string
	 */
	public function calculateHash($password, $salt = null)
	{
		if ($salt === null) {
			$salt = '$2a$07$' . md5(uniqid(time())) . '$';
		}

		return crypt($password, $salt);
	}

}
