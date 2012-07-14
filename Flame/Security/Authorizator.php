<?php

namespace Flame\Security;

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
		$this->addResource('Front:Newsreel');
        $this->addResource('Front:Page');

		//DEFINE ADMIN RESOURCE
		$this->addResource('Admin:Dashboard');
		$this->addResource('Admin:Sign');
		$this->addResource('Admin:Option');
		$this->addResource('Admin:Post');
		$this->addResource('Admin:User');
		$this->addResource('Admin:Comment');
		$this->addResource('Admin:Image');
		$this->addResource('Admin:Page');
		$this->addResource('Admin:Newsreel');

        //DEFINE ADMIN GUEST ACCESS
		$this->allow('guest', array('Front:Homepage', 'Front:Newsreel', 'Front:Page'));
		$this->allow('guest', array('Front:Message'));
		$this->allow('guest', array('Front:Post'), array('default'));

        //DEFINE FRONT GUEST ACCESS
        $this->allow('guest', array('Admin:Sign'), array('in'));

        //DEFINE ADMIN USERS ACCESS
		$this->allow('user', array('Admin:User'), array('password'));

		//DEFINE ADMIN MODERATORS ACCESS
		$this->allow('moderator', array('Admin:Dashboard', 'Admin:Post', 'Admin:Image', 'Admin:Page', 'Admin:Newsreel'));
		$this->allow('moderator', array('Admin:Comment'), array('delete', 'publish', 'default'));

		//DEFINE ADMIN ADMINISTRATORS ACCESS
		$this->allow('administrator', array('Admin:Option'), array('default', 'delete', 'add', 'edit'));
		$this->allow('administrator', array('Admin:User'));

        //DEFINE ROOT PERMISSION
		$this->allow('root', NS\Permission::ALL);
	}
	
}
?>