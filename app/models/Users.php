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

	public function getAll()
	{
		return $this->order('id DESC');
	}

	public function existUsername($username)
	{
		return $this->where(array('username' => $username))->fetch();
	}

	public function existEmail($email)
	{
		return $this->where(array('email' => $email))->fetch();
	}

	public function getByID($id)
	{
		return $this->where(array('id' => $id));
	}
}
?>