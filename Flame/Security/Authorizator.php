<?php

namespace Flame\Security;

use Nette\Security as NS;

/**
* ACL
*/
class Authorizator extends NS\Permission implements NS\IAuthorizator
{

	const GUEST = 'guest';

	const USER = 'user';

	const MODERATOR = 'moderator';

	const ADMINISTRATOR = 'administrator';

	const ROOT = 'root';

	public function __construct()
	{
		//DEFINE ROLES
		$this->addRole(self::GUEST);
		$this->addRole(self::USER, self::GUEST);
		$this->addRole(self::MODERATOR, self::USER);
		$this->addRole(self::ADMINISTRATOR, self::MODERATOR);
		$this->addRole(self::ROOT, self::ADMINISTRATOR);

		//DEFINE FRONT RESOURCE
		$this->addResource('Front:Homepage');
		$this->addResource('Front:Message');
		$this->addResource('Front:Post');
		$this->addResource('Front:Newsreel');
        $this->addResource('Front:Page');
		$this->addResource('Front:Category');
		$this->addResource('Front:Tag');

		//DEFINE ADMIN RESOURCE
		$this->addResource('Admin:Tag');
		$this->addResource('Admin:Category');
		$this->addResource('Admin:Dashboard');
		$this->addResource('Admin:Sign');
		$this->addResource('Admin:Option');
		$this->addResource('Admin:Post');
		$this->addResource('Admin:User');
		$this->addResource('Admin:Comment');
		$this->addResource('Admin:Image');
		$this->addResource('Admin:Page');
		$this->addResource('Admin:Newsreel');
		$this->addResource('Admin:Import');

        //DEFINE ADMIN GUEST ACCESS
		$this->allow(self::GUEST, array(
			'Front:Homepage',
			'Front:Newsreel',
			'Front:Page',
			'Front:Post',
			'Front:Message',
			'Front:Category',
			'Front:Tag'
		));

        //DEFINE FRONT GUEST ACCESS
        $this->allow(self::GUEST, array('Admin:Sign'), array('in'));

        //DEFINE ADMIN USERS ACCESS
		$this->allow(self::USER, array('Admin:User'), array('password', 'edit'));

		//DEFINE ADMIN MODERATORS ACCESS
		$this->allow(self::MODERATOR, array(
			'Admin:Dashboard',
			'Admin:Post',
			'Admin:Image',
			'Admin:Page',
			'Admin:Newsreel',
			'Admin:Tag',
			'Admin:Category',
			'Admin:Comment'
		));

		//DEFINE ADMIN ADMINISTRATORS ACCESS
		$this->allow(self::ADMINISTRATOR, array('Admin:User', 'Admin:Import', 'Admin:Option'));

        //DEFINE ROOT PERMISSION
		$this->allow(self::ROOT, NS\Permission::ALL);
	}

}
