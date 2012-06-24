<?php

namespace Model;

use Nette\Database\Table\Selection, Nette\Database\Connection;

/**
* Comments model
*/
class Comments extends Selection
{
	
	function __construct(Connection $c)
	{
		parent::__construct('comment', $c);
	}

	public function get($id)
	{
		return $this->where(array('id_post' => $id, 'publish' => '1'))->order('id DESC');
	}

	public function getAll()
	{
		return $this->order('id DESC');
	}

	public function getUnPublish()
	{
		return $this->where(array('publish' => '0'))->order('id DESC');
	}
}
?>