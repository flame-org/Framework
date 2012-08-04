<?php

namespace Flame\Security;

use Nette\Security as NS;


/**
 * Users authenticator.
 */
class Authenticator extends \Nette\Object implements NS\IAuthenticator
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
