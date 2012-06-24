<?php

namespace Model;

use Nette\Database\Connection, 
	Nette\Database\Table\Selection;

/**
* Global variables and settings
*/
class Options extends Selection
{
	
	public function __construct(Connection $c)
	{
		parent::__construct('option', $c);
	}

	public function getAll()
	{
		return $this->order('id DESC');
	}

	public function getByName($name)
	{
		$var = $this->where(array('name' => $name))->fetch();

		if($var === false){
			return null;
		}else{
			return $var->value;
		}
	}
}
?>