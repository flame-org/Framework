<?php

use Nette\Security as NS;

/**
* ACL
*/
class Authorizator extends NS\Permission implements NS\IAuthorizator
{
	public function __construct()
	{
		$this->addRole('guest');
		$this->addRole('user', 'guest');
		$this->addRole('moderator', 'user');
		$this->addRole('administrator', 'moderator');
		$this->addRole('root', 'administrator');

		$this->addResource('Homepage');
		$this->addResource('Message');
		$this->addResource('Post');
		$this->addResource('Sign');
		$this->addResource('Option');

		$this->allow('guest', array('Homepage'), 'default');
		$this->allow('guest', array('Message', 'Sign'));
		$this->allow('guest', array('Post'), array('detail'));

		$this->allow('moderator', array('Post'), array('default', 'add', 'edit', 'delete'));

		$this->allow('administrator', array('Option'));
		
		$this->allow('root', NS\Permission::ALL);
	}
	
}
?>