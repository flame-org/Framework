<?php

use Nette\Security\Permission;

/**
* ACL
*/
class Authorization extends Permission
{
	
	function __construct()
	{
		$this->addRole('guest');
		$this->addRole('moderator', 'guest');
		$this->addRole('administrator', 'moderator');
	}
}
?>