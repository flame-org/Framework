<?php
	
	use Nette\Database\Connection, Nette\Database\Table\Selection;

	/**
	* 
	*/
	class UsersModel extends Selection
	{
		
		public function __construct(Connection $c)
		{
			parent::__construct('user', $c);
		}
	}
?>