<?php

namespace Model;

use Nette\Database\Connection, 
	Nette\Database\Table\Selection;

/**
* Represents database table 'user'
*/
class Users extends Selection
{
	
	public function __construct(Connection $c)
	{
		parent::__construct('user', $c);
	}
}
?>