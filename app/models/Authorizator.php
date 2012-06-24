<?php

use Nette\Security as NS;

/**
* ACL
*/
class Authorizator extends NS\Permission implements NS\IAuthorizator
{
	public function __construct()
	{
		//DEFINE ROLES
		$this->addRole('guest');
		$this->addRole('user', 'guest');
		$this->addRole('moderator', 'user');
		$this->addRole('administrator', 'moderator');
		$this->addRole('root', 'administrator');

		//DEFINE FRONT RESOURCE
		$this->addResource('Front:Homepage');
		$this->addResource('Front:Message');
		$this->addResource('Front:Post');

		//DEFINE ADMIN RESOURCE
		$this->addResource('Admin:Dashboard');
		$this->addResource('Admin:Sign');
		$this->addResource('Admin:Option');
		$this->addResource('Admin:Post');
		$this->addResource('Admin:User');
		$this->addResource('Admin:Comment');

		$this->allow('guest', array('Front:Homepage'));
		$this->allow('guest', array('Front:Message'));
		$this->allow('guest', array('Admin:Sign'), array('in'));
		$this->allow('guest', array('Front:Post'), array('detail'));

		$this->allow('user', array('Admin:User'), array('password'));

		//DEFINE ADMIN MODERATORS ACCESS
		$this->allow('moderator', array('Admin:Dashboard', 'Admin:Post'));
		$this->allow('moderator', array('Admin:Post'));
		$this->allow('moderator', array('Admin:Comment'), array('delete', 'publish', 'default'));

		//DEFINE ADMIN ADMINISTRATORS ACCESS
		$this->allow('administrator', array('Admin:Option'));
		$this->allow('administrator', array('Admin:User'));
		
		$this->allow('root', NS\Permission::ALL);
	}
	
}
?>