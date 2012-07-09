<?php

namespace Flame\Models\Security;

use Nette\Security as NS;


/**
 * Users authenticator.
 */
class Authenticator extends \Nette\Object implements NS\IAuthenticator
{
	private $users;

	public function __construct(UsersService $users)
	{
		$this->users = $users;
	}


	/**
	 * Performs an authentication
	 * @param  array
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
	    $row = $this->users->findOneBy(array('username' => $username));

	    if (!$row) {
	        throw new NS\AuthenticationException("User '$username' not found.", self::IDENTITY_NOT_FOUND);
	    }

	    if ($row->password !== $this->calculateHash($password)) {
	        throw new NS\AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
	    }

	    unset($row->password);
	    return new NS\Identity($row->id, $row->role, $row->toArray());
	}



	/**
	 * Computes salted password hash.
	 * @param  string
	 * @return string
	 */
	public function calculateHash($password)
	{
		return hash('sha512', $password);
	}

	public function setPassword($id, $password)
	{
		return $this->users->createOrUpdate(array('id' => $id, 'password' => $this->calculateHash($password)));
	}

}
