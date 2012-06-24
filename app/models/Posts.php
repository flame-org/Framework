<?php

namespace Model;

use Nette\Database\Table\Selection, 
	Nette\Database\Connection, 
	Nette\Database\SqlLiteral;

/**
* Post model
*/
class Posts extends Selection
{
	
	function __construct(Connection $c)
	{
		parent::__construct('post', $c);
	}

	public function getDetail($id)
	{
		$post = $this->where(array('id' => $id, 'publish' => '1'))->limit(1)->fetch();
		return $post;
		
	}

	public function get($limit = null, $offset = null)
	{
		$posts = $this->where(array('publish' => '1'))->order('id DESC')->limit($limit, $offset);
		return $posts;
	}

	public function getByUser($username, $id = null)
	{	
		if(!is_null($id)){
			return $this->where(array('user' => $username, 'id' => $id))->order('id DESC')->limit(1)->fetch();
		}else{
			return $this->where(array('user' => $username))->order('id DESC');
		}
	}

	public function getToEdit($id)
	{
		return $this->where(array('id' => $id))->limit(1)->fetch();
	}

	public function updateHit($id)
	{
		return $this->where(array('id' => $id))->update(array('hit' => new SqlLiteral('hit +1')));
	}

	public function getPages()
	{
		return $this->where(array('publish' => '1', 'page' => '1'))->order('id DESC');
	}

	public function getNameByID($id)
	{
		return $this->where(array('id' => $id))->fetchPairs('id', 'name');
	}
}
