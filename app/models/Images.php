<?php

namespace Model;

use Nette\Database\Connection, 
	Nette\Database\Table\Selection;

/**
* Images model
*/
class Images extends Selection
{
	
	function __construct(Connection $c)
	{
		parent::__construct('image', $c);
	}

	public function getAll()
	{
		return $this->order('id DESC');
	}

	private function getByUser($username)
	{
		return $this->where(array('user' => $user))->order('id DESC');
	}
}
?>