<?php

namespace Flame\Security;

use Nette\Security as NS;


/**
 * Users authenticator.
 */
class Authenticator extends \Nette\Object implements NS\IAuthenticator
{

	/**
	 * @var \Flame\Models\Users\UserFacade
	 */
	private $userFacade;

	/**
	 * @param \Flame\Models\Users\UserFacade $usersFacade
	 */
	public function __construct(\Flame\Models\Users\UserFacade $usersFacade)
	{
		$this->userFacade = $usersFacade;
	}

	/**
	 * @param array $credentials
	 * @return Identity
	 * @throws \Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($email, $password) = $credentials;
	    $user = $this->userFacade->getByEmail($email);

	    if (!$user) {
	        throw new NS\AuthenticationException("User '$email' not found.", self::IDENTITY_NOT_FOUND);
	    }

	    if ($user->password !== $this->calculateHash($password, $user->password)) {
	        throw new NS\AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
	    }

	    return new Identity($user);
	}

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
